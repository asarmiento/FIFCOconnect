<?php
/**
 * Created by PhpStorm.
 * User: Anwar Sarmiento Ramo
 * Date: 15/2/2018
 * Time: 12:05:AM
 */

namespace App\Entities\Products;


use App\Entities\Entity;

class Bonus extends Entity
{

    protected $fillable = ['reference','sysconf_id','product_id','product_sale','bonus_product_id','product_bonus','expiration'];

    public static $columns = [
        'reference','product_id','product_sale','bonus_product_id','product_bonus','expiration'
    ];
    public function product(){

       return $this->belongsTo(Product::class);

    }

    public function bonusProduct()
    {
       return $this->belongsTo(Product::class,'bonus_product_id','id');
    }

    public function scopeSearch($query, $search)
    {
        if (trim($search) != "")
        {
            $query->whereHas("product", function ($q) use ($search)
            {
                $q->where('description', "LIKE", "%$search%");
                $q->orWhere('barcode', "LIKE", "%$search%");
                $q->orWhere('code', "LIKE", "%$search%");
            })->orWhere("expiration", "LIKE", "%$search%");
        }

    }
}