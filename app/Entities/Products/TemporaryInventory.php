<?php
	/**
	 * Created by PhpStorm.
	 * User: Anwar Sarmiento Ramo
	 * Date: 15/9/2018
	 * Time: 11:42:PM
	 */
	
	namespace App\Entities\Products;
	
	
	use App\Entities\Entity;
	
	class TemporaryInventory extends Entity
	{
		protected $table = 'temporary_inventories';
		
		protected $fillable = ['product_id','stock','branch'];
		
		public function product()
		{
			return $this->belongsTo(Product::class);
		}
	}