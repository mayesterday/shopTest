<?php

namespace Database\Seeders;

use App\Models\CategoryDatas;
use App\Models\ImageDatas;
use App\Models\ProductCategoryDatas;
use App\Models\ProductDatas;
use App\Models\StatusDatas;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
  public $faker;
  public function __construct()
  {
    $this->faker = Factory::create();
    \Bezhanov\Faker\ProviderCollectionHelper::addAllProvidersTo($this->faker);
  }
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    $datasStatus = [
      ['name' => 'ยังไม่อัพหลักฐานการโอนเงิน'],
      ['name' => 'รอเจ้าหน้าที่ตรวจสอบการโอน'],
      ['name' => 'ชำระเงินสำเร็จ'],
    ];
    foreach ($datasStatus as $status) {
      StatusDatas::create($status);
    }
    User::create([
      'name' => 'admin',
      'email' => 'admin@demo.com',
      'password' => '123456',
      'name' => 'admin',
      'type' => 'admin'
    ]);
    DB::transaction(function () {
      for ($x = 0; $x <= 10; $x++) {
        $category_data_id = $this->createCategoryData();
        $this->createProductDatas($category_data_id);
      }
    });
  }

  /**
   * @return uuid
   */
  private function createCategoryData()
  {
    return CategoryDatas::create(['category_name' => $this->faker->category])->id;
  }
  private function createProductDatas($category_data_id)
  {


    for ($x = 0; $x <= 10; $x++) {
      $product_data_id = ProductDatas::create([
        'code' => $this->faker->randomNumber($nbDigits = NULL, $strict = false),
        'name' => $this->faker->word,
        'detail' => $this->faker->text,
        'price' => $this->faker->numberBetween($min = 0, $max = 1000),
        'detail_full' => $this->faker->text,
        'total_click' => $this->faker->numberBetween(1, 5000)
      ])->id;

      $ProductCategoryDatas = ProductCategoryDatas::create([
        'product_data_id' => $product_data_id,
        'category_data_id' => $category_data_id,
      ]);

      $this->createProductImage($product_data_id);
    }
  }

  private function createProductImage($product_data_id)
  {
    for ($x = 0; $x <= $this->faker->numberBetween(1, 5); $x++) {
      $imageName = $this->faker->image(public_path('images'), 400, 300, null, false);
      ImageDatas::create([
        'ref' => $product_data_id,
        'table' => 'product_datas',
        'filename' => $imageName
      ]);
      echo "create image => $imageName \n";
    }
  }
}
