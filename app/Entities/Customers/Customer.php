<?php
  /**
   * Created by PhpStorm.
   * User: Anwar
   * Date: 12/09/2017
   * Time: 07:52 PM
   */

  namespace App\Entities\Customers;


  use App\Entities\General\Neighborhood;
  use App\Entities\Entity;
  use App\Entities\Invoices\Invoice;
  use App\Entities\Invoices\Sale;
  use App\Entities\Customers\Zone;

  class Customer extends Entity
  {
	  protected $connection = 'mysql_fifco';
    protected $fillable = [
      'code',
      'card',
      'type_of_cedula',
      'due',
      'name',
      'company_name',
      'code_due',
      'fantasy_name',
      'phone',
      'status',
      'placa',
      'credit_limit',
      'address',
      'neighborhood_id',
      'channel_id',
      'contact_email',
      'fe',
      'simplificado',
      'imp_renta',
      'sysconf_id',
      'imp_ventas',
      'mensualidad',
      'usuario_sv_conta',
      'subdominio',
      'type_customer',
      'email',
      'visit_day',
      'model',
      'doors',
      'zone_id',
      'longitud',
      'latitud',
      'fixed_discount',
      'credit_time'
    ];

    protected $guarded = ['id'];

    protected $hidden = ['created_at'];

    public static $columns = [
      'card',
      'name',
      'placa',
      'code',
      'doors',
      'model',
      'credit_limit'
    ];

    public static function searchCard($card)
    {
      return self::where('card',$card)->where('sysconf_id',sysconf()->id)->first();
    }
    public function scopeSearch($query, $search)
    {
      if (trim($search) != "")
      {
        $query->where('sysconf_id',sysconf()->id)->where("name", "LIKE", "%$search%")
              ->orWhere("placa", "LIKE", "%$search%")
              ->orWhere("code", "LIKE", "%$search%")
              ->orWhere("doors", "LIKE", "%$search%")
              ->orWhere("card", "LIKE", "%$search%")
              ->orWhere("company_name", "LIKE", "%$search%")
              ->orWhere("fantasy_name", "LIKE", "%$search%");
      }

    }

    /**
     * -----------------------------------------------------------------------
     * @Author     : Anwar Sarmiento <asarmiento@sistemasamigableslatam.com>
     * @DateCreate : 31/5/2018
     * @TimeCreate : 11:20:PM
     * @DateUpdate : 0000-00-00
     * -----------------------------------------------------------------------
     * @description: Metodo para crear la lista de clientes para los select
     * @steps      :
     * ----------------------------------------------------------------------
     * @var
     * ----------------------------------------------------------------------
     * @return array
     *
     * ----------------------------------------------------------------------
     *
     */
    public static function listsLabel()
    {
      $customers = self::where('sysconf_id',sysconf()->id)->orderBy('company_name')->get();

      $lists = [];
      $code = "";
      foreach ($customers AS $customer)
      {
        if ($customer->code != null)
        {
          $code = ' Código SAP: ' . $customer->code;
        }
        if (sysconf()->type == 'otros' || sysconf()->type == 'Servicios Profesionales')
        {
          array_push($lists, [
            'label' =>
              $customer->company_name,

            'value' => $customer->id
          ]);
        } else
        {
          array_push($lists, [
            'label' =>
              $code .
              ' Céd.: ' . $customer->card .
              ' - ' . $customer->company_name .
              ' Fantasia: ' . $customer->fantasy_name,
            'value' => $customer->id
          ]);
        }
      }

      return $lists;
    }
		public function optica(){
    	return $this->hasMany(OpticalCustomerPrescription::class,'customer_id','id');
		}
    public static function listsLabelFe()
    {
      $customers = self::where('sysconf_id',sysconf()->id)->where('fe',1)->get();
      $lists = [];
      $code = "";
      foreach ($customers AS $customer)
      {
        if ($customer->code != null & sysconf()->type == 'ditribuidor')
        {
          $code = ' Código SAP: ' . $customer->code;
        }

          array_push($lists, [
            'label' =>
              $code .
              ' Céd.: ' . $customer->card .
              ' - ' . $customer->company_name .
              ' Fantasia: ' . $customer->fantasy_name,
            'value' => $customer->id
          ]);
        }


      return $lists;
    }


    public static function listsLabelTicket()
    {
      $customers = self::where('sysconf_id',sysconf()->id)->orderBy('fe','ASC')->get();
      $lists = [];
      $code = "";
      foreach ($customers AS $customer)
      {
        if ($customer->code != null)
        {
          $code = ' Código SAP: ' . $customer->code;
        }
        if (sysconf()->type == 'otros' || sysconf()->type == 'Servicios Profesionales')
        {
          array_push($lists, [
            'label' =>
              $customer->company_name,

            'value' => $customer->id
          ]);
        } else
        {
          array_push($lists, [
            'label' =>
              $code .
              ' Céd.: ' . $customer->card .
              ' -: ' . $customer->company_name .
              ' Fantasia: ' . $customer->fantasy_name,
            'value' => $customer->id
          ]);
        }
      }

      return $lists;
    }


    public static function listsLabelDue()
    {
      $customers = self::where('sysconf_id',sysconf()->id)->whereHas('invoices', function ($q)
      {
        $q->where('payment_method_id', 2)->where('paid_up', 0)->where('paid_up', '0');
      })->where('credit_limit', '>', 0)->get();
      $lists = [];
      $code = "";
      foreach ($customers AS $customer)
      {
        if ($customer->code != null)
        {
          $code = ' Código SAP: ' . $customer->code;
        }
        if (sysconf()->type == 'otros' || sysconf()->type == 'Servicios Profesionales')
        {
          array_push($lists, [
            'label' =>
              $customer->company_name,

            'value' => $customer->id
          ]);
        } else
        {
          array_push($lists, [
            'label' =>
              $code .
              ' Céd.: ' . $customer->card .
              ' - ' . $customer->company_name .
              ' Fantasia: ' . $customer->fantasy_name,
            'value' => $customer->id
          ]);
        }
      }

      return $lists;
    }

    public static function selectLabel($id)
    {
      $customer = Customer::find($id);
      $code = "";
      $lists = [];
      if ($customer)
      {
        if ($customer->code != null)
        {
          $code = ' Código SAP: ' . $customer->code;
        }
        if (sysconf()->type == 'otros' || sysconf()->type == 'Servicios Profesionales')
        {
          $lists = [
            'select' => [
              'label' => $customer->company_name,
              'value' => $customer->id
            ], 'due' => $customer->due, 'credit_limit' => $customer->credit_limit
          ];
        } else
        {
          $lists = [
            'select' => [
              'label' =>
                $code .
                ' Céd.: ' . $customer->card .
                ' - ' . $customer->company_name .
                ' Fantasia: ' . $customer->fantasy_name,
              'value' => $customer->id
            ], 'due' => $customer->due, 'credit_limit' => $customer->credit_limit
          ];
        }

      }

      return $lists;
    }

    public function zone()
    {
      return $this->belongsTo(Zone::class);
    }

	  public function opticals()
	  {
		  return $this->hasMany(OpticalCustomerPrescription::class,'customer_id','id');
    }
      public function channel()
      {
          return $this->belongsTo(Channel::class);
    }
    /**
     * -----------------------------------------------------------------------
     * @Author     : Anwar Sarmiento <asarmiento@sistemasamigableslatam.com>
     * @DateCreate : 30/7/2018
     * @TimeCreate : 12:07:AM
     * @DateUpdate : 0000-00-00
     * -----------------------------------------------------------------------
     * @description:
     * @steps      :
     * ----------------------------------------------------------------------
     * @var
     * ----------------------------------------------------------------------
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     * ----------------------------------------------------------------------
     *
     */
    public function sales()
    {
      return $this->hasMany(Sale::class);
    }

    public function receipts()
    {
      return $this->hasMany(Receipt::class)->where('sysconf_id',sysconf()->id);
    }

	  public function customerEquipments()
	  {
				return $this->hasMany(CustomerEquipment::class,'customer_id','id');
    }
    public function typeOfAccountingRecord()
    {
      return $this->hasMany(TypeOfAccountingRecord::class);
    }

    /**
     * -----------------------------------------------------------------------
     * @Author     : Anwar Sarmiento <asarmiento@sistemasamigableslatam.com>
     * @DateCreate : 30/7/2018
     * @TimeCreate : 12:07:AM
     * @DateUpdate : 0000-00-00
     * -----------------------------------------------------------------------
     * @description:
     * @steps      :
     * ----------------------------------------------------------------------
     * @var
     * ----------------------------------------------------------------------
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     *
     * ----------------------------------------------------------------------
     *
     */
    public function invoices()
    {
      return $this->belongsToMany(Invoice::class, 'sales')->where('sysconf_id',sysconf()->id)->where('ind_estado','aceptado'); // TODO: Change the autogenerated stub
    }
    public function invoicesDue()
    {
      return $this->belongsToMany(Invoice::class, 'sales')->where('invoice_type_id',2)->where('sysconf_id',sysconf()->id)
                                                          ->where('payment_method_id',2)->where('ind_estado','aceptado')->where('paid_up',0); // TODO: Change the autogenerated stub
    }

    public function invoRep()
    {
      return $this->belongsToMany(Invoice::class, 'sales')->where('sysconf_id',sysconf()->id)->where('ind_estado','aceptado')
                  ->select('invoices.id'); // TODO: Change the autogenerated stub
    }

    public function promotions()
    {
     // return $this->hasMany(Promotion::class);
    }

    public function neighborhood()
    {
      return $this->belongsTo(Neighborhood::class,'neighborhood_id','id');
    }

		public function summarySaleCustomer()
		{
			return $this->hasMany(SummarySaleCustomer::class);
    }

    public function setCompanyNameAttribute($value)
    {
      if (!empty($value)) {
        $this->attributes['company_name'] = strtoupper($value);
      }
    }

    public function setFantasyNameAttribute($value)
    {
      if (!empty($value)) {
        $this->attributes['fantasy_name'] = strtoupper($value);
      }
    }

    public function setNameAttribute($value)
    {
      if (!empty($value)) {
        $this->attributes['name'] = strtoupper($value);
      }
    }

    /**
     * @param $data
     * @return mixed
     */
    public function createTracking($data)
    {
      return self::create($data);
    }

    public static function customerLists($id)
    {
      return self::where('sysconf_id',$id)->get();
    }
  }
