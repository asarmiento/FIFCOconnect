<?php
/**
 * Created by PhpStorm.
 * User: Anwar
 * Date: 26/09/2017
 * Time: 11:59 AM
 */

namespace App\Entities\Products;


use App\Entities\Config\User;
use App\Entities\Entity;

/**
 * @property \Carbon\Carbon $created_at
 * @property int $id
 * @property \Carbon\Carbon $updated_at
 */
class InventoryByUser extends Entity
{


    protected $hidden = array('created_at','updated_at','user_id');
    protected $fillable = array('user_id', 'amount','initial','amount_dist','product_id');
    protected $guarded = array('id');

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

}