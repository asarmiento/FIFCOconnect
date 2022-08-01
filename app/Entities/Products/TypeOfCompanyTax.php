<?php
	/**
	 * Created by PhpStorm.
	 * User: Anwar Sarmiento Ramo
	 * Date: 30/8/2018
	 * Time: 10:20:AM
	 */
	
	namespace App\Entities\Products;
	
	
	use App\Entities\Entity;
	
	class TypeOfCompanyTax extends Entity
	{
		protected $table ='type_of_company_taxes';
		
		protected $fillable = ['code', 'product_id','tax'];
	}