<?php
	/**
	 * Created by PhpStorm.
	 * User: asarmiento
	 * Date: 23/6/20
	 * Time: 15:00
	 */

	namespace App\Entities\Customers;


	use App\Entities\Entity;

	class Channel extends Entity
	{
		protected $table = "channels";
		protected $fillable = ["name"];
		protected $connection = 'mysql_fifco';

	}
