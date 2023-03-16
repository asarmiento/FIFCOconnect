<?php
  /**
   * Created by PhpStorm.
   * User: Anwar
   * Date: 13/1/2019
   * Time: 03:56:AM
   */
  
  namespace App\Entities\Employee;
  
  
  use App\Entities\Entity;

  class Activity extends Entity
  {
    protected $table = 'activities';
    protected $fillable = ['name','type','token'];
  
    public static function listsLabelProduct()
    {
      $customers = self::where('type','product')->get();
      $lists =[];
      foreach ($customers AS $customer){
        array_push($lists,['label'=>
        $customer->name,
                           'value'=>$customer->id]);
      }
    
      return $lists;
    }
    public static function listsLabelActivity()
    {
      $customers = self::where('type','activity')->get();
      $lists =[];
      foreach ($customers AS $customer){
        array_push($lists,['label'=>
        $customer->name,
                           'value'=>$customer->id]);
      }
    
      return $lists;
    }
  }
