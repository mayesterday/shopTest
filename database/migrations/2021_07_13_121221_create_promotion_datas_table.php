<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionDatasTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('promotion_datas', function (Blueprint $table) {
      $table->uuid('id')->unique()->index();
      $table->uuid('status_data_id')->comments('เก็บสถานะการเปิดใช้งาน');
      $table->integer('count_product')->nullable()->comments('จำนวนสินค้าที่จัด pro');
      $table->decimal('total', 10, 2)->default(0)->comments('เก็บยอดขายทั้งหมดของ promotion นี้');
      $table->string('name')->comments('promotion name');
      $table->text('promotions')->comments('promotion name');
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
    Schema::dropIfExists('promotion_datas');
  }
}
