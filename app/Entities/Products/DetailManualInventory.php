<?php
	/**
	 * Created by PhpStorm.
	 * User: Anwar Sarmiento Ramo
	 * Date: 15/9/2018
	 * Time: 11:45:PM
	 */

	namespace App\Entities\Products;


	use App\Entities\Entity;

	class DetailManualInventory extends Entity
	{
		protected $table = 'detail_manual_inventories';
		protected $fillable=['manual_inventory_id','product_id','previous_stock','stock'];

    public function product()
    {
      return $this->belongsTo(Product::class)->orderBy('description','ASC');
		}
	}
