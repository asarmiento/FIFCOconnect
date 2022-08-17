<?php
	/**
	 * Created by PhpStorm.
	 * User: Anwar Sarmiento Ramo
	 * Date: 19/7/2018
	 * Time: 12:01:PM
	 */

	namespace App\Entities\Customers;


	use App\Entities\Entity;

	class TemporaryCreditNote extends Entity
	{
		protected $connection = 'mysql_fifco';
		protected $table = "temporary_credit_notes";

		protected $fillable = ['product_id','invoice_id','amount','price','product_type_id','user_id', 'products_by_invoices_id'];

		public $timestamps  = true;
	}
