<?php

namespace App\Entities\Invoices;

use App\Entities\Config\User;
use App\Entities\Entity;
use Illuminate\Database\Eloquent\Model;

class TemporaryAssignedInvoice extends Entity
{
  protected $table = 'temporary_assigned_invoices';
    protected $fillable = ['invoice_id','user_id'];
	
	public $timestamps = true;
	
	public function invoice()
	{
		return $this->belongsTo(Invoice::class);
	}
	
	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
