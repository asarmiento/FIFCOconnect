<?php
	/**
	 * Created by PhpStorm.
	 * User: Anwar Sarmiento Ramo
	 * Date: 27/6/2018
	 * Time: 11:30:PM
	 */

	namespace App\Entities\Invoices;


	use App\Entities\Employee\InvoiceByEmployees;
	use App\Entities\Entity;
	use App\Entities\Products\Product;

	class ProductInvoice extends Entity
	{
		protected $table = 'products_by_invoices';

		protected $hidden = ['created_at'];

		public $timestamps = true;

		public function getRules()
		{
			// TODO: Implement getRules() method.
		}

		public function sumColumnData($invoice,$column,$data,$sum)
		{
			return $this->where('invoice_id',$invoice)->where($column,$data)->sum($sum);
}
		/**************************************************
		 * @Author: asarmiento Sarmiento
		 * @email:  asarmiento@sistemasamigableslatam.com
		 * @Update:
		 * @Date:   24/4/20
		 * @Time:   10:06
		 ***************************************************
		 * @Description:
		 ***************************************************
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 ***************************************************/
		public function products()
		{
			return $this->belongsTo(Product::getClass(), 'product_id', 'id');
		}

		/**
		 * -----------------------------------------------------------------------
		 * @Author     : Anwar Sarmiento <asarmiento@sistemasamigableslatam.com>
		 * @DateCreate : 27/6/2018
		 * @TimeCreate : 11:32:PM
		 * @DateUpdate : 0000-00-00
		 * -----------------------------------------------------------------------
		 * @description:
		 * @steps      :
		 * ----------------------------------------------------------------------
		 * @var
		 * ----------------------------------------------------------------------
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 *
		 * ----------------------------------------------------------------------
		 *
		 */
		public function invoices()
		{
			return $this->belongsTo(Invoice::getClass(), 'invoice_id', 'id');
		}

		public function inventoryUser()
		{
			return $this->belongsTo(InvoiceByEmployees::getClass(), 'invoice_id', 'invoice_id');
		}

		/**
		 * -----------------------------------------------------------------------
		 * @Author     : Anwar Sarmiento <asarmiento@sistemasamigableslatam.com>
		 * @DateCreate : 27/6/2018
		 * @TimeCreate : 11:32:PM
		 * @DateUpdate : 0000-00-00
		 * -----------------------------------------------------------------------
		 * @description:
		 * @steps      :
		 * ----------------------------------------------------------------------
		 * @var
		 * ----------------------------------------------------------------------
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 *
		 * ----------------------------------------------------------------------
		 *
		 */
		public function product()
		{
			return $this->belongsTo(Product::getClass());
		}
	}
