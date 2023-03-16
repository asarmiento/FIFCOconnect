<?php
	/**
	 * Created by PhpStorm.
	 * User: asarmiento
	 * Date: 5/2/20
	 * Time: 08:41
	 */

	namespace App\Entities\Products;


	use App\Entities\Entity;

	class Segment extends Entity
	{
		protected $table = "segments";
		protected $fillable = ['name','sysconf_id'];

		public static $columns = ['name'];


		public function scopeSearch($query, $search)
		{
			if(trim($search) != "") {
				$query->where("name", "LIKE", "%$search%");
			}

		}

		public function vueSelect(){
			return self::select('name AS label','name AS value')->get();
		}
	}
