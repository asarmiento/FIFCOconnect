<?php


namespace App\Entities\Customers;


use App\Entities\Entity;

class OpticalCustomerDetail extends Entity
{
	protected $connection = 'mysql_fifco';
  protected $table ='optical_customer_details';
  protected $fillable =[ 'optical_c_p_id', 'type', 'eye', 'sphere', 'cylinder', 'axis', 'addition', 'av'];
}
