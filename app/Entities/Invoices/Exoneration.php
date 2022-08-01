<?php
  /**
   * Created by PhpStorm.
   * User: Anwar
   * Date: 28/3/2019
   * Time: 09:18:PM
   */
  
  namespace App\Entities\Invoices;
  
  
  use App\Entities\Entity;
  use App\Entities\Products\Product;

  class Exoneration extends Entity
  {
    protected $table = 'exonerations';
    
    protected $fillable = [
      'type_document', 'number_document','product_by_invoice_id', 'name_institutions', 'date_emition', 'porcent_exoneration','amount_tax',
      'amount_exoneration', 'impuesto_neto', 'invoice_id','product_id','p_tax'
    ];
    
    public function invoice()
    {
      return $this->belongsTo(Invoice::class);
    }
    
    public function product()
    {
      return $this->belongsTo(Product::class);
    }

    public static function consultInvoiceExo($invoice)
    {
      return self::where('invoice_id',$invoice);
    }
  }
