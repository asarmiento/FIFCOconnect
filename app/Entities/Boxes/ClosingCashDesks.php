<?php
	/**
	 * Created by PhpStorm.
	 * User: Anwar Sarmiento Ramo
	 * Date: 23/9/2018
	 * Time: 08:41:PM
	 */
	
	namespace App\Entities\Boxes;
	
	
	use App\Entities\Entity;
	
	class ClosingCashDesks extends Entity
	{
		protected $table = 'closing_cash_desks';
		
		protected $fillable = ['cash_desk_id','total_sales_usd', 'success', 'created_at', 'updated_at', 'taxed_sales', 'exempt_sales',
			'tax_sales', 'discount', 'taxable_sales', 'credit_sales', 'cash_sales', 'amount_annulled_sales',
			'total_sales', 'annulled_sales', 'total_receipts', 'amount_receipts', 'invoices_paid', 'pay_supplier',
			'notes_credit', 'pay_other', 'date','finally','open_cash','payment_card','balance_cash'];
		
		public $timestamps = true;
		
		public function currencyClosed()
		{
			return $this->hasMany(CurrencyByClosingCashDesks::class, 'closing_cash_desk_id', 'id');
		}
		
		public function scopeSearch($query, $search)
		{
			if (trim($search) != "")
			{
				$query->where("success", "LIKE", "%$search%")
					->orWhere("date", "LIKE", "%$search%");
			}
			
		}

        public function cash()
        {
            return $this->belongsTo(CashDesk::class,'cash_desk_id','id');
		}
	}
