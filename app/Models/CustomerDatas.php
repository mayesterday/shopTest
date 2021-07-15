<?php

namespace App\Models;

use App\Traits\UseUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerDatas extends Model
{
  use HasFactory, UseUuid;
  protected $table = 'customer_datas';
  protected $appends = ['full_name'];
  protected $fillable = [
    'id',
    'firstname',
    'lastname',
    'phone',
    'email',
    'address',
    'city',
    'state',
    'zip',
  ];


  public function getFullNameAttribute()
  {
    return $this->attributes['firstname'] . " " . $this->attributes['lastname'];
  }
}
