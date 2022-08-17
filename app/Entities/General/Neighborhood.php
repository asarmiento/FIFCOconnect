<?php
	/**
	 * Created by PhpStorm.
	 * User: Anwar Sarmiento Ramo
	 * Date: 26/8/2018
	 * Time: 03:15:AM
	 */

	namespace App\Entities\General;


	use App\Entities\Entity;

	class Neighborhood extends Entity
	{
		protected $table = 'neighborhoods';
		protected $connection = 'mysql_fifco';
		protected $fillable = ['code_province', 'name_province', 'code_canton', 'name_canton', 'code_district', 'name_district', 'code', 'name'];

		public static function listsLabel()
		{
			$zones = self::all();
			$lists =[];
			foreach ($zones AS $zone){
				array_push($lists,['label'=>$zone->name_province.' | '.$zone->name_canton.' | '.$zone->name_district.' | '.$zone->name,'value'=>$zone->id]);
			}

			return $lists;
		}

		public static function listsLabelId($id)
		{
			$zone = self::find($id);
			$lists = ['label'=>$zone->name_province.' | '.$zone->name_canton.' | '.$zone->name_district.' | '.$zone->name,'value'=>$zone->id];


			return $lists;
		}
	}
