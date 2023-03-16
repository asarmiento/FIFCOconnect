<?php
/**
 * Created by PhpStorm.
 * User: Anwar
 * Date: 07/09/2017
 * Time: 02:16 PM
 */

namespace App\Entities\Employee;


use App\Entities\General\BranchOffice;
use App\Entities\General\User;
use App\Entities\Entity;
use App\Entities\Invoices\Invoice;
use App\Entities\Zone;

class Employee extends Entity
{
    protected $fillable = array('code','name','last_name','sysconf_id','phone','email','cellphone','salary','zone_id','token','branch_office_id');

    protected $guarded = array('id');

    protected $hidden = array('created_at','updated_at');


    public function scopeSearch($query, $search)
    {
        if (trim($search) != "") {
            $query->where('sysconf_id', sysconf()->id)
                ->where("name", "LIKE", "%$search%")
                ->orWhere("last_name", "LIKE", "%$search%");
        }
    }
    /**
     * Revisar esta relación, solo debería ser hasOne
     */
    public function user()
    {
        return $this->userOne(User::class);
    }

    public function userOne()
    {
        return $this->hasOne(User::class);
    }

    public function branchOffice()
    {
        return $this->belongsTo(BranchOffice::class);
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

  public function records()
  {
    return $this->hasMany(RecordActivity::class,'');
    }
    public function nameComplete()
    {
        return $this->name.' '.$this->last_name;
    }
    public function invoiceByEmployeesDistributor()
    {
        return $this->hasMany(InvoiceByEmployees::class)->where('status', 'distributor');
    }
    public function invoicesDistributor()
    {
        return $this->belongsToMany(Invoice::class,'invoice_by_employees');
    }

    public function invoiceDistributor($date)
    {
        return $this->belongsToMany(Invoice::class,'invoice_by_employees')
            ->wherePivot('updated_at','>=',$date);
    }
	public static function listsLabel()
	{
		$customers = self::where('sysconf_id',sysconf()->id)->has('userOne')->where('id' ,'>', 3)->get();
		$lists =[];
		foreach ($customers AS $customer){
			array_push($lists,['label'=>
				                   ' Nombre Distribuidor: '.$customer->name.
				                   '  '.$customer->last_name,
			                   'value'=>$customer->id]);
		}

		return $lists;
	}
	public static function listsAllLabel()
	{

		$customers = self::where('sysconf_id',sysconf()->id)->where('id' ,'>', 3)->get();
		$lists =[];
		foreach ($customers AS $customer){
			array_push($lists,['label'=>
				                   ' Nombre Distribuidor: '.$customer->name.
				                   '  '.$customer->last_name,
			                   'value'=>$customer->id]);
		}

		return $lists;
	}
	public static function listsAllEmployee()
	{
		$customers = self::where('sysconf_id',sysconf()->id)->where('id' ,'>', 3)->has('userOne')->get();
		$lists =[];
		foreach ($customers AS $customer){
			array_push($lists,['label'=>
				                   ' Nombre Distribuidor: '.$customer->name.
				                   '  '.$customer->last_name,
			                   'value'=>$customer->id]);
		}

		return $lists;
	}
	public static function listsEmployeeAllLabel()
	{
		$customers = self::where('sysconf_id',sysconf()->id)->where('id' ,'>', 3)->get();
		$lists =[];
		foreach ($customers AS $customer){
			array_push($lists,['label'=>
				                   ' Nombre Colaborador: '.$customer->name.
				                   '  '.$customer->last_name,
			                   'value'=>$customer->id]);
		}

		return $lists;
	}
}
