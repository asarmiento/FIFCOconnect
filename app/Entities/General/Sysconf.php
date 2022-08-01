<?php
/**
 * Created by PhpStorm.
 * User: Anwar
 * Date: 07/09/2017
 * Time: 02:21 PM
 */

namespace App\Entities\General;


use App\Entities\Customers\Customer;
use App\Entities\Entity;
use App\Entities\Invoices\Invoice;
use App\Entities\Sales\ConsecutiveNumberFE;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * Class Sysconf
 * @package App\Entities\General
 */
class Sysconf extends Entity
{
    protected $fillable = array(
        'id','type_account',
        'identification', 'fe', 'data_base', 'type_price_products', 'type_of_cedula', 'id_number_atv', 'name','type_account',
        'short_name', 'code', 'ftp', 'email_receiver', 'receiving_email', 'auto_receiving_email',
        'receiving_email_password', 'receiving_email_port', 'business_name', 'logo', 'subdomin', 'sucursal',
        'direction', 'neighborhood_id', 'phone', 'phone_two', 'other_senas', 'bill_limit', 'limit_expiration',
        'fax_country_code', 'date_expiration_llave', 'files_p12', 'hacienda_production_pin', 'hacienda_production_income',
        'hacienda_production_pass', 'hacienda_staging_p12', 'hacienda_staging_pin', 'hacienda_staging_income',
        'hacienda_staging_pass', 'hacienda_env', 'email', 'counting_mail', 'supervisor_mail', 'type_regimen',
        'official_currency', 'tax_rate', 'cost_of_return', 'initial_month', 'final_month','latitude','longitude',
        'type', 'florida','automatic_inventory'
    );

    protected  $connection = 'mysql';

  public static function getInsert($data)
  {
   return self::create($data);
    }

  public function getToDayAttribute()
  {
    return Carbon::now()->toDateString();
    }
  public static function getUpdate($id,$data)
  {
   return self::where('id',$id)->update($data);
    }
  public function scopeSearch($query, $search)
  {
    if (trim($search) != "")
    {
      $query->where("identification", "LIKE", "%$search%")
            ->orWhere("name", "LIKE", "%$search%")
            ->orWhere("phone", "LIKE", "%$search%")
            ->orWhere("direction", "LIKE", "%$search%");
    }

  }

  public static function listsAll($id)
  {
    return self::with('activities','neighborhood','consecutive','session')->where('id',$id)->first();
  }
    public function branchOffice(){
        return $this->hasOne(BranchOffice::class);
    }

	public function neighborhood()
	{
		 return $this->belongsTo(Neighborhood::class);
    }

  public function activity()
  {
    return $this->hasMany(EconomicActivitySysconf::class,'sysconf_id','id')->where('principal',true);
    }
  public function activities()
  {
    return $this->belongsToMany(EconomicActivity::class,'economic_activity_sysconfs','sysconf_id','economic_activity_id')->where('principal',true);
    }

  public function consecutive()
  {
    return $this->hasMany(ConsecutiveNumberFE::class,'sysconf_id','id');
    }

	public function invoices()
	{
		return $this->hasMany(Invoice::class);
    }
	public function customerConta()
	{
		return $this->hasOne(Customer::class)->where('name','Cliente Generico');
    }
	public function session()
	{
		return $this->hasOne(UserSession::class);
    }
}
