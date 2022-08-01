<?php
/**
 * Created by PhpStorm.
 * User: Anwar
 * Date: 07/09/2017
 * Time: 05:35 PM
 */

namespace App\Entities\Products;


use App\Entities\Entity;
use App\Entities\Suppliers\Supplier;

/**
 * Class Brand
 * @package App\Entities\Products
 */
class Brand extends Entity
{
    protected $fillable = array('name','sysconf_id');

    protected $guarded = array('id');

    protected $hidden = array('created_at','updated_at');


  public static function getInsert($data)
  {
   return self::create($data);
    }
    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class,'brands_by_suppliers');
    }

    public function products()
    {
        return $this->hasMany(Product::class,'brand_id','id')->orderBy('description','ASC');
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
		$brands = Brand::where('sysconf_id',sysconf()->id)->orderBy('name','ASC')->get();
		$lists =[];
		foreach ($brands AS $brand){
			array_push($lists,['label'=>$brand->name,'value'=>$brand->id]);
		}

		return $lists;
	}
	public static function listsLabelFilter($menu)
	{
		$brands = Brand::whereHas('products',function ($product) use($menu){
		  $product->where('family','LIKE',"%$menu%");
    })->where('sysconf_id',sysconf()->id)->orderBy('name','ASC')->get();
		$lists =[];
		foreach ($brands AS $brand){
			array_push($lists,['label'=>$brand->name,'value'=>$brand->id]);
		}

		return $lists;
	}
}
