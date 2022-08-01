<?php
	/**
	 * Created by PhpStorm.
	 * User: asarmiento
	 * Date: 18/5/20
	 * Time: 04:19
	 */

	namespace App\Entities\Invoices;


	use App\Entities\Entity;

	class BatchOfProduct extends Entity
	{
		protected $fillable = ['date','transfer', 'amount', 'product_id', 'user_id'];
	}
