<?php
	/**
	 * Created by PhpStorm.
	 * User: Anwar Sarmiento Ramo
	 * Date: 6/8/2018
	 * Time: 10:22:AM
	 */
	
	namespace App\Entities\Products;
	
	
	use App\Entities\Entity;
	use App\Entities\Invoices\InvoiceTemp;
	
	class ProductsTemp extends Entity
	{
		protected $table = "product_temps";
		
		protected $fillable = ['amount','code_iva', 'amount_before', 'stocks', 'inventory_id', 'cid', 'code', 'cost', 'discount','tariff_iva',
			'discount_per_lot', 'price','description', 'product_id', 'sale_price', 'note', 'tax_included', 'total', 'temp_invoice_id' ];
		
		public function product()
		{
			return $this->belongsTo(Product::class);
		}
		
		public function invoice()
		{
			return $this->belongsTo(InvoiceTemp::class);
		}
	}
