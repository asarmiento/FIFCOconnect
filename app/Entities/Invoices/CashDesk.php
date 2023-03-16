<?php
/**
 * Created by PhpStorm.
 * User: Anwar
 * Date: 13/09/2017
 * Time: 01:50 AM
 */

namespace App\Entities\Invoices;


use App\Entities\Config\User;
use App\Entities\Customers\Receipt;
use App\Entities\Entity;

class CashDesk extends Entity
{
    protected $fillable = array('name');

    protected $guarded = array('id');

    public function users()
    {
        return $this->belongsToMany(User::class,'user_by_cash_desks');
    }

    public function closingCashDesks()
    {
        return $this->hasMany(ClosingCashDesk::getClass());
    }

    public function receipts()
    {
        return $this->hasMany(Receipt::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}