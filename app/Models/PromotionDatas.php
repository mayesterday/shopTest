<?php

namespace App\Models;

use App\Traits\UseUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionDatas extends Model
{
  use HasFactory, UseUuid;
  protected $table = 'promotion_datas';
  protected $fillable = [
    'id', 'promotions', 'name'
  ];
}
