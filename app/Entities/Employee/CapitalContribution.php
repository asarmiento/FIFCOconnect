<?php
//modelos
namespace App\Entities\Employee;

use App\Entities\General\User;
use App\Entities\Entity;
use Illuminate\Database\Eloquent\Model;

class CapitalContribution extends Entity
{

  protected $table ='capital_contributions';

  protected $fillable = ['description','date','consecutive_number','amount','employee_id','user_id'];

  public function scopeSearch($query, $search)
  {
    if(trim($search) != ''){
      $query->whereHas('employee',function ($q) use($search){
        $q->Where('name','LIKE',"%$search%");
      })->where('date','LIKE',"%$search%")->orWhere('description','LIKE',"%$search%");
    }

  }
  public function employee()
  {
    return $this->belongsTo( Employee::class);
  }


  public function user()
  {
    return $this->belongsTo(User::class);
  }


}
