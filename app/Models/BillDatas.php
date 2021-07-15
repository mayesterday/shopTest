<?php

namespace App\Models;

use App\Traits\UseUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillDatas extends Model
{
  use HasFactory, UseUuid;
  protected $table = 'bill_datas';
  protected $fillable = [
    'id',
    'customer_data_id',
    'admin_active_by',
    'status_data_id',
    'total_product',
    'subtotal',
    'total',
    'active',
    'active_admin',
  ];

  public function customerData()
  {
    return $this->belongsTo(CustomerDatas::class, 'customer_data_id', 'id');
  }
  public function statusData()
  {
    return $this->belongsTo(StatusDatas::class, 'status_data_id', 'id');
  }

  public function imageDatas()
  {
    return $this->hasMany(ImageDatas::class, 'ref', 'id');
  }
  public function billDetailDatas()
  {
    return $this->hasMany(BillDetailDatas::class, 'bill_data_id', 'id');
  }
}
