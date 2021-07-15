<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupProductSetDatasTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('group_product_set_datas', function (Blueprint $table) {
      $table->uuid('id')->unique()->index();
      $table->uuid('group_product_data_id');
      $table->uuid('ref');
      $table->string('table');
      $table->decimal('price', 10, 2)->nullable()->comment('ราคาขายต่อ set');
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
    Schema::dropIfExists('group_product_set_datas');
  }
}
