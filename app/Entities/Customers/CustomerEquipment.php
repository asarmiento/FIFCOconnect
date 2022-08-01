<?php
/**
 * @project   FriendlyPos
 * @Created   Sistemas Amigables Latinoamérica S.A.
 * @date      6/28/2022
 * @developed Anwar Sarmiento
 */

namespace App\Entities\Customers;


use App\Entities\Entity;

class CustomerEquipment extends Entity
{
		protected $table = "customer_equipments";

		protected $fillable = ["customer_id", "placa", "doors", "models"];

	public function customer()
	{
		return $this->belongsTo(Customer::class,'customer_id','id');
		}
}
