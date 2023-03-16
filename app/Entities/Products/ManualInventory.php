<?php
	/**
	 * Created by PhpStorm.
	 * User: Anwar Sarmiento Ramo
	 * Date: 15/9/2018
	 * Time: 11:43:PM
	 */

	namespace App\Entities\Products;


	use App\Entities\General\User;
  use App\Entities\Entity;

	class ManualInventory extends Entity
	{
		protected $table = 'manual_inventories';
		protected $fillable = ['sysconf_id','date','branch_office_id','user_id'];


		public $timestamps = true;


    public function scopeSearch($query, $search)
    {
      if (trim($search) != "")
      {
        $query->orWhere("date", "LIKE", "%$search%");
      }

    }

    public function user()
    {
      return $this->belongsTo(User::class);
    }

    /**
     * -----------------------------------------------------------------------
     * @Author     : Anwar Sarmiento <asarmiento@sistemasamigableslatam.com>
     * @DateCreate : 31/1/2019
     * @TimeCreate : 09:35:AM
     * @DateUpdate : 0000-00-00
     * -----------------------------------------------------------------------
     * @description:
     * @steps      :
     * ----------------------------------------------------------------------
     * @var
     * ----------------------------------------------------------------------
     * @return void
     *
     * ----------------------------------------------------------------------
     *
     */
    public function detailManualInventory()
    {
      return $this->hasMany(DetailManualInventory::class)->whereHas('product',function ($p){
        $p->orderBy('description','ASC');
      });
    }
	}
