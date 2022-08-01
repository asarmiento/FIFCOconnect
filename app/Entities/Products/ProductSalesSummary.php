<?php

namespace App\Entities\Products;

use Illuminate\Database\Eloquent\Model;

class ProductSalesSummary extends Model
{
    protected $table = 'product_sales_summary';

    protected $fillable = ['product_id','amount','price','discount','date','bonus'];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
