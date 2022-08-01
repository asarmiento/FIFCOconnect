<?php
	/**
	 * Created by PhpStorm.
	 * User: Anwar Sarmiento Ramo
	 * Date: 22/6/2018
	 * Time: 04:01:AM
	 */

	namespace App\Entities\Inventory;


	use App\Entities\Entity;

	class DetailManualInventory extends Entity
	{
		protected $fillable = ['manual_inventory_id', 'product_id', 'stock', 'previous_stock'];
	}
