<?php


  namespace App\Entities\General;


  use App\Entities\Entity;

  class EconomicActivity extends Entity
  {

	  protected $connection = 'mysql_fifco';
		public static function consultCode($code)
		{
			return self::where('code',$code)->first();
  	}

    public static function listsLabel()
    {
      $customers = self::all();
      $lists =[];
      foreach ($customers AS $customer){
        array_push($lists,['label'=>
                             ' Actividad Ec.: '.$customer->code.
                             '  '.$customer->name,
                           'value'=>$customer->id]);
      }

      return $lists;
    }

  }
