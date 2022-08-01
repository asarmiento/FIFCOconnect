<?php


  namespace App\Entities\Boxes;


  use App\Entities\General\User;
  use App\Entities\Entity;

  class CashDesk extends Entity
  {
    protected $table = 'cash_desks';

    protected $fillable = [ 'sysconf_id', 'branch_office_id', 'name',  'employee_id', 'user_id'];

    public static function listsLabel()
    {
      $suppliers = self::where('sysconf_id',sysconf()->id)->with('user')->get();

      $lists = [];
      foreach ($suppliers AS $supplier)
      {
        if (count($supplier->user) > 0)
        {
          array_push($lists, [
            'label' =>
              $supplier->name . ' || ' . $supplier->user[0]->username,
            'value' => $supplier->id
          ]);
        }
      }

      return $lists;
    }

    public function user()
    {
      return $this->belongsToMany(User::class, 'user_by_cash_desks');
    }
  }
