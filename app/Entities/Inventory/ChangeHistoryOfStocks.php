<?php
	/**
	 * Created by PhpStorm.
	 * User: Anwar Sarmiento Ramo
	 * Date: 22/6/2018
	 * Time: 11:35:AM
	 */

	namespace App\Entities\Inventory;


	use App\Entities\Entity;

	class ChangeHistoryOfStocks extends Entity
	{
		protected $table = 'change_history_of_stocks';

		protected $fillable = ['before_stock','stock','after_stock','date','user_id','type','product_id'];
	}
