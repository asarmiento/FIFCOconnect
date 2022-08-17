<?php
	/**
	 * Created by PhpStorm.
	 * User: Anwar
	 * Date: 07/09/2017
	 * Time: 05:30 PM
	 */

	namespace App\Entities\Products;


	use App\Entities\General\BranchOffice;
	use App\Entities\Entity;

	/**
	 * Class Inventory
	 * @package App\Entities\Products
	 */
	class Inventory extends Entity
	{
		protected $table = 'inventories';
		protected $fillable = array('product_id', 'amount', 'branch_office_id');

		protected $guarded = array('id');

		protected $hidden = array('created_at', 'updated_at');
		protected $connection = 'mysql_fifco';
		public function product()
		{
			return $this->belongsTo(Product::class)
				->select(
					'id',
					'brand_id',
					'description',
					'product_type_id',
					'sale_price',
					'sale_method_id',
					'barcode',
					'cost',
					'status',
					'stock_min',
					'stock_max'
				)->where('sysconf_id',sysconf()->id);
		}

		public static function searchForProductExist($id)
		{
			return self::where('product_id', $id)->count();
		}

		public static function searchForProduct($id)
		{
			return self::where('product_id', $id)->first();
		}

		public static function createNewProductInventory(int $product, $amount)
		{
			self::create([
				'product_id'       => $product,
				'amount'           => $amount,
				'branch_office_id' => 3
			]);
		}

		public static function updateForProduct($id, $amount)
		{
			return self::where('product_id', $id)->update(['amount' => $amount]);
		}

		public function branchOffice()
		{
			return $this->belongsTo(BranchOffice::class);
		}

		// scopes
		public function scopeBranch($query, $id)
		{
			return $query->whereBranchOfficeId($id);
		}

		public function scopeProduct($query, $id)
		{
			return $query->whereProductId($id);
		}
	}
