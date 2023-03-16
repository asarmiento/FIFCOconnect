<?php
/**
 * Created by PhpStorm.
 * User: Anwar
 * Date: 12/09/2017
 * Time: 08:03 PM
 */

namespace App\Entities\Customers;


use App\Entities\Boxes\CashDesk;
use App\Entities\General\BranchOffice;
use App\Entities\General\User;
use App\Entities\Entity;
use App\Entities\Invoices\Invoice;
use Illuminate\Support\Facades\Validator;

class Receipt extends Entity
{
	protected $connection = 'mysql_fifco';
  public $table ='receipts';
    public $errors;

    protected $fillable = array(
        'reference',
        'customer_id',
        'sysconf_id',
        'date',
        'sum',
        'prev_balance',
        'cash_desk_id',
        'currency_code',
        'way_to_pay',
        'branch_office_id',
        'user_id',
        'viewed',
        'balance',
        'api','notes'
    );

    protected $guarded = array('id');

	public static $columns = ['reference',
		'customer_id',
		'date',
		'sum',
		'prev_balance',
		'cash_desk_id',
		'branch_office_id',
		'user_id',
		'viewed',
		'balance',
		'api','notes'];
    // protected $hidden = array('created_at','updated_at');


	public function scopeSearch($query, $search)
	{
		if (trim($search) != "")
		{
			$query->whereHas("customer", function ($q) use ($search)
			{
				$q->Where('company_name', "LIKE", "%$search%");
			})->orWhere("balance", "LIKE", "%$search%")
				->orWhere("date", "LIKE", "%$search%")
				->orWhere("sum", "LIKE", "%$search%")
				->orWhere("reference", "LIKE", "%$search%");
		}

	}

	//relations
	/**
	 * -----------------------------------------------------------------------
	 * @Author     : Anwar Sarmiento <asarmiento@sistemasamigableslatam.com>
	 * @DateCreate : 1/8/2018
	 * @TimeCreate : 12:57:PM
	 * @DateUpdate : 0000-00-00
	 * -----------------------------------------------------------------------
	 * @description: Traemos los abonos o pagos por factura y los datos de la
	 *             facturas pagas
	 * @steps      :
	 * ----------------------------------------------------------------------
	 * @var
	 * ----------------------------------------------------------------------
	 * @return $this
	 *
	 * ----------------------------------------------------------------------
	 *
	 */
	public function invoices()
    {
        return $this->belongsToMany(Invoice::class,'invoices_by_receipts')->where('sysconf_id',sysconf()->id)
            ->withPivot('payment');
    }

	/**
	 * -----------------------------------------------------------------------
	 * @Author     : Anwar Sarmiento <asarmiento@sistemasamigableslatam.com>
	 * @DateCreate : 1/8/2018
	 * @TimeCreate : 12:55:PM
	 * @DateUpdate : 0000-00-00
	 * -----------------------------------------------------------------------
	 * @description: obtenemos los datos por cliente
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
        return $this->belongsTo(Customer::class)->where('sysconf_id',sysconf()->id);
    }

	public function cashDesk()
    {
        return $this->belongsTo(CashDesk::class);
    }

    public function branchOffice()
    {
        return $this->belongsTo(BranchOffice::class);
    }

	public function user()
	{
		return $this->belongsTo(User::class);
    }
    public function isValid($data){
        $rules = array(
            'reference' => 'required|unique:receipts',
            'date' => 'required',
            'sum' => 'required'
        );

        //if the register already exists
        if($this->exists)
        {
            //this is so the rule avoids considering the following when replacing/updating content
            $rules['reference'] .= ',reference,'.$this->id;
        }

        // this will execute the validation function for all the $data with the $rules previously established
        $validation = Validator::make($data,$rules);

        if($validation->passes())
        {
            return true;
        }
        //if there is an error than sends the errors back.
        $this->errors = $validation->errors();
        return false;
    }
}
