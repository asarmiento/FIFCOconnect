<?php


namespace App\Entities\Products;


use App\Entities\Entity;

class ProductByTax extends Entity
{
    protected $table ='product_by_taxs';
    protected $fillable =['product_by_invoice_id', 'code_iva', 'factor_iva', 'tax', 'factor', 'amount'];
}