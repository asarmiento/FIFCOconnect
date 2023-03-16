<?php
/**
 * Created by PhpStorm.
 * User: Anwar
 * Date: 07/09/2017
 * Time: 01:13 PM
 */

namespace App\Entities;


use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
  const STATUS_INACTIVE = 0;
  const STATUS_ACTIVE = 1;
  const STATUS_REFUSE = 2;
  const VD = 'Venta Directa';
  const DIST = 'Distribución';

  protected $status = self::STATUS_ACTIVE;

  public function createData($data)
  {
    return self::create($data);
  }

  public function isExist($datas,$unique=[])
  {
    $results = [];
    foreach ($datas as $key => $data) {
      if (in_array ($key, $unique)) {
        if ($this->where($key, $data)->count() > 0) {
          array_push($results, [$key => $data, 'status' => $this->where($key, $data)->count()]);
          $results['error'] = true;
        }
      }

    }

    return $results;
  }

  public function findData($id)
  {
    return self::find($id);
  }

  public function allDataAsc($column)
  {
    return $this->orderBy($column,'ASC')->get();
  }
  public function allWithDataAsc($with,$column)
  {
    return $this->with($with)->orderBy($column,'ASC')->get();
  }

  public function whereOne($column,$data)
  {
    return $this->where($column,$data)->get();
  }

  public function whereTwo($column,$data,$columnTwo, $dataTwo)
  {
    return $this->where($column,$data)->where($columnTwo, $dataTwo)->get();
  }
}
