<?php
	/**
	 * Created by PhpStorm.
	 * User: Anwar Sarmiento Ramo
	 * Date: 8/6/2018
	 * Time: 03:38:PM
	 */

	namespace App\Entities\Customers;


	use App\Entities\Entity;

	class VisitCustomer extends Entity
	{
		protected $table = 'visit_to_customers';

		protected $connection = 'mysql_fifco';
		protected $fillable = ['customer_id','visit','observation','date','longitud','latitud','user_id'];
	}
