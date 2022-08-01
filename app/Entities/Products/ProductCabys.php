<?php
  /**
   * File ProductCabys
   * User Anwar Sarmiento
   * Date 10/9/2020
   * @package App\Entities\Products
   */

  namespace App\Entities\Products;


  use App\Entities\Entity;

  class ProductCabys extends Entity
  {
    protected $table = "products_cabys";
    protected $fillable = [
      'category_1',
      'desc_category_1',
      'category_2',
      'desc_category_2',
      'category_3',
      'desc_category_3',
      'category_4',
      'desc_category_4',
      'category_5',
      'desc_category_5',
      'category_6',
      'desc_category_6',
      'category_7',
      'desc_category_7',
      'category_8',
      'desc_category_8',
      'code',
      'description',
      'iva'
    ];

    public function scopeSearch($query, $search)
    {
      if(trim($search) != "") {
        $query->where("code", "LIKE", "%$search%")
            ->orWhere("description", "LIKE", "%$search%");
      }

    }
    public function dataPaginate($search,$perPage)
    {
      return self::search($search)->orderBy('status','ASC')->paginate($perPage);
    }
  }