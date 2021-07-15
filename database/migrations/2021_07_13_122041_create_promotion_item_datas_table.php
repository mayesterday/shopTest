<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionItemDatasTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('promotion_item_datas', function (Blueprint $table) {
      $table->uuid('id')->unique()->index();
      $table->uuid('promotion_data_id')->comments('ref promotion datas');
      $table->uuid('ref')->nullable();
      $table->string('table')->nullable();
      $table->decimal('old_price', 10, 2)->nullable();
      $table->decimal('discount', 10, 2);
      $table->enum('discount_type', ['percent', 'baht']);
      $table->decimal('new_price', 10, 2)->nullable();
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
    Schema::dropIfExists('promotion_item_datas');
  }
}
