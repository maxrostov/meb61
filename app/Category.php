<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;


class Category extends Model
{
//    public $timestamps = false;
//    use SoftDeletes;
//    protected $dates = ['deleted_at'];
    protected  $guarded =['id'];
//    protected $fillable = ['category','shortname','parent_id','artikul','url','photo',
//        'print_pic','seotext','meta_title','meta_description','meta_keywords'];


    public function parent()
    {
        return $this->belongsTo('App\Category', 'parent_id');
    }
    public function subparent()
    {
        return $this->belongsTo('App\Category', 'subparent_id');
    }

    public function children()
    {
        return $this->hasMany('App\Category', 'parent_id');
    }
    public function subchildren()
    {
        return $this->hasMany('App\Category', 'subparent_id');
    }

    public function products()
    {
        return $this->belongsToMany('App\Product');
    }


    public static function for_select(){
        foreach (self::where('parent_id', 0)->orderBy('category')->get() as $cat) {
            $categories[$cat->category] =
                self::where('parent_id', $cat->id)->orderBy('category')->pluck('category', 'id')->toArray();
        }
        return $categories;
    }


// old 2-level
//    public static  function with_count()
//    {
//        $top_cat = self::whereParentId(0)->orderBy('category')->get();
//        $top_cat->each(function ($item, $key) {
//            $item['subcat'] = self::whereParentId($item->id)->orderBy('category')->get();
//        });
//        return $top_cat;
//    }
public static function product_count()
{

    $arr = DB::table('category_product')
        ->select('category_id')
        ->selectRaw('count(*) cnt')
        ->groupBy('category_id')->pluck('cnt','category_id');
    return $arr;
}

// new 3-level
    public static function with_count()
    {
        $top_cat = self::whereParentId(0)
//            ->with('children')
            ->orderBy('category')->get();

        $top_cat->each(function ($item, $key) {
            $item['subcat'] = self::whereParentId($item->id)->orderBy('category')->get();


        });
        return $top_cat;
    }

}
