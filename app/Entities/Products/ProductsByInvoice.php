<?php
/**
 * Created by PhpStorm.
 * User: Anwar
 * Date: 26/11/2017
 * Time: 12:48 AM
 */

namespace App\Entities\Products;


use App\Entities\Entity;
use App\Entities\Invoices\Invoice;
use App\Entities\Invoices\Sale;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductsByInvoice extends Entity
{
  protected $table = "products_by_invoices";
	protected $connection = 'mysql_fifco';
  protected $fillable = [
    'type_activity_id',
    'product_id',
    'code_cabys',
    'expiration_date',
    'return_months',
    'invoice_id',
    'date_invoice',
    'batch_of_product_id',
    'description',
    'status',
    'service_prof',
    'unit_product',
    'unit_product_id',
    'price',
    'amount',
    'amount_distribuitor',
    'm_total',
    'discount',
    'm_discount',
    'natu_descuento',
    'subtotal',
    'rate',
    'code_iva',
    'tariff_iva',
    'm_tax',
    'exonerado',
    'impuesto_neto',
    'total',
    'applied',
    'discount_per_lot',
    'refund',
    'delivered',
    'bonus',
    'type'
  ];
  public $incrementing = true;

  public function scopeSearch($query, $search)
  {
    if (trim($search) != "") {
      $query->orWhere("expiration_date", "LIKE", "%$search%");
    }

  }

  public function product()
  {
    return $this->belongsTo(Product::class);
  }

  public function invoice()
  {
    return $this->belongsTo(Invoice::class);
  }

  public function sale()
  {
    return $this->belongsTo(Sale::class,'invoice_id','invoice_id');
  }


  /**
   * Consultas a la tabla
   */
  public static function sumColumnTwoData($invoice, $column, $data, $columnOne, $typeOne, $dataOne, $sum)
  {
    return self::where('invoice_id', $invoice)->where($column, $data)->where($columnOne, $typeOne, $dataOne)->sum($sum);
  }

  public static function sumColumnOneData($invoice, $column, $type, $data, $sum)
  {
    return self::where('invoice_id', $invoice)->where($column, $type, $data)->sum($sum);
  }

  public static function sumColumnData($invoice, $sum)
  {
    return self::where('invoice_id', $invoice)->sum($sum);
  }

  public function consultInvoicesSummary($dateI, $dateF, $syste, $sum)
  {
    return ProductsByInvoice::whereHas('invoice', function ($i) use ($dateI, $dateF, $syste) {
      $i->where('invoice_type_id', 2)
        ->where('sysconf_id', $syste->id)->where('ind_estado', 'aceptado');
    })->whereBetween('date_invoice', [$dateI, $dateF])->sum($sum);
  }

  public function consultInvoicesTypeSummary($dateI, $dateF, $syste, $sum, $tax, $parameter)
  {
    return ProductsByInvoice::whereHas('invoice', function ($i) use ($dateI, $dateF, $syste) {
      $i->where('invoice_type_id', 2)
        ->where('sysconf_id', $syste->id)->where('ind_estado', 'aceptado');
    })->whereBetween('date_invoice', [$dateI, $dateF])->where('m_tax', $parameter, $tax)->sum($sum);
  }

  public function consultInvoicesSummaryRelationsCustomer($dateI, $dateF, $syste, $sum, $customer)
  {
    return ProductsByInvoice::whereHas('invoice', function ($i) use ($dateI, $dateF, $syste, $customer) {
      $i->whereHas('sale', function ($q) use ($customer) {
        $q->where('customer_id', $customer);
      })->where('invoice_type_id', 2)
        ->where('sysconf_id', $syste->id)->where('ind_estado', 'aceptado');
    })->whereBetween('date_invoice', [$dateI, $dateF])->sum($sum);
  }

  public function consultInvoicesSummaryWithWhere($dateI, $dateF, $syste, $sum, $columnOne, $dataOne, $columnTwo, $parameter, $dataTwo)
  {
    return ProductsByInvoice::whereHas('invoice', function ($i) use ($dateI, $dateF, $syste) {
      $i->where('invoice_type_id', 2)
        ->where('sysconf_id', $syste->id)->where('ind_estado', 'aceptado');
    })->whereBetween('date_invoice', [
      $dateI,
      $dateF
    ])->where($columnOne, $dataOne)->where($columnTwo, $parameter, $dataTwo)->sum($sum);
  }

  public function consultIdInvoiceSummaryWithWhere($dateI, $dateF, $sum, $invoicesIds, $columnOne, $dataOne, $columnTwo, $parameter, $dataTwo)
  {
    return ProductsByInvoice::whereBetween('date_invoice', [
      $dateI,
      $dateF
    ])->whereIn('invoice_id', $invoicesIds)->where($columnOne, $dataOne)->where($columnTwo, $parameter, $dataTwo)->sum($sum);
  }

  public function consultIdInvoiceSummaryOneWhere($dateI, $dateF, $sum, $invoicesIds, $columnTwo, $parameter, $dataTwo)
  {
    return ProductsByInvoice::whereBetween('date_invoice', [
      $dateI,
      $dateF
    ])->whereIn('invoice_id', $invoicesIds)->where($columnTwo, $parameter, $dataTwo)->sum($sum);
  }

  public function consultIdInvoiceSummary($dateI, $dateF, $sum, $invoicesIds)
  {
    return ProductsByInvoice::whereBetween('date_invoice', [
      $dateI,
      $dateF
    ])->whereIn('invoice_id', $invoicesIds)->sum($sum);
  }

  public function consultInvoicesSummaryWithTwoWhere($dateI, $dateF, $syste, $sum, $columnOne, $dataOne, $columnTwo, $parameter, $dataTwo, $columnThree, $parent, $dataThree)
  {
    return ProductsByInvoice::whereHas('invoice', function ($i) use ($dateI, $dateF, $syste) {
      $i->where('invoice_type_id', 2)
        ->where('sysconf_id', $syste->id)->where('ind_estado', 'aceptado');
    })->whereBetween('date_invoice', [
      $dateI,
      $dateF
    ])->where($columnOne, $dataOne)->where($columnTwo, $parameter, $dataTwo)->where($columnThree, $parent, $dataThree)->sum($sum);
  }

  /**
   * @param $data
   * @param $type
   * @param $activity
   * @param $sysconf
   * @return mixed
   * @Consult SELECT * FROM products_by_invoices
   * INNER JOIN invoices ON invoices.id = products_by_invoices.invoice_id
   * WHERE  products_by_invoices.type_activity_id =1160 AND invoice.date BETWEEN ['2020-10-01','2020-10-31'] AND
   * invoice_type_id = 2 AND ind_estado ='aceptado' AND sysconf_id=3
   */
  public static function consultInvoicesActivityRangeDate($data, $type, $activity, $sysconf)
  {
    Log::info(__METHOD__ . ' ' . $activity);
    return self::where('type_activity_id', $activity)->with('invoice.customer')
      ->whereHas('invoice', function ($invoice) use ($data, $type, $sysconf) {
        $invoice->whereBetween('date', $data)
          ->where('invoice_type_id', $type)
          ->where('ind_estado', 'aceptado')
          ->where('sysconf_id', $sysconf->id);
      })->get();
  }

  public static function consultInvoicesActivityRangeDateCreditNote($data, $type, $activity, $sysconf)
  {
    return self::where('type_activity_id', $activity)->with('invoice.customer')
      ->whereHas('invoice', function ($invoice) use ($data, $type, $sysconf) {
        $invoice->whereHas('creditNotes', function ($note) use ($data, $type, $sysconf) {
          $note->whereBetween('date', $data)
            ->where('code_status_hacienda', 'aceptado')
            ->where('sysconf_id', $sysconf->id);
        });
      })->get();
  }

  public static function consultInvoicesActivityIsNullRangeDateCreditNote($data, $type, $sysconf)
  {
    return self::whereNull('type_activity_id')->with('invoice.customer')
      ->whereHas('invoice', function ($invoice) use ($data, $type, $sysconf) {
        $invoice->whereHas('creditNotes', function ($note) use ($data, $type, $sysconf) {
          $note->whereBetween('date', $data)
            ->where('code_status_hacienda', 'aceptado')
            ->where('sysconf_id', $sysconf->id);
        });
      })->get();
  }

  public static function consultInvoicesNullActivityRangeDate($data, $type, $sysconf)
  {
    return self::whereNull('type_activity_id')->with('invoice.customer')->whereHas('invoice', function ($invoice) use ($data, $type, $sysconf) {
      $invoice->whereBetween('date', $data)
        ->where('invoice_type_id', $type)
        ->where('ind_estado', 'aceptado')
        ->where('sysconf_id', $sysconf->id);
    })->get();
  }

  public static function consultInvoicesIvasRangeDate($invoice, $iva, $sum)
  {
    return self::with('invoice.customer')->where('invoice_id', $invoice)->where('rate', $iva)->sum($sum);
  }

  public static function consultInvoicesActivityIvasRangeDate( $invoices, $activity, $var, $iva, $sum)
  {
   $summary =  self::with('invoice.customer')->whereIn('invoice_id', $invoices)
       ->where('type_activity_id', $activity)->where('rate', $var, $iva)->sum($sum);

    return $summary;
  }

  public static function consultInvoicesVarIvasRangeDate($invoice, $var, $iva, $sum)
  {
    return self::with('invoice.customer')->where('invoice_id', $invoice)->where('rate', $var, $iva)->sum($sum);
  }

  public static function idNullActivityRangeDate($id)
  {
    return self::where('id', $id);
  }


  public function relationshipInvoiceByDateWithOneWhereSum($sysconf, $date, $columnOne, $dataOne, $sum)
  {
    return self::whereHas('invoice', function ($invoice) use ($date, $sysconf) {
      $invoice->where('invoice_type_id', 2)->where('sysconf_id', $sysconf->id)->where('ind_estado', 'aceptado');
    })->where('date_invoice', $date)->where($columnOne, $dataOne)->sum($sum);
  }


  public function relationshipInvoiceByDateWithThreeWhereSum($sysconf, $date, $columnOne, $dataOne, $columnTwo, $dataTwo, $columnThree, $dataThree, $sum)
  {
    return self::whereHas('invoice', function ($invoice) use ($date, $sysconf) {
      $invoice->where('invoice_type_id', 2)->where('sysconf_id', $sysconf->id)->where('ind_estado', 'aceptado');
    })->where('date_invoice', $date)->where($columnOne, $dataOne)->where($columnTwo, $dataTwo)->where($columnThree, $dataThree)->sum($sum);
  }

  public function relationshipInvoiceByDateWithTwoWhereOneWhereDifSum($sysconf, $date, $columnOne, $dataOne, $columnTwo, $dataTwo, $columnThree, $parameter, $dataThree, $sum)
  {
    return self::whereHas('invoice', function ($invoice) use ($date, $sysconf) {
      $invoice->where('invoice_type_id', 2)->where('sysconf_id', $sysconf->id)->where('ind_estado', 'aceptado');
    })->where('date_invoice', $date)->where($columnOne, $dataOne)->where($columnTwo, $dataTwo)->where($columnThree, $parameter, $dataThree)->sum($sum);
  }

  public function relationshipInvoiceRelationCustomerByDateSum($sysconf, $date, $sum, $customer)
  {
    return self::whereHas('invoice', function ($invoice) use ($date, $sysconf, $customer) {
      $invoice->where('invoice_type_id', 2)->where('sysconf_id', $sysconf->id)->where('ind_estado', 'aceptado')
        ->whereHas('sale', function ($sale) use ($customer) {
          $sale->where('customer_id', $customer);
        });
    })->where('date_invoice', $date)->sum($sum);
  }

  public function relationshipInvoiceRelationCustomerByTwoDateSum($sysconf, $date, $sum, $customer, $column, $parameter, $data, $columnTwo, $dataTwo)
  {
    return self::whereHas('invoice', function ($invoice) use ($date, $sysconf, $customer) {
      $invoice->where('sysconf_id', $sysconf->id)->where('ind_estado', 'aceptado')
        ->whereHas('sale', function ($sale) use ($customer) {
          $sale->where('customer_id', $customer);
        });
    })->where('date_invoice', $date)->where($column, $parameter, $data)->where($columnTwo, $dataTwo)->sum($sum);
  }

  public function relationCustomerInInvoicesSum($invoices, $sum, $column, $parameter, $data, $columnTwo, $dataTwo)
  {
    return self::where('invoice_id', $invoices)->where($column, $parameter, $data)->where($columnTwo, $dataTwo)->sum($sum);
  }

  public function relationSubtotalCustomerInInvoicesSum($invoices, $sum)
  {
    return self::where('invoice_id', $invoices)->sum($sum);
  }

  public static function searchTopSales($dateRange, $order, $top, $data = '')
  {
    return  DB::table('products_by_invoices')->select('products.id AS id', 'products.description AS descripcion', 'products.url_img', 'products.sale_price', DB::raw("SUM(amount) AS total"))
      ->join('products', 'products.id', '=', 'products_by_invoices.product_id')->havingRaw("SUM(amount) > 1")
      ->join('invoices', 'invoices.id', '=', 'products_by_invoices.invoice_id')
      ->where('invoices.invoice_type_id', 2)->where('family','LIKE',"%$data%")->where('invoices.ind_estado', 'aceptado')
      ->whereBetween('invoices.date', $dateRange)->where('invoices.sysconf_id', \sysconf()->id)
      ->where('products_by_invoices.type', 'sale')->groupBy('product_id')
      ->orderBy('total', $order)->paginate($top);
  }
}
