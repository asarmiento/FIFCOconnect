<?php
	/**
	 * Created by PhpStorm.
	 * User: Anwar
	 * Date: 31/10/2017
	 * Time: 09:42 PM
	 */

	namespace App\Entities\Products;


	use App\Entities\Entity;

	class SaleMethod extends Entity
	{
	  protected $table = 'sale_methods';
		protected $fillable = array('name','code','service');

		protected $guarded = array('id');

		public function product()
		{
			return $this->hasMany(Product::class);
		}
		public static function listsLabel()
		{
			$saleMethods = SaleMethod::all();
			$lists =[];
			foreach ($saleMethods AS $saleMethod){
				array_push($lists,['label'=>$saleMethod->name,'value'=>$saleMethod->id]);
			}

			return $lists;
		}

	}
