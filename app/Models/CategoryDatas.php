<?php

namespace App\Models;

use App\Traits\UseUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryDatas extends Model
{
  use HasFactory, UseUuid;
  protected $table = 'category_datas';
  protected $fillable = ['id', 'category_name', 'promote', 'count_click'];
  protected $casts = ['promote' => 'boolean',];


  public function ProductCategoryDatas()
  {
    return $this->hasMany(ProductCategoryDatas::class, 'category_data_id', 'id');
  }
}
