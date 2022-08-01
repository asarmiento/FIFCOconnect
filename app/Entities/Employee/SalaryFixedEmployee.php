<?php


namespace App\Entities\Employee;


use App\Entities\Entity;

class SalaryFixedEmployee extends Entity
{
	protected $table = 'fixed_salary_payments';
	protected $fillable = ['date','name', 'amount', 'type'];
}
