<?php


  namespace App\Entities\Products;


  use App\Entities\Entity;

  class BrandSupplier extends Entity
  {
    protected $table = 'brands_by_suppliers';
    protected $fillable = ['supplier_id', 'brand_id'];



  }
