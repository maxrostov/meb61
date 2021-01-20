<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $guarded = ['id','save_and_copy_button','save_and_mod_button','save_and_clone_button','category_ids'];

    protected $casts = [
        'photos' => 'array',
    ];

//https://laravel-news.com/6-eloquent-secrets
    protected $appends = ['public_price'];

//    public function getInfoAttribute($value)
//    {
//        return   str_replace("\n\n","\n",str_replace("\r",'',$value));
//    }



    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    public function tvalues()
    {
        return $this->belongsToMany('App\Tvalues');
    }

    public function color()
    {
        return $this->belongsTo('App\Color', 'color_id');
    }
    public function status()
    {
        return $this->belongsTo('App\Status', 'status_id');
    }
    public function material_body()
    {
        return $this->belongsTo('App\Material', 'material_body_id');
    }
    public function material_face()
    {
        return $this->belongsTo('App\Material', 'material_face_id');
    }
    public function factory()
    {
        return $this->belongsTo('App\Factory', 'factory_id');
    }
    public function parent()
    {
        return $this->belongsTo('App\Product', 'parent_id');
    }



    public function children()
    {
        return $this->hasMany('App\Product', 'parent_id');
    }

    public function mod_siblings()
    {
        return $this->hasMany('App\Product', 'parent_id','parent_id');
    }

    public function modules()
    {
        return $this->belongsToMany('App\Product','collection_product','collection_id','product_id');
    }

    public function parent_collections()
    {
        return $this->belongsToMany('App\Product','collection_product','product_id','collection_id');//->keyBy('collection_id');
    }

    public function getPublicPriceAttribute()
    {
        $factory = Factory::find($this->factory_id);
$margin = $factory->margin ?? 1;
        $price =  round(ceil($this->price*$margin),-1);

return $price;
    }


}
