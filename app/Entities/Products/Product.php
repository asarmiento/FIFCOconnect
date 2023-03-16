<?php
/**
 * Created by PhpStorm.
 * User: Anwar
 * Date: 07/09/2017
 * Time: 01:13 PM
 */

namespace App\Entities\Products;


use App\Entities\General\EconomicActivity;
use App\Entities\Entity;
use App\Entities\Invoices\Invoice;
use App\Entities\Suppliers\Supplier;
use Illuminate\Support\Facades\DB;

class Product extends Entity
{
	protected $connection = 'mysql_fifco';
  protected $fillable = [
    'barcode',
    'code',
    'code_cabys',
    'container',
    'container_value',
    'units_per_box',
    'clothing_size',
    'description',
    'product_category_id',
    'category_id',
    'product_type_id',
    'volumetric_weight',
    'cost',
    'suggested',
    'tarifa_iva',
    'type_activity_id',
    'code_iva',
    'bonus',
    'utility',
    'sysconf_id',
    'percentage_of_utility',
    'sale_price',
    'sale_price2',
    'sale_price3',
    'sale_price4',
    'sale_price5',
    'brand_id',
    'sale_method_id',
    'status',
    'type_code',
    'presentation',
    'stock_min',
    'iva',
    'stock_max',
    'family',
    'sub_family',
    'description_web',
    'title_web',
    'description_title_web',
    'url_img',
    'url_img2',
    'url_img3',
    'url_img4',
    'type'
  ];

  protected $guarded = ['id'];

  protected $hidden = ['created_at'];

  public static $columns = [
    'Stock Min',
    'Stock Max',
    'Inv.',
    'Uni x Cajas',
    'Cod. Prov.',
    'Cod. Barra',
    'Descripción',
    'Tipo Prod.',
    'Costo',
    'Precio de Venta',
    'Utilidad',
    'Util. %',
    'Marca',
    'Categoria',
    'Familia',
    'Sub Familia',
    '',
  ];

  public function setDescriptionAttribute($value)
  {
    if (!empty($value)) {
      $this->attributes['description'] = strtoupper($value);
    }
  }
  public function getDescriptionAttribute()
  {

     return strtoupper($this->attributes['description']) ;

  }

  public function getCountCabysAttribute()
  {
    return $this->where('sysconf_id', sysconf()->id)->where('status', 'Activo')->whereNull('code_cabys')->count();
  }
  public function getCountActivityAttribute()
  {
    return $this->where('sysconf_id', sysconf()->id)->where('status', 'Activo')->whereNull('type_activity_id')->count();
  }

  public function scopeSearch($query, $search)
  {
    if (trim($search) != "") {
      $query->where('sysconf_id', sysconf()->id)
        ->where("description", "LIKE", "%$search%")
        ->orWhere("code", "LIKE", "%$search%")
        ->orWhere("code_cabys", "LIKE", "%$search%");
    }

  }
  public function scopeSearchInactive($query, $search)
  {
    if (trim($search) != "") {
      $query->where('sysconf_id', sysconf()->id)
        ->where("description", "LIKE", "%$search%")
        ->orWhere("barcode", "LIKE", "%$search%")
        ->orWhere("code", "LIKE", "%$search%")
        ->orWhere("code_cabys", "LIKE", "%$search%");
    }

  }

  public function scopeSearchCode($query, $search)
  {
    if (trim($search) != "") {
      $query->where('sysconf_id', sysconf()->id)->Where("barcode", "LIKE", "%$search%")
        ->orWhere("code", "LIKE", "%$search%");
    }

  }

  public function dataPaginate($search, $perPage)
  {
    return self::with('inventory')->with('productType')->with('productCategory', 'brand', 'activities')
      ->where('sysconf_id', sysconf()->id)->where('status', 'Activo')->where('barcode', '!=', 'NT')
      ->search($search)->orderBy('description', 'ASC')->paginate($perPage);
  }

  public function dataCodePaginate($search, $perPage)
  {
    return self::with('inventory')->with('productType')->with('productCategory', 'brand', 'activities')
      ->where('sysconf_id', sysconf()->id)->where('status', 'Activo')
      ->where('barcode', '!=', 'NT')
      ->where('barcode', $search)
      ->orderBy('description', 'ASC')->paginate($perPage);
  }

  public function dataIvaPaginate($search, $iva, $perPage)
  {
    return self::with('inventory')->with('productType')->with('productCategory', 'brand', 'activities')
      ->where('sysconf_id', sysconf()->id)->where('iva', $iva)->where('status', 'Activo')->where('barcode', '!=', 'NT')
      ->search($search)->orderBy('description', 'ASC')->paginate($perPage);
  }

  public function dataIvaCategoryPaginate($search, $iva, $category, $perPage)
  {
    return self::with('inventory')->with('productType')->with('productCategory', 'brand', 'activities')
      ->where('sysconf_id', sysconf()->id)->where('iva', $iva)->where('product_category_id', $category)->where('status', 'Activo')->where('barcode', '!=', 'NT')
      ->search($search)->orderBy('description', 'ASC')->paginate($perPage);
  }

  public function dataIvaBrandPaginate($search, $iva, $brand, $perPage)
  {
    return self::with('inventory')->with('productType')->with('productCategory', 'brand', 'activities')
      ->where('sysconf_id', sysconf()->id)->where('iva', $iva)->where('brand_id', $brand)->where('status', 'Activo')->where('barcode', '!=', 'NT')
      ->search($search)->orderBy('description', 'ASC')->paginate($perPage);
  }

  public function dataBrandCategoryPaginate($search, $brand, $category, $perPage)
  {
    return self::with('inventory')->with('productType')->with('productCategory', 'brand', 'activities')
      ->where('sysconf_id', sysconf()->id)->where('product_category_id', $category)->where('brand_id', $brand)->where('status', 'Activo')->where('barcode', '!=', 'NT')
      ->search($search)->orderBy('description', 'ASC')->paginate($perPage);
  }

  public function dataBrandPaginate($search, $brand, $perPage)
  {
    return self::with('inventory')->with('productType')->with('productCategory', 'brand', 'activities')
      ->where('sysconf_id', sysconf()->id)->where('brand_id', $brand)->where('status', 'Activo')->where('barcode', '!=', 'NT')
      ->search($search)->orderBy('description', 'ASC')->paginate($perPage);
  }

  public function dataCategoryPaginate($search, $category, $perPage)
  {
    return self::with('inventory')->with('productType')->with('productCategory', 'brand', 'activities')
      ->where('sysconf_id', sysconf()->id)->where('product_category_id', $category)->where('status', 'Activo')->where('barcode', '!=', 'NT')
      ->search($search)->orderBy('description', 'ASC')->paginate($perPage);
  }

  public function dataIvaBrandCategoryPaginate($search, $iva, $brand, $category, $perPage)
  {
    return self::with('inventory')->with('productType')->with('productCategory', 'brand', 'activities')
      ->where('sysconf_id', sysconf()->id)->where('product_category_id', $category)->where('brand_id', $brand)->where('iva', $iva)->where('status', 'Activo')->where('barcode', '!=', 'NT')
      ->search($search)->orderBy('description', 'ASC')->paginate($perPage);
  }

  public function dataInactivePaginate($search, $perPage)
  {
    return self::with('inventory')->with('productType')->with('productCategory')->with('brand')
      ->where('sysconf_id', sysconf()->id)->where('status', 'Inactivo')
      ->searchInactive($search)->orderBy('description', 'ASC')->paginate($perPage);
  }

  public static function listsLabel()
  {
    $products = self::where('sysconf_id', sysconf()->id)->where('description', '<>', 'Producto Generico')->get();
    $lists = [];
    foreach ($products AS $product) {
      array_push($lists, ['label' => $product->description . ' ' . $product->brand->name, 'value' => $product->id]);
    }

    return $lists;
  }

  /**
   * @return array
   */
  public static function listsLabelActive()
  {
    $products = self::select(DB::raw("CONCAT(barcode, ' | Precio: ',  sale_price, ' | ',  description, ' | ',iva,'%') AS label"),
      'id AS value')
      ->where('sysconf_id', sysconf()->id)->whereNotNull('code_cabys')->where('status', 'Activo')->where('description', '<>', 'Producto Generico')->get();

    return $products;
  }

  public static function listsLabelReception()
  {
    $products = self::select(DB::raw("CONCAT(description, ' | Precio: ',  sale_price, ' | ',iva,'%') AS label"),
      'id AS value')
      ->where('sysconf_id', sysconf()->id)->whereNotNull('code_cabys')->where('status', 'Activo')->where('description', '<>', 'Producto Generico')->get();

    return $products;
  }

  public static function listsLabelRestaurant($search)
  {
    if (trim($search) == "") {
      $products = self::where('sysconf_id', sysconf()->id)->where('status', 'Activo')->where('description', '<>', 'Producto Generico')->get();
    } else {
      $products = self::where('sysconf_id', sysconf()->id)->Where("barcode", "LIKE", "%$search%")
        ->orWhere("code", "LIKE", "%$search%")->where('status', 'Activo')->get();
    }

    $lists = [];
    foreach ($products AS $product) {
      if ($product->sysconf_id == sysconf()->id) {
        array_push($lists, ['label' => $product->description, 'value' => $product->id]);
      }
    }

    return $lists;
  }

  public static function listsLabelAllPrice($id)
  {
    $products = self::where('sysconf_id', sysconf()->id)->find($id);
    $lists = [
      ['label' => $products->sale_price, 'value' => $products->sale_price],

    ];
    if ($products->sale_price2 > 0) {
      array_push($lists, ['label' => $products->sale_price2, 'value' => $products->sale_price2]);
    }
    if ($products->sale_price3 > 0) {
      array_push($lists, ['label' => $products->sale_price3, 'value' => $products->sale_price3]);
    }
    if ($products->sale_price4 > 0) {
      array_push($lists, ['label' => $products->sale_price4, 'value' => $products->sale_price4]);
    }
    if ($products->sale_price5 > 0) {
      array_push($lists, ['label' => $products->sale_price5, 'value' => $products->sale_price5]);
    }


    return $lists;
  }

  public static function listsLabelBuy($id)
  {
    $products = self::where('sysconf_id', sysconf()->id)->whereHas('brand', function ($q) use ($id) {
      $q->whereHas('suppliers', function ($r) use ($id) {
        $r->where('supplier_id', $id);
      });
    })->where('status', 'Activo')->get();
    $lists = [];
    foreach ($products AS $product) {
      array_push($lists, ['label' => $product->barcode . ' | ' . $product->description, 'value' => $product->id]);
    }

    return $lists;
  }

  public function productCategory()
  {
    return $this->belongsTo(ProductCategory::class,'product_category_id','id')->select('id', 'name')
      ->where('sysconf_id', sysconf()->id);
  }

  public function category()
  {
    return $this->belongsTo(ProductCategory::class,'category_id','id')->select('id', 'name')
      ->where('sysconf_id', sysconf()->id);
  }


  public function productCat()
  {
    return $this->belongsTo(ProductCategory::class,'category_id','id')->where('sysconf_id', sysconf()->id);
  }

  public function productSaleSummary()
  {
    return $this->hasMany(ProductSalesSummary::class)->where('sysconf_id', sysconf()->id);
  }

  public function productType()
  {
    return $this->belongsTo(ProductType::class, 'product_type_id')
      ->select('id', 'name');
  }

  public function brand()
  {//->where('sysconf_id', sysconf()->id)
    return $this->belongsTo(Brand::class)->select('id', 'name');
  }

  public function saleMethod()
  {
    return $this->belongsTo(SaleMethod::class)->select('id', 'name', 'code','service');
  }

  public function supplier()
  {
    return $this->belongsTo(Supplier::class)->where('sysconf_id', sysconf()->id);
  }

  public function inventory()
  {
    return $this->hasOne(Inventory::class,'product_id','id');
  }

  // poder revisar esta relacion ya que esta mal implementada
  public function inventoryByUser()
  {
    return $this->belongsToMany(InventoryByUser::class, 'inventory_by_users');
  }

  public function typeTax()
  {
    return $this->hasOne(TypeOfCompanyTax::class)->where('sysconf_id', sysconf()->id);
  }

  public function inventories()
  {
    return $this->hasOne(Inventory::class);
  }

  public function scopeBranch($query, $id)
  {
    return $query->whereBranchOfficeId($id)->where('sysconf_id', sysconf()->id);
  }


  public function productInvoices()
  {
    return $this->hasMany(ProductsByInvoice::class);
  }

  public function productTemps()
  {
    return $this->hasMany(ProductsTemp::class);
  }

  public function temporaryInventory()
  {
    return $this->hasOne(TemporaryInventory::class);
  }

  public function manualInventories()
  {
    return $this->belongsToMany(ManualInventory::class, 'detail_manual_inventories')->where('sysconf_id', sysconf()->id);
  }

  public function activities()
  {
    return $this->belongsTo(EconomicActivity::class, 'type_activity_id', 'id');
  }

  public function ChangeHistoryOfStocks()
  {
    return $this->hasMany(ChangeHistoryOfStock::class);
  }

  public function invoices()
  {
    // verify relation
    // return $this->belongsToMany(Invoice::class(),'products_by_invoices')->withPivot('amount','price','batch_of_product_id');
    return $this->belongsToMany(Invoice::class, 'products_by_invoices')
      ->withPivot('expiration_date', 'date_invoice',
        'return_months', 'amount', 'price', 'delivered', 'm_total',
        'm_discount', 'subtotal', 'm_tax', 'total', 'type')->where('sysconf_id', sysconf()->id);
  }

  public function countProductInvoice()
  {
    return $this->belongsToMany(Invoice::class, 'products_by_invoices')->where('sysconf_id', sysconf()->id);
  }

  public function amountSale()
  {
    return $this->hasMany(ProductInvoices::class)->where('sysconf_id', sysconf()->id);
  }

  public function temporary_inventories()
  {
    return $this->hasOne(TemporaryInventory::class)->where('sysconf_id', sysconf()->id);
  }

  public function getAmountSaleAttribute()
  {
    return 'ver';
  }

  public function getInventoryAmountAttribute()
  {
    return $this->inventory->amount;
  }

  public static function countNotification()
  {
    $date = self::outDate();

    return Product::where('due_date', '<=', $date)->where('invoice_type_id', 1)->where('sysconf_id', sysconf()->id)
      ->where('paid_up', 0)->where('payment_method_id', 2);
  }

  public static function listsProductsCategories()
  {
    return self::whereNull('category_id')->where('status','Activo')->with('saleMethod')->orderBy('description','ASC')->get();
  }
}
