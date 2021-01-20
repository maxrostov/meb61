<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Search extends Model
{

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = ['query','ip','useragent','found_ids'];

     protected $casts = [
        'found_ids' => 'array',
//         'created_at' => 'datetime:d/m',
    ];

    //https://stackoverflow.com/questions/38241424/laravel-5-model-cats-to-array-utf-8-json-unescaped-unicode
    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }


}
