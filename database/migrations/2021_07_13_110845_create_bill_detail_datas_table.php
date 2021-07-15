<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillDetailDatasTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('bill_detail_datas', function (Blueprint $table) {
      $table->uuid('id')->unique()->index();
      $table->uuid('bill_data_id')->comment('ref bill data');
      $table->uuid('product_data_id')->comment('ref product data');
      $table->integer('product_total')->comment('จำนวนซื้อทั้งหมด');
      $table->decimal('product_price')->comment('ราคาขายต่อชิ้น');
      $table->decimal('total', 10, 2)->comment('ราคารวม');
      $table->decimal('discount', 10, 2)->nullable()->comment('สวนลด');
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
    Schema::dropIfExists('bill_detail_datas');
  }
}
