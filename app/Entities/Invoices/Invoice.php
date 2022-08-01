<?php
/**
 * Created by PhpStorm.
 * User: Anwar
 * Date: 12/09/2017
 * Time: 07:51 PM
 */

namespace App\Entities\Invoices;


use App\Entities\Buys\Buy;
use App\Entities\Buys\BuyFE;
use App\Entities\General\EconomicActivity;
use App\Entities\General\Sysconf;
use App\Entities\General\User;
use App\Entities\Customers\CreditNote;
use App\Entities\Customers\Customer;
use App\Entities\Customers\OpticalCustomerPrescription;
use App\Entities\Customers\Receipt;
use App\Entities\Employee\Employee;
use App\Entities\Employee\InvoiceByEmployees;
use App\Entities\Employee\Transaction;
use App\Entities\Entity;
use App\Entities\Products\Product;
use App\Entities\Products\ProductsByInvoice;
use App\Entities\Suppliers\Supplier;
use Hamcrest\Thingy;
use Illuminate\Support\Facades\Auth;

class Invoice extends Entity
{
    public $errors;
    protected $fillable = [
        'uuid',
        'economic_activity_id',
        'sysconf_id',
        'type',
        'exoneration',
        'branch_office_id',
        'numeration',
        'status_email',
        'duplicate',

        'status_message_h',
        'status_sp',
        'key',
        'app_new',
        'consecutive_number',
        'longitud',
        'latitud',
        'date',
        'times',
        'date_presale',
        'time_presale',
        'due_date',
        'invoice_type_id',
        'payment_method_id',
        'reference_payment_method',
        'discount_taxed',
        'discount_exempt',
        'total_serv_tax',
        'total_serv_exempt',
        'total_serv_exonerada',
        'total_merca_tax',
        'total_merca_exempt',
        'total_merc_exonerada',
        'total_exonerada',
        'total_sale',
        'total_sale_neta',
        'subtotal',
        'subtotal_taxed',
        'subtotal_exempt',
        'discount',
        'percent_discount',
        'total_tax',
        'type_tax',
        'total_other_rate',
        'total_other_tax',
        'total_voucher',
        'changing',
        'note',
        'canceled',
        'status',
        'it_has_alteration',
        'paid_up',
        'paid',
        'payment',
        'hacienda_response',
        'xml_voucher',
        'path_pdf',
        'reception_receipt',
        'ind_estado',
        'way_to_pay',
        'sale_condition',
        'currency_code',
        'exchange_rate',
        'ref_type_doc',
        'ref_number',
        'ref_date',
        'ref_code',
        'ref_razon',
        'created_at',
        'updated_at',
        'user_id',
        'user_id_applied',
        'token',
        'closing_cash_desk_id'
    ];

    protected $guarded = ['id'];

    public $timestamps = true;

    public static $columns = [
        'economic_activity_id',
        'type',
        'exoneration',
        'branch_office_id',
        'numeration',
        'status_email',
        'status_message_h',
        'status_sp',
        'key',
        'app_new',
        'consecutive_number',
        'longitud',
        'latitud',
        'date',
        'times',
        'date_presale',
        'time_presale',
        'due_date',
        'invoice_type_id',
        'payment_method_id',
        'reference_payment_method',
        'total_serv_tax',
        'total_serv_exempt',
        'total_serv_exonerada',
        'total_merca_tax',
        'total_merca_exempt',
        'total_merc_exonerada',
        'total_exonerada',
        'total_sale',
        'total_sale_neta',
        'subtotal',
        'subtotal_taxed',
        'subtotal_exempt',
        'discount',
        'percent_discount',
        'total_tax',
        'type_tax',
        'total_other_rate',
        'total_other_tax',
        'total_voucher',
        'changing',
        'note',
        'canceled',
        'status',
        'it_has_alteration',
        'paid_up',
        'paid',
        'payment',
        'hacienda_response',
        'xml_voucher',
        'path_pdf',
        'reception_receipt',
        'ind_estado',
        'way_to_pay',
        'sale_condition',
        'currency_code',
        'exchange_rate',
        'user_id',
        'user_id_applied',
        'token',
        'closing_cash_desk_id'
    ];

    public function saveData($data)
    {

        $invoice = self::create($data);
        return $invoice;
    }


    /*******************************************************
     * @Author     : Anwar Sarmiento Ramos
     * @Email      : asarmiento@sistemasamigableslatam.com
     * @Create     : 21/2/2018 09:19:PM  @Update: 0000-00-00
     ********************************************************
     * @Description: Generamos la busqueda por diferentes
     * campos de las diferentes tablas realcionadas con las
     * facturas, se utiliza en las vistas de listas
     *
     * @param $query
     * @param $search
     */
    public function scopeSearch($query, $search)
    {
        try {
            if (trim($search) != "") {
                $query->whereHas("customer", function ($r) use ($search) {
                    $r->where('name', "LIKE", "%$search%")
                        ->orWhere("fantasy_name", "LIKE", "%$search%")
                        ->orWhere("company_name", "LIKE", "%$search%");
                })->orWhere("date", "LIKE", "%$search%")->orWhere("consecutive_number", "LIKE", "%$search%")
                    ->orWhere("numeration", "LIKE", "%$search%")
                    ;
                /**/
            }
        } catch (\Exception $e) {
            \Log::info($e->getMessage() . ' ' . $e->getLine());
        }

    }
    public function scopeSearchSale($query, $search)
    {
        try {
            if (trim($search) != "") {
                $query->whereHas("sale", function ($r) use ($search) {
                  $r->where('customer_name', "LIKE", "$search%")->where('sysconf_id', sysconf()->id);
                });
                /**/
            }
        } catch (\Exception $e) {
            \Log::info($e->getMessage() . ' ' . $e->getLine());
        }

    }

    public function scopeSearchUser($query, $search)
    {
        try {
            if (trim($search) != "") {
                $query->whereHas("customer", function ($r) use ($search) {
                    $r->where('name', "LIKE", "%$search%")
                        ->orWhere("fantasy_name", "LIKE", "%$search%")
                        ->orWhere("company_name", "LIKE", "%$search%");
                })->orWhere("date_presale", "LIKE", "%$search%")
                    ->orWhere("numeration", "LIKE", "%$search%")
                    ->orWhere("key", "LIKE", "%$search%")
                    ->orWhere("id", "LIKE", "%$search%")
	                ->where('sysconf_id', sysconf()->id)
                    ->orWhere("consecutive_number", "LIKE", "%$search%")
                    ->orWhere("total_voucher", "LIKE", "%$search%");
                /**/
            }
        } catch (\Exception $e) {
            \Log::info($e->getMessage() . ' ' . $e->getLine());
        }

    }

    public static function insertNewInvoice($data)
    {
        return get_object_vars($data);
    }

    public function scopeSearch_buy($query, $search)
    {
        try {
            if ($search == 'Anulada' OR $search == 'anulada' OR $search == 'nulas') {
                $canceled = true;
            } else {
                $canceled = false;
            }
            if (trim($search) != "") {
                $query->whereHas("buy", function ($r) use ($search) {
                    $r->whereHas("supplier", function ($m) use ($search) {
                        $m->Where('name', "LIKE", "%$search%");
                    })->orWhere('reference', "LIKE", "%$search%");
                })->whereHas("user", function ($m) use ($search) {
                    $m->orWhere('username', "LIKE", "%$search%");
                })->where('sysconf_id', sysconf()->id)
                    ->orWhere("date", "LIKE", "%$search%")
                    ->orWhere("id", "LIKE", "%$search%")
                    ->orWhere("numeration", "LIKE", "%$search%")
                    ->orWhere("total_voucher", "LIKE", "%$search%");
                /**/
            }
        } catch (\Exception $e) {
            \Log::info($e->getMessage() . ' ' . $e->getLine());
        }

    }

    public function locationInvoices($data, $user = null)
    {
        $invoices = self::query();
        $invoices->with('customer')->where('date', $data['date'])
            ->where('longitud', '<>', 0)->where('sysconf_id', sysconf()->id)
            ->orderBy('status', 'DESC')->orderBy('times', 'ASC');
        if ($user != null) {

            $invoices->where($user, $data['user_id']);
        }

        return $invoices->get();
    }

    public function consultInvoicesRangeDate($data, $type, $sysconf)
    {
        return $this->whereBetween('date', $data)
            ->where('invoice_type_id', $type)
            ->where('ind_estado', 'aceptado')
            ->where('sysconf_id', $sysconf->id)
            ->orderBy('numeration', 'DESC')->get();
    }

    public function consultInvoicesPluck($data, $type, $sysconf,$money)
    {
        return $this->whereBetween('date', $data)
            ->where('invoice_type_id', $type)
            ->where('ind_estado', 'aceptado')
            ->where('sysconf_id', $sysconf->id)
            ->where('currency_code', $money)
            ->orderBy('numeration', 'DESC')->pluck('id');
    }

    public function consultForCustomerInvoicesRangeDate($data, $type, $customer, $sysconf)
    {
        return $this->whereHas('sale', function ($e) use ($customer, $sysconf) {
            $e->where('customer_id', $customer);
        })->whereBetween('date', $data)
            ->where('invoice_type_id', $type)
            ->where('ind_estado', 'aceptado')
            ->where('sysconf_id', $sysconf->id)
            ->orderBy('numeration', 'DESC');
    }

    /*******************************************************
     * @Author     : Anwar Sarmiento Ramos
     * @Email      : asarmiento@sistemasamigableslatam.com
     * @Create     : 21/2/2018 09:23:PM  @Update: 0000-00-00
     ********************************************************
     * @Description:
     *
     *
     *
     * @Pasos      :
     *
     *
     * @param $query
     * @param $type
     * @return mixed
     */
    public function scopeOfInvoice($query, $type)
    {
        return $query->whereInvoiceTypeId($type);
    }

    public function xmlInvoice()
    {
        return $this->hasOne(\App\Entities\FE\XmlInvoice::class);
    }

    public function scopeOfBranch($query, $type)
    {
        return $query->whereBranchOfficeId($type);
    }

    public static function countNotification()
    {
        $date = self::outDate();

        return Invoice::where('due_date', '<=', $date)->where('invoice_type_id', 1)
            ->where('paid_up', 0)->where('payment_method_id', 2);
    }

    public static function countNotificationSale()
    {
        $date = self::outDate();

        return Invoice::where('due_date', '<=', $date)->where('invoice_type_id', 2)
            ->where('paid_up', 0)->where('payment_method_id', 2);
    }


    /**
     * ------------------------- Relaciones ----------------------
     */


    /*******************************************************
     * @Author     : Anwar Sarmiento Ramos
     * @Email      : asarmiento@sistemasamigableslatam.com
     * @Create     : 21/2/2018 09:16:PM  @Update: 0000-00-00
     ********************************************************
     * @Description: Tenemos la Relación para la tabla donde
     * guardamos los productos que llevan cada factura y lo
     *  que fue entregado en caso de preventa, igualmente el
     *  descuento que se le haya dado en algun producto,
     *  tambien si el producto es bonificación o no.
     *
     * @return $this
     */
    public function productInvoice()
    {
        return $this->hasMany(ProductsByInvoice::class)->where('total', '>', 0);
    }

    public function productInvoiceFill()
    {
        return $this->hasMany(ProductsByInvoice::class)->where('total', '>', 0)->where('type', 'sale');
    }

    public function productByInvoice()
    {
        return $this->hasMany(ProductsByInvoice::class)->where('total', '>', 0);
    }

    public function sysconf()
    {
        return $this->belongsTo(Sysconf::class);
    }

  public function optica()
  {
     return $this->hasMany(OpticalCustomerPrescription::class);
  }
    /**
     * -----------------------------------------------------------------------
     * @Author     : Anwar Sarmiento <asarmiento@sistemasamigableslatam.com>
     * @DateCreate : 28/3/2019
     * @TimeCreate : 09:22:PM
     * @DateUpdate : 0000-00-00
     * -----------------------------------------------------------------------
     * @description:
     * @steps      :
     * ----------------------------------------------------------------------
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     *
     * ----------------------------------------------------------------------
     *
     * @var
     * ----------------------------------------------------------------------
     */
    public function customer()
    {
        return $this->belongsToMany(Customer::class, 'sales')->withPivot('invoice_id',
            'customer_id',
            'cash_desk_id',
            'sale_type',
            'applied',
            'viewed',
            'customer_name'
        );
    }

    public function creditNotes()
    {
        return $this->hasMany(CreditNote::class, 'invoice_id', 'id');
    }

    public function listCreditNotes()
    {
        return $this->hasMany(CreditNote::class, 'invoice_id', 'id');
    }

    public function activity()
    {
        return $this->belongsTo(EconomicActivity::class, 'economic_activity_id', 'id');
    }

    public function exonerationTable()
    {
        return $this->hasOne(Exoneration::class);
    }

    public function payment()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id', 'id');
    }

    public function cashDesk()
    {
        return $this->belongsTo(CashDesk::getClass());
    }

    public function invoiceType()
    {
        return $this->belongsTo(InvoiceType::getClass());
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'products_by_invoices', 'invoice_id', 'product_id')
            ->withPivot('id', 'price', 'amount',
                'exonerado',
                'code_iva',
                'impuesto_neto', 'subtotal', 'm_discount', 'rate', 'm_tax', 'description',
                'm_total',
                'total',
                'discount', 'delivered');
    }

    public function productsRefund()
    {
        return $this->belongsToMany(Product::class, 'products_by_invoices')
            ->withPivot('id', 'price', 'amount', 'discount', 'subtotal', 'm_discount', 'rate', 'm_tax', 'total', 'description',
                'delivered', 'refund', 'm_total')->where('products_by_invoices.type', 'return');
    }

    public function branchOffice()
    {
        return $this->belongsTo(BranchOffice::getClass());
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')
            ->select('id', 'username','type_user_id');
    }


    public function sale()
    {
        return $this->hasOne(Sale::class, 'invoice_id', 'id');
    }

    public function feBuy()
    {
        return $this->hasOne(BuyFE::class, 'invoice_id', 'id');
    }

    public function supplierBuy()
    {
        return $this->belongsToMany(Supplier::class, 'fe_buys', 'invoice_id', 'supplier_id');
    }

    public function supplier()
    {
        return $this->belongsToMany(Supplier::class, 'buys', 'invoice_id', 'supplier_id')
            ->withPivot('reference', 'sold');
    }

    public function employee()
    {
        return $this->belongsToMany(Employee::class, 'invoice_by_employees')
            ->withPivot('id', 'invoice_by_employees.status', 'android');
    }

    public function buy()
    {
        return $this->hasOne(Buy::class);
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }

    public function transactions()
    {
        return $this->hasOne(Transaction::class);
    }

    public function invoiceByEmployeesDistributor()
    {
        return $this->hasOne(InvoiceByEmployees::class)->where('invoice_by_employees.status', 'distributor');
    }

    /*******************************************************
     * @Author     : Anwar Sarmiento Ramos
     * @Email      : asarmiento@sistemasamigableslatam.com
     * @Create     : 21/2/2018 09:21:PM  @Update: 0000-00-00
     ********************************************************
     * @Description: Relacion con la tabla de las facturas
     * asignadas algun distribuidor
     *
     *
     * @Pasos      :
     *
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function invoiceByEmployee()
    {
        return $this->hasOne(InvoiceByEmployees::class);
    }

    public function receipts()
    {
        return $this->belongsToMany(Receipt::getClass(), 'invoices_by_receipts'); // TODO: Change the autogenerated stub
    }

    /**
     * @param $data
     * @return bool
     */
    public function isValid($data)
    {
        $invoice_type = $data['invoice_type_id'];
        $rules = [
            'numeration' => 'required|unique:invoices,numeration,NULL,id,branch_office_id,' . $data['branch_office_id'] . ',invoice_type_id,' . $invoice_type,
            'invoice_type_id' => 'required',
            'payment_method_id' => 'required',
            'due_date' => 'required_if:payment_method_id,2'
        ];

        if ($invoice_type == 1) {
            $rules['supplier_id'] = "required";
        }

        if ($invoice_type == 2) {
            $rules['customer_id'] = "required";
        }

        //if the register already exists
        if ($this->exists) {
            //this is so the rule avoids considering the following when replacing/updating content
            $rules['numeration'] = 'required|unique:invoices,numeration,' . $this->id . ',id,branch_office_id,' . $data['branch_office_id'] . ',invoice_type_id,' . $invoice_type;
        }


        // this will execute the validation function for all the $data with the $rules previously established
        $validation = Validator::make($data, $rules);

        if ($validation->passes()) {
            return true;
        }
        //if there is an error than sends the errors back.
        $this->errors = $validation->errors();

        return false;
    }

    /**
     * Consultas a Invoices y sus relaciones
     */


    public function summaryTotalDate($date, $sysconf, $type, $column)
    {
        self::whereBetween('date', $date)->where('sysconf_id', $sysconf)->where('ind_estado', 'aceptado')->where('invoice_type_id', $type)->sum($column);
    }
}
