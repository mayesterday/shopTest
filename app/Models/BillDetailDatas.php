<?php

namespace App\Models;

use App\Traits\UseUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillDetailDatas extends Model
{
  use HasFactory, UseUuid;
  protected $table = 'bill_detail_datas';
  protected $fillable = [
    'id',
    'bill_data_id',
    'product_data_id',
    'product_total',
    'product_price',
    'total',
    'discount',
  ];

  public function productData()
  {
    return $this->belongsTo(ProductDatas::class, 'product_data_id', 'id');
  }
}
