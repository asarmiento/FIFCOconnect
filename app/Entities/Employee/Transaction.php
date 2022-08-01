<?php
  /**
   * Created by PhpStorm.
   * User: Anwar
   * Date: 21/12/2018
   * Time: 02:38:PM
   */

  namespace App\Entities\Employee;


  use App\Entities\General\User;
  use App\Entities\Entity;
  use App\Entities\Invoices\Invoice;
  use App\Entities\Products\ProductCategory;

  class Transaction extends Entity
  {
    protected $table = 'transactions';
    protected $fillable = [ 'user_id', 'product_category_id', 'presentation', 'porcent', 'amount', 'status'];

    public function user()
    {
      return $this->belongsTo(User::class);
    }

    public function productCategory()
    {
      return $this->belongsTo(ProductCategory::class);
    }

  }
