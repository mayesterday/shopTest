<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductDatasTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('product_datas', function (Blueprint $table) {
      $table->uuid('id')->unique()->index();
      $table->string('code')->nullable()->comment('รหัสสินค้า');
      $table->string('name')->comment('ชื่อสิ้นค้า');
      $table->longText('detail')->comment('รายละเอียด');
      $table->longText('detail_full')->comment('รายละเอียดแบบเต็ม');
      $table->decimal('price', 10, 2)->comment('ราคา');
      $table->integer('total')->nullable()->comment('จำนวนสินค้า');
      $table->integer('total_sale')->default(0)->comment('ยอดขายรวม');
      $table->integer('total_click')->default(0)->comment('จำนวนครั้งในการกด');
      $table->boolean('promote')->default(false)->comment('ให้แสดงสินค้าแนะนำ');

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
    Schema::dropIfExists('product_datas');
  }
}
