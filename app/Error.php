<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Error extends Model
{

    protected $dates = ['deleted_at'];
    protected $table = 'logs';



}
