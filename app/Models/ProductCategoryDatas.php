<?php

namespace App\Models;

use App\Traits\UseUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategoryDatas extends Model
{
  use HasFactory, UseUuid;
  protected $table = 'product_category_datas';
  protected $fillable = ['product_data_id', 'category_data_id'];
  public $timestamps = false;



  public function categoryData()
  {
    return $this->belongsTo(CategoryDatas::class, 'category_data_id', 'id');
  }
  public function productData()
  {
    return $this->belongsTo(ProductDatas::class, 'product_data_id', 'id');
  }
}
