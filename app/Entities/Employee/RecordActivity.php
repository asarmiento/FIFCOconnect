<?php
  /**
   * Created by PhpStorm.
   * User: Anwar
   * Date: 13/1/2019
   * Time: 02:50:PM
   */
  
  namespace App\Entities\Employee;
  
  
  use App\Entities\Entity;
  use App\Http\Traits\Web\DataViewerTraits;

  class RecordActivity extends Entity
  {
    use DataViewerTraits;
    protected $table ='record_activities';
  
  
    public function activity()
    {
      return $this->belongsTo(Activity::class);
    }
  
    public function employee()
    {
      return $this->belongsTo(Employee::class);
    }
  
    public function scopeSearch($query, $search)
    {
      try
      {
       
          $query->whereHas("customer", function ($r) use ($search)
          {
            $r->where('name', "LIKE", "%$search%")
              ->orWhere("fantasy_name", "LIKE", "%$search%")
              ->orWhere("company_name", "LIKE", "%$search%");
          /**/
        });
      } catch (\Exception $e)
      {
        \Log::info($e->getMessage() . ' ' . $e->getLine());
      }
    
    }
  }
