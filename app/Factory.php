<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Factory extends Model
{
    use SoftDeletes;
    protected $fillable = ['factory','margin'];



    public function collections()
    {
        return $this->hasMany('App\Product', 'factory_id')
            ->where('is_collection',1);
    }


}
