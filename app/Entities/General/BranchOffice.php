<?php
/**
 * Created by PhpStorm.
 * User: Anwar
 * Date: 07/09/2017
 * Time: 02:18 PM
 */

namespace App\Entities\General;


use App\Entities\Boxes\CashDesk;
use App\Entities\Customers\Receipt;
use App\Entities\Employee\Employee;
use App\Entities\Entity;
use App\Entities\Inventory\ManualInventory;
use App\Entities\Invoices\Invoice;
use App\Entities\Products\Inventory;

class BranchOffice extends Entity
{
    protected $fillable = ['name','sysconf_id'];

    protected $guarded = array('id');
	protected $connection = 'mysql_fifco';
  public static function getInsert($data)
  {
    self::create($data);
    }
    /**
     * -----------------------------------------------------------------------
     * @Author: Anwar Sarmiento <asarmiento@sistemasamigableslatam.com>
     * @DateCreate: ${DATE}
     * @TimeCreate: $TIME$
     * @DateUpdate: 0000-00-00
     * -----------------------------------------------------------------------
     * @description:
     * @pasos:
     * ----------------------------------------------------------------------
     *
     *  * @var ${TYPE_NAME}
     * * ----------------------------------------------------------------------
     *  * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * ----------------------------------------------------------------------
     * *
     */
    public function sysconf()
    {
        return $this->belongsTo(Sysconf::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function cashDesks()
    {
        return $this->hasMany(CashDesk::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function receipts()
    {
        return $this->hasMany(Receipt::class);
    }

    public function manualInventories()
    {
        return $this->hasMany(ManualInventory::class);
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }
}
