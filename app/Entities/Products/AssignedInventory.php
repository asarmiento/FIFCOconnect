<?php


namespace App\Entities\Products;


use App\Entities\General\User;
use App\Entities\Entity;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AssignedInventory extends Entity
{

    protected $table = 'assigned_inventories';
    protected $fillable =['user_id','product_id','amount','date','status','type','sysconf_id'];

    public function allDataAsc($column)
    {
        return parent::allDataAsc($column); // TODO: Change the autogenerated stub
    }

    public function scopeSearch($query,$search)
    {
        if(trim($search)!=''){
           return $query->where('sysconf_id', sysconf()->id)->where('date','LIKE',"%$search%")->orWhere('user_id','LIKE',"%$search%");
        }
}
    public static function newData($userId,$productId,$amount,$type)
    {
       return self::create([
            'user_id' => $userId, 'product_id' => $productId, 'sysconf_id' => Auth::user()->sysconf_id,
            'amount' => $amount, 'date' => Carbon::now()->toDateString(), 'status' => false, 'type' => $type
        ]);
    }
    public static function updateData($userId,$type)
    {
       return self::where('user_id', $userId)->where('type' ,$type)->update(['status'=>true]);

    }

    public static function consultDate($type)
    {
        return self::where('status',false)->where('type',$type)->orderBy('date','ASC')->first()->date;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
