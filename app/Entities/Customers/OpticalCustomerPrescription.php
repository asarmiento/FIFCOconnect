<?php


namespace App\Entities\Customers;


use App\Entities\Entity;

class OpticalCustomerPrescription extends Entity
{
	protected $connection = 'mysql_fifco';
 protected $table ='optical_customer_prescriptions';
 protected $fillable =['customer_id', 'invoice_id', 'date', 'lensometry', 'refraction', 'observation', 'dp', 'height'];

	public function details()
	{
		return $this->hasMany(OpticalCustomerDetail::class,'optical_c_p_id','id');
 }
}
