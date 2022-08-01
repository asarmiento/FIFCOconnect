<?php
	/**
	 * Created by PhpStorm.
	 * User: Anwar Sarmiento Ramo
	 * Date: 23/9/2018
	 * Time: 08:43:PM
	 */
	
	namespace App\Entities\Boxes;
	
	
	use App\Entities\Entity;
	
	class CurrencyByClosingCashDesks extends Entity
	{
		protected $table = 'currency_by_closing_cash_desks';
		protected $fillable = ['closing_cash_desk_id','currency_id','amount'];
		
		public function currency()
		{
			return $this->belongsTo(Currency::class);
		}
	}