<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\Struktura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Psy\Util\Str;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('adm/category');
    }


    public function myxmebel()
    {
     $categories = Struktura::where('parent_id','>',0)->get();

     foreach ($categories as $cat){
         $parent = Struktura::find($cat->parent_id);

         if ($parent->parent_id>0) {
             echo "$cat->id - $cat->parent_id <br>";
             $cat->subparent_id = $cat->parent_id;
             $cat->parent_id = $parent->parent_id;
             $cat->save();

         }
     }
    }
    public function feed(){

//        https://stackoverflow.com/questions/2517947/ucfirst-function-for-multibyte-character-encodings
        function mb_ucfirst(string $str, string $encoding = null): string
        {
            if ($encoding === null) {
                $encoding = mb_internal_encoding();
            }
            return mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding) . mb_substr($str, 1, null, $encoding);
        }


         $url='https://mebel61.storeland.ru/export/yandex_market/28426';
//         $url='xml.xml';
    $xml = file_get_contents($url);

        $items = new \SimpleXMLElement($xml);
        $offers = $items->shop->offers->offer;
        $i=1;
        echo '<pre>';
        foreach ($offers as $item){
//            print_r($item);
            $pic = $item->picture;

            $description = $item->description->__toString();
            $description = str_replace('&nbsp;',' ',$description);
            $description = str_replace('&mdash;','-',$description);
            $description = str_replace('&dash;','-',$description);
            $description = str_replace('&ndash;','-',$description);
            $description = str_replace('<br>',"\n",$description);

            $description = str_replace('&laquo;','"',$description);
            $description = str_replace('&laquo;','"',$description);
            $description = str_replace('&quot;','"',$description);
            $description = str_replace('&rsquo;','"',$description);
            $description = str_replace('&hellip;','...',$description);
            $description = str_replace('&times;','x',$description);

            $description = preg_replace("/\s{3,10}+/", " ", $description);
            $description =  trim(strip_tags($description));

            $description = str_replace('&times;','x',$description);


            $name = (string) $item->name;
            $name = str_replace('&laquo;','"',$name);
            $name = str_replace('&laquo;','"',$name);
            $name = str_replace('&quot;','"',$name);
            $name = str_replace('&rsquo;','"',$name);


//           if($i==61) die('====');
            $i++;
            echo $pic ."\n";
            $path =    parse_url($pic, PHP_URL_PATH);
            $explode_arr = explode('/',$path);
            $filename =  end($explode_arr);

           $is_found_factory =  preg_match('/\((\w+)\)$/u', $name, $found);
//            echo $name ;
           if ($is_found_factory){
             $factory_name =  mb_ucfirst(mb_strtolower($found[1]));
              $factory = DB::table('factories')->where('factory', '=', $factory_name)->pluck('id');
              $factory_id = $factory[0] ?? 59;
           } else {
               $factory_id =  59; // unknown factory
           }


            $is_found_mod =  preg_match('/^Модификация:/u', $name, $found);
            echo $name;
            echo "\n";
            if ($is_found_mod){
             echo $name  =   preg_replace('/^Модификация:.+?\.(.+)/u', '$1', $name);
                $parent_id = DB::table('products')->where('name', '=', $name)->pluck('id');
                   }
            $parent_id = $parent_id[0] ?? NULL;

            $category_id = Category::where('storeland_id', $item->categoryId)->value('id');

//            $product = new Product;
//            $product->info= $description;
//            $product->name = trim($name);
//            $product->parent_id = $parent_id;
//            $product->factory_id = $factory_id;
//            $product->price = (string) $item->price;
//            $product->photos = [$filename];
//            $product->save();
//
//            $product->categories()->attach(58);
//            if($category_id) $product->categories()->attach($category_id);

//            $product->id;
          echo "\n========\n";
//echo "\n";

        }
    }
}
