<?php

namespace App\Helper;

use App\Models\ImageDatas;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ImageDataHelper
{
  public function url(Request $request, array $imageDatas)
  {
    $getHttpHost = $request->getHttpHost();
    return collect($imageDatas)->map(function ($image) use ($getHttpHost) {
      $_return = $image;
      $_return['name'] = $image['filename'];
      $_return['filename'] = 'http://' . $getHttpHost . '/images/' . $image['filename'];
      return $_return;
    });
  }

  public function fileUpload($request_image, $ref, $table)
  {
    if (!$request_image) {
      return '';
    }
    ImageDatas::where('ref', $ref)->delete();
    $images = $request_image;
    foreach ($images as $img) {
      $urlResized = $img['urlResized'];
      $base64_str = substr($urlResized, strpos($urlResized, ",") + 1);
      $image = base64_decode($base64_str);
      $safeName = Str::random(20) . '.png';
      file_put_contents(public_path('images/') . $safeName, $image);
      ImageDatas::create([
        'ref' => $ref,
        'table' => $table,
        'filename' => $safeName
      ]);
    }
  }
}
