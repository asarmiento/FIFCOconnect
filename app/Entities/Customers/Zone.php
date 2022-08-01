<?php

namespace App\Entities\Customers;



use App\Entities\Entity;

class Zone extends Entity
{
  protected $fillable = ['name','sysconf_id'];

  protected $guarded = ['id'];

  protected $connection = 'mysql';

  protected $hidden = ['created_at', 'updated_at'];

  public function customer()
  {
    return $this->belongsToMany(Customer::class, 'customer_by_zones');
  }

  public function employee()
  {
    return $this->hasMany(Employee::getClass());
  }

  public static function listsLabel()
  {
    $zones = Zone::all();
    $lists = [];
    foreach ($zones AS $zone)
    {
      array_push($lists, ['label' => $zone->name, 'value' => $zone->id]);
    }

    return $lists;
  }
}
