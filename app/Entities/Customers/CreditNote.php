<?php

	namespace App\Entities\Customers;

	use App\Entities\General\Sysconf;
	use App\Entities\General\User;
	use App\Entities\Entity;
	use App\Entities\Invoices\Invoice;
	use App\Http\Traits\Web\DataViewerTraits;
	use Illuminate\Support\Facades\Auth;

	class CreditNote extends Entity
	{
		use DataViewerTraits;

		protected $connection ='mysql_fifco';
		protected $table = 'credit_notes';
		protected $fillable = [
			'code', 'exoneration', 'status_email', 'customer_id', 'invoice_id', 'total_serv_tax',
			'total_serv_exonerada', 'total_serv_exempt', 'total_merca_tax', 'total_merc_exonerada',
			'total_merca_exempt', 'total_sale', 'total_sale_neta', 'subtotal', 'subtotal_taxed',
			'subtotal_exempt', 'discount', 'percent_discount', 'total_tax', 'total_exonerada',
			'total_voucher', 'user_id', 'amount', 'tax', 'date', 'observation', 'status', 'key',
			'consecutive', 'path_xml_sign', 'url_response', 'path_xml_response', 'code_status_hacienda',
			'message_status_hacienda', 'status_hacienda', 'closing_cash_desk_id', 'sysconf_id'];

		public function consultCreditNoteRangeDate($date,$sysconf)
		{
			return $this->where('sysconf_id',$sysconf->id)
				->whereBetween('date',$date)
				->where('code_status_hacienda','aceptado')->get();
}

		public function consultCreditNoteRangeDateCustomer($date,$customer,$sysconf)
		{
			return $this->where('customer_id',$customer)->where('sysconf_id',$sysconf->id)
				->whereBetween('date',$date)
				->where('code_status_hacienda','aceptado');
}


		public function customer()
		{
			return $this->belongsTo(Customer::class);
		}

		public function user()
		{
			return $this->belongsTo(User::class);
		}

		public function invoice()
		{
			return $this->belongsTo(Invoice::class);
		}

		public function sysconf()
		{
			return $this->belongsTo(Sysconf::class);
		}

		/**
		 * -----------------------------------------------------------------------
		 * @Author     : Anwar Sarmiento <asarmiento@sistemasamigableslatam.com>
		 * @DateCreate : 1/8/2018
		 * @TimeCreate : 09:34:PM
		 * @DateUpdate : 0000-00-00
		 * -----------------------------------------------------------------------
		 * @description:
		 * @steps      :
		 * ----------------------------------------------------------------------
		 * @param $query
		 * @param $search
		 * @return void
		 *
		 * ----------------------------------------------------------------------
		 *
		 * @var
		 * ----------------------------------------------------------------------
		 */
		public function scopeSearch($query, $search)
		{
			if(trim($search) != "") {
				$query->where("code", "LIKE", "%$search%")
					->orWhere("date", "LIKE", "%$search%")
					->orWhere("amount", "LIKE", "%$search%")
					->whereHas("customer", function ($r) use ($search) {
						$r->where('name', "LIKE", "%$search%")
							->orWhere("fantasy_name", "LIKE", "%$search%")
							->orWhere("company_name", "LIKE", "%$search%");
					});
			}

		}
	}
