<?php

namespace App\Traits;

use App\Helper\SessionsHelper;
use Illuminate\Support\Str;

use function PHPUnit\Framework\isEmpty;

trait UseUuid
{
    protected static function bootUseUuid()
    {
        static::creating(function ($model) {
            if (empty($model->getKey())) {
                $model->{$model->getKeyName()} = Str::upper((string) Str::uuid());
            }
        });
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
}
