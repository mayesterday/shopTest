<?php

namespace App\Models;

use App\Traits\UseUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusDatas extends Model
{
  use HasFactory, UseUuid;
  protected $table = 'status_datas';
  public $timestamps = false;
  protected $fillable = [
    'id',
    'name',
  ];
}
