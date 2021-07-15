<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillDatasTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('bill_datas', function (Blueprint $table) {
      $table->uuid('id')->unique()->index();
      $table->uuid('customer_data_id')->nullable()->comment('เชื่อมไปยังลูกค้า ถ้าเข้ามาเป็น login');
      $table->uuid('admin_active_by')->nullable()->comment('ใครเป็นคนอนุมัติ');
      $table->uuid('status_data_id')->nullable()->comment('สถานะ');


      $table->integer('total_product')->nullable()->comment('จำนวนสิ้นค้าที่ซื้อทั้งหมด');
      $table->decimal('subtotal', 10, 2)->nullable()->comment('ยอดรวมยังไม่รวมภาษี');
      $table->decimal('total', 10, 2)->nullable()->comment('จำนวนเงินรวมภาษี');

      $table->boolean('active')->default(false)->comment('สถานะการชำระเงิน');
      $table->boolean('active_admin')->default(false)->comment('admin active');


      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('bill_datas');
  }
}
