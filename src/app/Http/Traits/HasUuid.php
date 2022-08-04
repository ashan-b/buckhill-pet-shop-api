<?php


namespace App\Http\Traits;


use Illuminate\Support\Str;

trait  HasUuid
{
    public static function bootHasUuid()
    {
        self::creating(function ($model) {
            $model->uuid = Str::uuid()->toString();
        });
    }
}
