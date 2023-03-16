<?php


namespace App\Entities\Products;


use App\Entities\Entity;

class ProductByDiscount extends Entity
{
    protected $table = 'product_by_discount';
        protected $fillable = ['product_by_invoice_id', 'amount_discount', 'nature_discount'];
}