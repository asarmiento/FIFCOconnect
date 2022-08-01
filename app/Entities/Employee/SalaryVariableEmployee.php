<?php


namespace App\Entities\Employee;


use App\Entities\Entity;

class SalaryVariableEmployee extends Entity
{
		protected $table = 'variable_salary_payments';
		protected $fillable = ['fixed_salary_payment_id', 'name', 'amount'];

}
