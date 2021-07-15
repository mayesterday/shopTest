<?php

namespace App\Models;

use App\Traits\UseUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDatas extends Model
{
  use HasFactory, UseUuid;
  protected $table = 'product_datas';
  protected $casts = ['promote' => 'boolean'];
  protected $appends = ['promote_text'];
  protected $fillable = [
    'id',
    'code',
    'name',
    'detail',
    'detail_full',
    'price',
    'total', // จำนวน
    'total_sale', // จำนวนที่ขาย
    'total_click',
    'promote',
  ];


  public function imageDatas()
  {
    return $this->hasMany(ImageDatas::class, 'ref', 'id');
  }
  public function ProductCategoryDatas()
  {
    return $this->hasMany(ProductCategoryDatas::class, 'product_data_id', 'id');
  }

  public function getPromoteTextAttribute()
  {
    return $this->attributes['promote'] ? 'เปิด' : 'ปิด';
  }
}
