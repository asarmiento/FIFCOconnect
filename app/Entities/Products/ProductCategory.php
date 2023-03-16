<?php
  /**
   * Created by PhpStorm.
   * User: Anwar
   * Date: 13/09/2017
   * Time: 12:18 AM
   */

  namespace App\Entities\Products;


  use App\Entities\Entity;

  class ProductCategory extends Entity
  {
    protected $fillable = ['code', 'name', 'recharge', 'sysconf_id'];

    protected $guarded = ['id'];


    public static function getInsert($data)
    {
return self::create($data);
    }

    /**
     * -----------------------------------------------------------------------
     * @Author     : Anwar Sarmiento <asarmiento@sistemasamigableslatam.com>
     * @DateCreate : 2017-09-13
     * @TimeCreate : 12:19am
     * @DateUpdate : 0000-00-00
     * -----------------------------------------------------------------------
     * @description:
     * @pasos      :
     * ----------------------------------------------------------------------
     *
     *  * @var ${TYPE_NAME}
     * * ----------------------------------------------------------------------
     *  * @return $this
     * ----------------------------------------------------------------------
     * *
     */
    public function products()
    {
      return $this->hasMany(Product::class,'product_category_id','id')->orderBy('description','ASC');
    }

    public function productos()
    {
      return $this->hasMany(Product::class);
    }

    public function productCat()
    {
      return $this->hasMany(Product::class,'category_id','id');
    }

    public function scopeSearch($query, $search)
    {
      if (trim($search) != "")
      {
        $query->where("name", "LIKE", "%$search%");
      }

    }

    public static function listsLabel()
    {
      $productCategories = ProductCategory::where('sysconf_id',sysconf()->id)->get();
      $lists = [];
      foreach ($productCategories AS $productCategory)
      {
        array_push($lists, ['label' => $productCategory->name, 'value' => $productCategory->id]);
      }

      return $lists;
    }

    public static function listsFilterLabel($menu)
    {
      $productCategories = ProductCategory::whereHas('products',function ($product) use($menu){
        $product->where('family','LIKE',"%$menu%");
      })->where('sysconf_id',sysconf()->id)->get();
      $lists = [];
      foreach ($productCategories AS $productCategory)
      {
        array_push($lists, ['label' => $productCategory->name, 'value' => $productCategory->id]);
      }

      return $lists;
    }

    public static function listsLabelCommission()
    {
      $productCategories = ProductCategory::where('sysconf_id',sysconf()->id)->where('recharge',1)->get();
      $lists = [];
      foreach ($productCategories AS $productCategory)
      {
        array_push($lists, ['label' => $productCategory->name, 'value' => $productCategory->id]);
      }

      return $lists;
    }

    public static function consultListsLabel($id)
    {
      $productCategories = ProductCategory::where('id',$id)->get();
      $lists = [];
      foreach ($productCategories AS $productCategory)
      {
        array_push($lists, ['label' => $productCategory->name, 'value' => $productCategory->id]);
      }

      return $lists;
    }
  }
