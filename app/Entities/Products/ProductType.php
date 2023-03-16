<?php
/**
 * Created by PhpStorm.
 * User: Anwar
 * Date: 13/09/2017
 * Time: 12:16 AM
 */

namespace App\Entities\Products;


use App\Entities\Entity;

class ProductType extends Entity
{
    protected $fillable = array('name');

    protected $guarded = array('id');

    /**
     * -----------------------------------------------------------------------
     * @Author: Anwar Sarmiento <asarmiento@sistemasamigableslatam.com>
     * @DateCreate: 2017-09-13
     * @TimeCreate: 12:17am
     * @DateUpdate: 0000-00-00
     * -----------------------------------------------------------------------
     * @description:
     * @pasos:
     * ----------------------------------------------------------------------
     *
     *  * @var ${TYPE_NAME}
     * * ----------------------------------------------------------------------
     *  * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * ----------------------------------------------------------------------
     * *
     */
    public function product()
    {
        return $this->hasMany(Product::class);
    }
	
	
	
	public static function listsLabel()
	{
		$typeProducts = ProductType::all();
		$lists =[];
		foreach ($typeProducts AS $typeProduct){
			array_push($lists,['label'=>$typeProduct->name,'value'=>$typeProduct->id]);
		}
		
		return $lists;
	}
}
