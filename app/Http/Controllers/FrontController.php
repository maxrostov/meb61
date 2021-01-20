<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Category;
use App\Factory;
use App\Product;
use App\Text;
use App\Type;
use App\Search;

use App\Error;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class FrontController extends Controller
{



    public function homepage(Request $request)
    {

//        Log::info('Log message', ['context' => 'Other helpful information']);

        $promo1 = Category::find(426);
        $promo1_products = $promo1->products()->get();
        $promo1_label = $promo1->category;

        $promo2 = Category::find(427);
        $promo2_products = $promo2->products()->get();
        $promo2_label = $promo2->category;

        $slides = Banner::all();

        return view('homepage' ,compact('slides','promo1_label','promo2_label','promo1_products','promo2_products')
        );
    }


    public function test(Request $request)
    {
        return view('test');
    }

    public function category(Request $request, $category_id)
    {
        $category = Category::findOrFail($category_id);
        $subcat_ids = $category->subchildren->pluck('id')->toArray();

//        $products = $category->products->where('parent_id', NULL)->orderBy('name');

        $products_query = Product::
        where('parent_id', NULL)->
//        where('is_hidden', NULL)->
        where('status_id',2); // только проверено

        if ($category_id<>153) { // в модульных кухнях не выводим из подраздела товары, т.е. модули (их слишком много)
            $products_query=$products_query->whereHas('categories', function ($query) use ($category_id,$subcat_ids) {
                $query->where('category_id', $category_id)
                    ->orWhereIn('category_id',$subcat_ids);
            });
        } else {

            $products_query=$products_query->whereHas('categories', function ($query) use ($category_id) {
                $query->where('category_id', $category_id);
            });
        }


        $factories_ids = [];
        foreach ($products_query->get() as $product){
            $factories_ids[$product->factory_id]  = $product->factory_id;
        }
        $factories = Factory::find($factories_ids)->sortBy('factory');


        $products = $products_query->
        when($request->factory_id, function ($query, $factory_id) {
            return $query->where('factory_id',$factory_id);
        })
            ->when($request->dim_width_from, function ($query, $val) {
                return $query->where('width','>=',$val);
            })
            ->when($request->dim_width_to, function ($query, $val) {
                return $query->where('width','<=',$val);
            })
            ->when($request->dim_height_from, function ($query, $val) {
                return $query->where('height','>=',$val);
            })
            ->when($request->dim_height_to, function ($query, $val) {
                return $query->where('height','<=',$val);
            })
            ->when($request->dim_depth_from, function ($query, $val) {
                return $query->where('depth','>=',$val);
            })
            ->when($request->dim_depth_to, function ($query, $val) {
                return $query->where('depth','<=',$val);
            })
            ->orderBy('price')->paginate($request->pagination ?? 32);

//        dump(DB::getQueryLog());

        $html_title = $category->category . '  купить в Ростове';



        return view('category',compact('html_title','products','category','factories'));
    }


    public function main_category(Request $request, $category_id)
    {
        $main_category = Category::findOrFail($category_id);
        $categories = Category::where('parent_id',$category_id)->get();


     if ($category_id==11){
         $categories = Category::where('parent_id',$category_id)
             ->whereNotIn('id',[398,429,373,156,157])  // отключаем в разделе КУХНИ модули для кузни, а то их там 3000 штук и они замусоривают список
             ->whereNotIn('subparent_id',[398,429,373,156,157]) // тоже самое
             ->get();
     }

        $subcat_ids = [];
        foreach ($categories as $cat){
            $subcat_ids[]=$cat->id;
            $subcat_ids = $subcat_ids + $cat->subchildren->pluck('id')->toArray();
        }
//        dd($subcat_ids);

        $products_query = Product::
        where('parent_id', NULL)->
        where('status_id',2)-> // только проверено
        whereHas('categories', function ($query) use ($category_id,$subcat_ids) {
            $query->WhereIn('category_id',$subcat_ids);
        }); //->

        $factories_ids = [];
        foreach ($products_query->get() as $product){
            $factories_ids[$product->factory_id]  = $product->factory_id;
        }
        $factories = Factory::find($factories_ids)->sortBy('factory');


        $products = $products_query->
             when($request->factory_id, function ($query, $factory_id) {
                 return $query->where('factory_id',$factory_id);
             })
            ->when($request->dim_width_from, function ($query, $val) {
                return $query->where('width','>=',$val);
            })
            ->when($request->dim_width_to, function ($query, $val) {
                return $query->where('width','<=',$val);
            })
            ->when($request->dim_height_from, function ($query, $val) {
                return $query->where('height','>=',$val);
            })
            ->when($request->dim_height_to, function ($query, $val) {
                return $query->where('height','<=',$val);
            })
            ->when($request->dim_depth_from, function ($query, $val) {
                return $query->where('depth','>=',$val);
            })
            ->when($request->dim_depth_to, function ($query, $val) {
                return $query->where('depth','<=',$val);
            })

            ->orderBy('price')->paginate($request->pagination ?? 32);
        $html_title = $main_category->category . '  купить в Ростове';

        return view('main_category',compact('main_category','html_title','categories','products','factories'));
    }

    public function product(Request $request, $product_id)
    {
        $product = Product::with(['tvalues','factory','color','material_body','material_face'])->
        findOrFail($product_id);

        if ($product->status_id>2)  return view('product_not_found');

        // для возврата в список.
        // если в урле явно не передан номер раздела, то берем первый у самого товара

                if (isset($request->c)){
         $category_id = $request->c;
     }
      elseif(isset($product->categories[0])){
          $category_id =  $product->categories[0]->id;
      }

            if (isset($category_id))   {
             $category = Category::find($category_id);

         }   else {
             $category = null;
         }


        $types = Type::all()->pluck('type','id');

//dd($types);
        // если уже в корзине есть этот товар
        $cart_items = session('cart.items');
        $is_in_cart = isset($cart_items[$product_id]) ? true : false;
        $html_title = $product->name . '  купить в Ростове';

        $view_values = compact('product','html_title','category','is_in_cart','types');

        // если коллекция, то это имеет приоритет
        if ($product->is_collection){

//    foreach ($product->children_collection as $child) { // old my structure
            foreach ($product->modules as $child) { // myxmebel
$prod = Product::with(['tvalues','tvalues','factory','material_body','material_face'])->
find($child->id);

                $modules_json[$child->id] = $prod->toArray();
//                $modules_json[$child->id]['public_price'] = $prod->public_price;
                $modules_json[$child->id]['selected'] = 0; //  hack 4 vue.js
            }
            $view_values['modules_json'] = $modules_json ?? [];


            return view('product_collection_vue',$view_values);
        }

        // если есть модификации, выводим шаблон с VueJS, иначе -- просто обычный шаблон.
    elseif  ($product->children->count()){
  foreach ($product->children as $child) {
      $prod =Product::with(['tvalues','factory','color','material_body','material_face'])->
      find($child->id);
      $mods_json[$child->id] = $prod->toArray();
//      $mods_json[$child->id]['public_price'] = $prod->public_price;

  }

    $main_json[$product->id] = $product->toArray();
//        $main_json[$product->id]['public_price'] = $product->public_price;
    $family_json =$main_json + $mods_json;

    $view_values['family_json'] = $family_json;
    return view('product_mods_vue',$view_values);
}




else{
    return view('product',$view_values);
}
    }




    public function text($text_id)
    {
    $text = Text::findOrFail($text_id);
        return view('text',compact('text'));
    }

    private function kitchen_modules_ids(){

        $category_id=398;//Модули для кухни

        $category = Category::findOrFail($category_id);
        $subcat_ids = $category->subchildren->pluck('id')->toArray();

         $products_ids = Product::whereHas('categories', function ($query) use ($category_id,$subcat_ids) {
                $query->where('category_id', $category_id)
                    ->orWhereIn('category_id',$subcat_ids);
            })->pluck('id')->toArray();

         return $products_ids;

          }

    public function search(Request $request)
    {
        $search_string = strip_tags($request->search_str);
//dd($search_string);
        if(!$search_string) return view('search',['products'=>[]]);


        $ids_strict = Product::where('name','like', "%$search_string%");

        $search_string_for_regexp = str_replace('-',' ',$search_string); // чтобы и дефисы разбить на отдельные слова
        $reg_exp = implode('.+',explode(' ',$search_string_for_regexp));
        $reg_exp = mb_strtolower($reg_exp);
//        dd($reg_exp);
        $ids_regexp = Product::whereRaw("LOWER(name) REGEXP '$reg_exp'"); // LOWER - хак, т.к. mySQL для русских слов регистро-зависимая


        $ids_natural = Product::whereRaw("MATCH (name) AGAINST('$search_string' IN NATURAL LANGUAGE MODE)");


//         сортировка общая для обоих типов поиска
        if($request->order_by=='price_desc') {
            $ids_strict->orderBy('price', 'DESC');
            $ids_regexp->orderBy('price', 'DESC');
//            $ids_natural->orderBy('price', 'DESC');
        }
        else{
            $ids_strict->orderBy('price');
            $ids_regexp->orderBy('price');
//            $ids_natural->orderBy('price');
        }

        $ids_strict= $ids_strict->pluck('id')->toArray();
        $ids_regexp= $ids_regexp->pluck('id')->toArray();
        $ids_natural= $ids_natural->pluck('id')->toArray();

        $ids = $ids_strict+$ids_regexp+$ids_natural;

        $ids_str = implode(',',$ids);
if($ids_str){
    $query = Product::whereIn('id',$ids)->orderByRaw("FIELD (id, $ids_str)")
        ->where('parent_id', NULL)
        ->where('is_hidden', NULL)
        ->whereNotIn('id',$this->kitchen_modules_ids()) // исключаем из поиска 3000 модулей кухни
        ->where('status_id','<',3); // только ПРОВЕРЕНО и НЕ ПРОВЕРЕНО

    $all_ids_only = $query->pluck('id'); // для лога все айдишники с правильной сортировкой
//        dd($all_ids_only);

    // собственно запрос для вывода посетителю
    $products = $query->paginate($request->pagination ?? 32);

}
 else{
     $all_ids_only=0;
     $products=[];
 }


// пишем в лог
  $search_log = Search::create([
      'query' => $search_string,
      'found_ids' => $all_ids_only,
      'ip' => $_SERVER['REMOTE_ADDR'],
      'useragent' => $_SERVER['HTTP_USER_AGENT'],
  ]);


        return view('search',compact('products'));
    }

    public function search_old(Request $request)
    {
        $search_string = strip_tags($request->search_str);


        $query = Product::where('name','like', "%$search_string%");

        $count_found = $query->count();
        // если не нашли точным поиском, создаем query с перестановкой слов
       if ($count_found==0) {
           $query = Product::whereRaw("MATCH (name) AGAINST('$search_string' IN NATURAL LANGUAGE MODE)");
       }


// сортировка общая для обоих типов поиска
        if($request->order_by=='price_desc') {
            $query->orderBy('price', 'DESC');
        }
        else{
            $query->orderBy('price');
        }

// собственно запрос, с общими ограничениями и пагинацией
        $products = $query
            ->where('parent_id', NULL)
            ->where('is_hidden', NULL)
            ->where('status_id','<',3) // только ПРОВЕРЕНО и НЕ ПРОВЕРЕНО
            ->paginate($request->pagination ?? 32);


        return view('search',compact('products'));
    }


    public function search_log()
    {
        $searches = Search::orderBy('created_at', 'desc')->paginate(30);
        return view('adm.search_log', compact('searches'));
    }

    public function errors_log()
    {
        $errors = Error::orderBy('created_at', 'desc')->paginate(30);
        return view('adm.errors_log', compact('errors'));
    }

    public function sitemap_txt(){
        $str = '';
        $products = Product::select('id')->pluck('id')->toArray();
        foreach ($products as $id){
            $str.='https://mebel61.ru/mebel/'.$id."\n";
        }
        echo $str;


    }


}
