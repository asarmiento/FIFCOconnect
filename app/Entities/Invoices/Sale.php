<?php
/**
 * Created by PhpStorm.
 * User: Anwar
 * Date: 12/09/2017
 * Time: 07:50 PM
 */

namespace App\Entities\Invoices;


use App\Entities\Customers\Customer;
use App\Entities\Entity;

class Sale extends Entity
{
	protected $connection = 'mysql_fifco';
    protected $fillable = array(
        'invoice_id',
        'customer_id',
        'cash_desk_id',
        'sale_type',
        'applied',
        'viewed',
        'customer_name'
    );
  public $incrementing = true;
    protected $guarded = array('id');

	/**
	 * -----------------------------------------------------------------------
	 * @Author     : Anwar Sarmiento <asarmiento@sistemasamigableslatam.com>
	 * @DateCreate : 30/7/2018
	 * @TimeCreate : 12:09:AM
	 * @DateUpdate : 0000-00-00
	 * -----------------------------------------------------------------------
	 * @description:
	 * @steps      :
	 * ----------------------------------------------------------------------
	 * @var
	 * ----------------------------------------------------------------------
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 *
	 * ----------------------------------------------------------------------
	 *
	 */
	public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
	public function invoiceFill()
    {
        return $this->belongsTo(Invoice::class)->where('ind_estado','aceptado');
    }

	/**
	 * -----------------------------------------------------------------------
	 * @Author     : Anwar Sarmiento <asarmiento@sistemasamigableslatam.com>
	 * @DateCreate : 30/7/2018
	 * @TimeCreate : 12:09:AM
	 * @DateUpdate : 0000-00-00
	 * -----------------------------------------------------------------------
	 * @description:
	 * @steps      :
	 * ----------------------------------------------------------------------
	 * @var
	 * ----------------------------------------------------------------------
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 *
	 * ----------------------------------------------------------------------
	 *
	 */
	public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function scopeApplied($query)
    {
        return $query->whereApplied(1);
    }

    public function balanceBetweenDate($date)
    {

        return self::whereHas('invoice', function ($q) use ($date) {
            $q->whereBetween('date', $date);
        })->count('amount');
    }

    public function cashDesk()
    {
        return $this->belongsTo(CashDesk::class);
    }
}
