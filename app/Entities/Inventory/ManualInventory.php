<?php
	/**
	 * Created by PhpStorm.
	 * User: Anwar Sarmiento Ramo
	 * Date: 22/6/2018
	 * Time: 01:05:AM
	 */
	
	namespace App\Entities\Inventory;
	
	
	use App\Entities\Entity;
	
	class ManualInventory extends Entity
	{
		protected $table = 'manual_inventories';
		
		
		protected $fillable = ['date','user_id','branch_office_id'];
	}