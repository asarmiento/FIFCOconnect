<?php
	/**
	 * Created by PhpStorm.
	 * User: Anwar
	 * Date: 5/11/2018
	 * Time: 04:32:PM
	 */
	
	namespace App\Entities\Boxes;
	
	
	use App\Entities\Entity;
	
	class StartCashDesks extends Entity
	{
		protected $table = 'start_cash_desks';
		
		protected $fillable = ['user_id', 'date', 'amount', 'cash_desk_id'];
	}