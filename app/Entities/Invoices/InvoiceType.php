<?php
/**
 * Created by PhpStorm.
 * User: Anwar
 * Date: 13/09/2017
 * Time: 12:13 AM
 */

namespace App\Entities\Invoices;


use App\Entities\Entity;

class InvoiceType extends Entity
{
    protected $fillable = array('name');

    protected $guarded = array('id');
}