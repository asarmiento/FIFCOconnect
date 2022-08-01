<?php
	/**
	 * Created by PhpStorm.
	 * User: Anwar Sarmiento Ramo
	 * Date: 30/7/2018
	 * Time: 08:01:PM
	 */
	
	namespace App\Entities\Customers;
	
	
	use App\Entities\Entity;
	
	class InvoicesByReceipt extends Entity
	{
		protected $table = "invoices_by_receipts";
		
		protected $fillable = ['receipt_id','invoice_id','payment'];
	}