<?php
  /**
   * Created by PhpStorm.
   * User: Anwar
   * Date: 8/3/2019
   * Time: 02:32:AM
   */

  namespace App\Entities\Customers;


  use App\Entities\Entity;

  class TypeOfAccountingRecord extends Entity
  {
	  protected $connection = 'mysql_fifco';
     protected $table ='types_of_accounting_records';

     protected $fillable = ['customer_id', 'renta', 'ventas', 'd151', 'status', 'monthly', 'amount', 'user_id'];

     public function customer()
     {
       return $this->belongsTo(Customer::class);
     }
  }
