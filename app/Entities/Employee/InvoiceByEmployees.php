<?php
/**
 * Created by PhpStorm.
 * User: Anwar
 * Date: 26/09/2017
 * Time: 12:06 PM
 */

namespace App\Entities\Employee;


use App\Entities\Entity;
use App\Entities\Invoices\Invoice;

/**
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $id
 * @property mixed $employee
 * @property mixed $invoice
 */
class InvoiceByEmployees extends Entity
{
    protected $hidden = array('created_at','updated_at');
    protected $fillable = array('employee_id', 'invoice_id', 'status','reference');

    /**
     * -----------------------------------------------------------------------
     * @Author: Anwar Sarmiento <asarmiento@sistemasamigableslatam.com>
     * @DateCreate: 2017-09-26
     * @TimeCreate: 12:36pm
     * @DateUpdate: 0000-00-00
     * -----------------------------------------------------------------------
     * @description: Relación con la tabla empleados
     * @pasos:
     * ----------------------------------------------------------------------
     *
     *  * @var ${TYPE_NAME}
     * * ----------------------------------------------------------------------
     *  * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * ----------------------------------------------------------------------
     * *
     */
    public function employee(){
        return $this->belongsTo(Employee::class);
    }

    /**
     * -----------------------------------------------------------------------
     * @Author: Anwar Sarmiento <asarmiento@sistemasamigableslatam.com>
     * @DateCreate: 2017-09-26
     * @TimeCreate: 12:36pm
     * @DateUpdate: 0000-00-00
     * -----------------------------------------------------------------------
     * @description: Relación con la tabla de facturas
     * @pasos:
     * ----------------------------------------------------------------------
     *
     *  * @var ${TYPE_NAME}
     * * ----------------------------------------------------------------------
     *  * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * ----------------------------------------------------------------------
     * *
     */
    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }
}
