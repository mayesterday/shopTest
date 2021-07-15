<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * @param stringOrArray data  ข้อมูลที่ต้องการตอบกลับ
         * @param boolean       errors true แสดงว่ามี error ถ้า false ไม่มี error
         */
        Response::macro('api', function ($data = '', $errors = false, $message = '', $code = 200) {
            return Response::json([
                'data' => $data,
                'errors' => $errors,
                'message' => $message,
                'code' => $code,
            ], $code); // this method need to make http status code be changable.
        });
    }
}
