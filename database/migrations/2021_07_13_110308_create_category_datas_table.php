<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryDatasTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('category_datas', function (Blueprint $table) {
      $table->uuid('id')->unique()->index();
      $table->string('category_name')->comments('ชื่อประเภทสิ้นค้า');
      $table->boolean('promote')->default(false)->comment('จัดการรายการแนะนำ');
      $table->integer('count_click')->default(0)->comment('จำนวนครั้งในการกด');

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
    Schema::dropIfExists('category_datas');
  }
}
