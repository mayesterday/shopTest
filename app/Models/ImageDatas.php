<?php

namespace App\Models;

use App\Traits\UseUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageDatas extends Model
{
  use HasFactory, UseUuid;
  public $timestamps = false;
  protected $table = 'image_datas';
  protected $fillable = [
    'id',
    'ref',
    'table',
    'filename',
  ];
}
