<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Tvalues extends Model
{
    use SoftDeletes;
//    public $timestamps = false;
    protected $guarded = ['id'];




    public function type()
    {
        return $this->belongsTo('App\Type', 'type_id');
    }

}
