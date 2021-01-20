<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Type extends Model
{
    use SoftDeletes;
//    public $timestamps = false;
    protected $guarded = ['id'];


    public function tvalues()
    {
        return $this->hasMany('App\Tvalues', 'type_id');
    }


}
