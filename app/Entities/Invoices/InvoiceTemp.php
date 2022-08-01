<?php
	/**
	 * Created by PhpStorm.
	 * User: Anwar Sarmiento Ramo
	 * Date: 2/8/2018
	 * Time: 10:36:PM
	 */

	namespace App\Entities\Invoices;


	use App\Entities\General\User;
	use App\Entities\Customers\Customer;
	use App\Entities\Entity;
	use App\Entities\Products\ProductsTemp;
	use App\Entities\Suppliers\Supplier;

	class InvoiceTemp extends Entity
	{
		protected $table = "invoice_temps";

		protected $fillable = ['discount','payment_method_id','supplier_id','customer_id','total','tax',
      'due_date','type_tax','total_other_rate','total_other_tax','sysconf_id',
			'date','numeration','type_id','user_id','completed','sale_condition','way_to_pay'];

		public function supplier()
		{
			return $this->belongsTo(Supplier::class);
		}

		public function customer()
		{
			return $this->belongsTo(Customer::class);
		}

		public function user()
		{
			return $this->belongsTo(User::class);
		}

		public function product()
		{
			return $this->hasMany(ProductsTemp::class, 'temp_invoice_id','id');
		}

		public function scopeSearch_buy($query, $search)
		{
			try
			{
				if ($search == 'Anulada' OR $search == 'anulada' OR $search == 'nulas')
				{
					$canceled = true;
				} else
				{
					$canceled = false;
				}
				if (trim($search) != "")
				{
					$query->whereHas("buy", function ($r) use ($search)
					{
						$r->whereHas("supplier", function ($m) use ($search)
						{
							$m->orWhere('name', "LIKE", "%$search%");
						})->orWhere('reference', "LIKE", "%$search%");
					})->whereHas("user", function ($m) use ($search)
					{
						$m->orWhere('username', "LIKE", "%$search%");
					})
						->orWhere("date", "LIKE", "%$search%")
						->orWhere("numeration", "LIKE", "%$search%")
						->orWhere("total", "LIKE", "%$search%");
					/**/
				}
			} catch (\Exception $e)
			{
				\Log::info($e->getMessage() . ' ' . $e->getLine());
			}

		}

		public function scopeSearch_sale($query, $search)
		{
			try
			{
				if ($search == 'Anulada' OR $search == 'anulada' OR $search == 'nulas')
				{
					$canceled = true;
				} else
				{
					$canceled = false;
				}
				if (trim($search) != "")
				{
					$query->whereHas("customer", function ($m) use ($search)
						{
							$m->Where('name', "LIKE", "%$search%");
						})
						->orWhere("date", "LIKE", "%$search%")
						->orWhere("numeration", "LIKE", "%$search%")
						->orWhere("total", "LIKE", "%$search%");
					/**/
				}
			} catch (\Exception $e)
			{
				\Log::info($e->getMessage() . ' ' . $e->getLine());
			}

		}
	}
