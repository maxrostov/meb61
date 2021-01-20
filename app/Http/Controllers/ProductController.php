<?php

namespace App\Http\Controllers;

use App\Category;
use App\Color;
use App\Factory;
use App\Material;
use App\Product;
use App\Status;
use App\Type;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function stat()
    {

//        $count = DB::table('products')
//            ->select(DB::raw('category_id, count(category_id) count'))
//            ->where('deleted_at', null)
//            ->groupBy('category_id')->get()->keyBy('category_id');
//
//        $top_cat = Category::where('parent_id', 0)->get();
//
//$products_count = Product::all()->count();

        $cat_tree = Category::with_count();

//        , 'count' => $count
        return view('adm/products_tree', compact('cat_tree'));


//        $categories = Category::where('parent_id',0)->get();
//        return view('adm.products_tree',['categories'=>$categories]);

    }




    public function index(Request $request)
    {
        $factories = Factory::orderBy('factory')->pluck('factory', 'id');
        $statuses = Status::orderBy('id')->pluck('status', 'id');

        $collections = null;
        $categories = Category::for_select();
        $cat_tree =   Category::with_count();
        $colors_suggest = Color::orderBy('color')->pluck('color', 'id');

        $product_count = Category::product_count();

// есть выбранные товары
if($request->selected AND $request->selected_submit){
    $count = count($request->selected);

    if ($request->selected_action){
        if($request->selected_action=='is_hidden'){
            Product::whereIn('id',$request->selected)->update(['is_hidden'=>1]);
            Session::flash('flash_message', "Скрыто с сайта $count товаров");

        }
        elseif($request->selected_action=='set_price_zero'){
            Product::whereIn('id',$request->selected)->update(['price'=>0]);
            Session::flash('flash_message', "Нулевая цена установлена для $count товаров");
        }
        elseif($request->selected_action=='delete_item'){
            Product::destroy($request->selected);
            Session::flash('flash_message', "Удалено $count товаров");
        }

        else {
        $statuses['set_status_1'] = ['id'=>1,'label'=>'Не проверено'];
        $statuses['set_status_2'] = ['id'=>2,'label'=>'Проверено'];
        $statuses['set_status_3'] = ['id'=>3,'label'=>'Недочеты'];
        $statuses['set_status_4'] = ['id'=>4,'label'=>'Скрыто'];
        $status_id = $statuses[$request->selected_action]['id'];
        $label = $statuses[$request->selected_action]['label'];

        Product::whereIn('id',$request->selected)->update(['status_id'=>$status_id]);
        Session::flash('flash_message', "Установлен статус &laquo;$label&raquo; для $count товаров");
        }
    }

    if ($request->selected_category_id){
        $category_name= Category::where('id',$request->selected_category_id)->value('category');
        $selected_category_id = $request->selected_category_id;
        Product::whereIn('id',$request->selected)->
        each(function ($item, $key) use($selected_category_id){
        $item->categories()->attach($selected_category_id);
        });
        Session::flash('flash_message', "Установлен раздел &laquo;$category_name&raquo; для $count товаров");

    }
    if ($request->selected_collection_id){
        $collection= Product::find($request->selected_collection_id);
//        Product::whereIn('id',$request->selected)->sync(['collection_id'=>$request->selected_collection_id]);
     foreach(Product::whereIn('id',$request->selected)->get() as $product){
         $product->parent_collections()->syncWithoutDetaching($request->selected_collection_id);
     }

        Session::flash('flash_message', "$count товаров добавлено в коллекцию &laquo;<a href='/adm/products/$collection->id/edit'>$collection->name</a>&raquo;");

    }
}

        $request->flash();
        $category_id = $request->category_id;
        $products = Product::whereNull('parent_id')->
            with(['parent_collections','categories','color','status','factory','material_body','material_face',
            'children.categories','children.color','children.status','children.factory', 'children.material_body','children.material_face' ])->
//            ->whereHas('categories', function ($query) use ($category_id) {
//           if($category_id) $query->where('category_id', $category_id);
//        })
        when($request->category_id, function ($query, $category_id) {
            return $query->whereHas('categories', function ($query) use ($category_id) {
           return $query->where('category_id', $category_id);
        });
        })->
        when($request->search_name, function ($query, $search_name)  use($request){
            if ($request->search_mode=='natural'){
                $query =  $query->whereRaw("MATCH (name, fabric_name) AGAINST('$search_name' IN NATURAL LANGUAGE MODE)");
            }
            if ($request->search_mode=='boolean'){
                $query =  $query->whereRaw("MATCH (name, fabric_name) AGAINST('$search_name' IN BOOLEAN MODE)");
            }
            if ($request->search_mode=='like'){
                $query =  $query->where('name','like', "%$search_name%")
                                ->orWhere('fabric_name','like', "%$search_name%");
            }

            return  $query;

        })->
        when($request->filter, function ($query, $filter) {
            if ($filter==1){
                return $query->whereNotNull('photos');
            } elseif ($filter==2){
                return $query->whereNull('photos');

            }
        })->
        when($request->checkbox_no_photo, function ($query) {
            return $query->where('photos',NULL);
        })->
        when($request->checkbox_no_price, function ($query) {
            return $query->where('price','<',2);
        })->
        when($request->checkbox_with_deleted, function ($query) {
            return $query->onlyTrashed();
        })->
        when($request->factory_id, function ($query, $factory_id) {
            return $query->where('factory_id',$factory_id);
        })->
        when($request->status, function ($query, $status_id) {
            return $query->where('status_id',$status_id);
        })->
        when($request->order_by, function ($query, $order_by) {
            if ($order_by=='created_at_asc'){
                return $query->orderBy('created_at');

            }
            elseif ($order_by=='created_at_desc'){
                return $query->orderBy('created_at','DESC');

            } else{
        return $query->orderBy('name');
    }
        }, function($query){
                return $query->orderBy('name');
            }
        )->
//            toSql();
        paginate($request->pagination ?? 20);
//        die( $products);
;


        $factories = Factory::orderBy('factory')->pluck('factory', 'id');
        $statuses = Status::orderBy('id')->pluck('status', 'id');


        $categories = Category::for_select();
        $cat_tree =   Category::with_count();
//dd($cat_tree);
        if ($request->factory_id){

 // массовая установка коллекции возможно только если выбрана фабрика (иначе их слишком много)
        $collections = Product::whereIsCollection(1)->whereFactoryId($request->factory_id)
                        ->orderBy('name')->pluck('name','id');
        }else{
            $collections = null;
        }
        return view('adm/products', compact('product_count','cat_tree','products','collections','categories','statuses','factories','colors_suggest'));
    }



    public function products_cat(Request $request, $cat_id)
    {
//        $category = Category::with('products')->find($cat_id);
        $category = Category::with(['products' => function ($query) {
            $query->whereNull('parent_id');
        }])->find($cat_id);

        $products = $category->products;
//        $products =  Product::with(["categories" => function($q) use ($cat_id){
//            $q->where('categories.id', '=', $cat_id);
//        }]);

//        $products = Product::all()->whereNull('parent_id')->categories()->where('category_id',$cat_id)->get();
//        ->whereNull('parent_id')

        //  сохраняем в сессию для возврата после сохранения в раздел
        session(['last_visited_cat_id' => $cat_id,'last_visited_cat_name' => $category->category]);

        return view('adm/products_cat', compact('category','products'));
    }


    public function image_upload(Request $request, $product_id)
    {
//        $fields = $request->all();

        $files = $request->file('_photos');
        $filenames = [];

        foreach ($files as $photo) {

            $extension = $photo->getClientOriginalExtension();
            $filename = $product_id . '_' . rand(1, 99) . '.' . $extension;

            Image::make($photo)->resize(1100, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save('upload/' . $filename);
            $filenames[] = $filename;
        }
//        $fields['photos'] = $filenames;
//        $filenames = implode(',', $filenames); // массив склеиваем в строку
//        // если уже есть фотографии (из hidden поля) тогда свежезалитые прибавляем (через запятую)
//        $fields['photos'] = isset($fields['photos']) ?
//            $fields['photos'] . ',' . $filenames : $filenames;

        return $filenames;
    }




    public function create(Request $request)
    {
//        $cat_id = $request->cat_id; // подсказка для меню раздела

        foreach (Category::where('parent_id', 0)->get() as $cat) {
            $categories[$cat->category] = Category::where('parent_id', $cat->id)->pluck('category', 'id')->toArray();
        }
        $types = Type::all();

        $materials = Material::orderBy('material')->pluck('material', 'id');
        $factories = Factory::orderBy('factory')->pluck('factory', 'id');

        $basic_colors_image = Color::where('status',1)->orderBy('color')->get();
        $colors = Color::orderBy('color')->pluck('color', 'id');

        $basic_colors = Color::where('status',1)->orderBy('color')->pluck('color', 'id');
        $statuses = Status::orderBy('id')->pluck('status', 'id');

        $collections = Product::whereCollectionId(0)->pluck('name', 'id')->toArray();
        $parent = [0=>'[Модуль-родитель]'];
        $collections = $parent + $collections;

        return view('adm/products_form', compact('factories', 'types','categories', 'statuses', 'collections','materials','basic_colors_image', 'colors','basic_colors'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $flash_message_error='';
        if ($request->name AND $dub_name = Product::where('name',$request->name)->first()) {
//    $unsaved_product = new Product($fields);
            $flash_message_error =  "НЕ ДОБАВЛЕНО! Товар с названием <a href='/adm/products/$dub_name->id/edit'>
&laquo;$dub_name->name&raquo;</a> уже существует <br>";
        }
        if ($request->fabric_name AND $dub_fabric_name = Product::where('fabric_name',$request->fabric_name)->first()) {
            $flash_message_error .=  "НЕ ДОБАВЛЕНО! Товар с фабричным названием <a href='/adm/products/$dub_name->id/edit'>
                                        &laquo;$dub_name->name&raquo;</a> уже существует <br>";
        }
        if ($request->artikul AND $dub_artikul = Product::where('artikul',$request->artikul)->first()) {
            $flash_message_error .=  "НЕ ДОБАВЛЕНО! Товар с артикулом <a href='/adm/products/$dub_artikul->id/edit'>
&laquo;$dub_artikul->artikul&raquo;</a> уже существует <br>";

        }

        if ($flash_message_error){
            Session::flash('flash_message_error',$flash_message_error);
            return redirect()->route('adm.products.create');

        }

        $fields = $request->all();
        unset($fields['tvalues']);

        $fields['weight'] = (float)str_replace(',', '.', $fields['weight']);
        $fields['volume'] = (float)str_replace(',', '.', $fields['volume']);
        $fields['load'] = (float)str_replace(',', '.', $fields['load']);
        $fields['status_id'] = 1; // только созданным - статус "не проверено"
/// CREATE //
        $product = Product::create($fields);

        if ($request->hasFile('_photos')) {
            $fields['photos'] = $this->image_upload($request, $product->id);
            $product->fill($fields)->save();
        }

        $product->categories()->attach($request->category_ids);

        if ($request->tvalues) {
            $tvalues_ids = array_filter($request->tvalues); // remove null [удалить]
            $product->tvalues()->sync($tvalues_ids);
        }

        Session::flash('flash_message', "Добавлен товар: $product->name");
//        return redirect()->route('adm.products.index');
        return redirect()->route('adm.products.edit',[$product]);

    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {

        foreach (Category::where('parent_id', 0)->orderBy('category')->get() as $cat) {
            $categories[$cat->category] = Category::where('parent_id', $cat->id)->orderBy('category')->pluck('category', 'id')->toArray();
        }

        $types = Type::all();
        $materials = Material::orderBy('material')->pluck('material', 'id');
        $factories = Factory::orderBy('factory')->pluck('factory', 'id');
        $basic_colors = Color::where('status',1)->orderBy('color')->pluck('color', 'id');
        $basic_colors_image = Color::where('status',1)->orderBy('color')->get();

        $colors = Color::orderBy('color')->pluck('color', 'id');
        $statuses = Status::orderBy('id')->pluck('status', 'id');
        $siblings =  Product::whereFactoryId($product->factory_id)->orderBy('name')->pluck('name', 'id');

        if ($product->parent_id){

        } else{

        }
//        $mods_children = Product::where('parent_id', $product->id)->orderBy('name')->get();//->pluck('name', 'id');
//        $collections = Product::whereFactoryId($product->factory_id)->whereCollectionId(0)->pluck('name', 'id')->toArray();
//        $collections = [0=>'[Модуль-родитель]'] + $collections;

        return view('adm/products_form', compact('product', 'siblings','statuses',
            'colors','basic_colors_image','basic_colors','factories', 'categories',
            'types','materials'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $fields = $request->all();
        unset($fields['tvalues']);
        unset($fields['collections']);

        if (!$request->is_collection) $fields['is_collection']=NULL;
        if (!$request->is_hidden) $fields['is_hidden']=NULL;

        // очищаем массив от лишних запятых после удаления в браузере (т.к. js сделано самым дубовым простым способом)
//        $fields['photos'] = implode(',', array_filter(explode(',', $request->photos)));
        // заменяем запятые на точки, а то база ругается
        $fields['weight'] = (float)str_replace(',', '.', $fields['weight']);
        $fields['volume'] = (float)str_replace(',', '.', $fields['volume']);
        $fields['load'] = (float)str_replace(',', '.', $fields['load']);

//dd($product->id);
        $flash_message_error='';

//        if ( $dub_name = Product::where('name',$request->name)->where('id','<>',$product->id)->first()) {
////    $unsaved_product = new Product($fields);
//            $flash_message_error .=  "НЕ СОХРАНЕНО! Товар с именем <a href='/adm/products/$dub_name->id/edit'>
//&laquo;$dub_name->name&raquo;</a> уже существует <br>";
//
//        }

//        if ( $dub_fabric_name = Product::where('fabric_name',$request->fabric_name)->where('id','<>',$product->id)->first()) {
//            $flash_message_error .=  "НЕ СОХРАНЕНО! Товар с именем <a href='/adm/products/$dub_fabric_name->id/edit'>
//                                        &laquo;$dub_fabric_name->name&raquo;</a> уже существует <br>";
//        }

        if ($request->artikul AND $dub_artikul = Product::where('artikul',$request->artikul)->where('id','<>',$product->id)->first()) {
            $flash_message_error .=  "НЕ СОХРАНЕНО! Товар с артикулом <a href='/adm/products/$dub_artikul->id/edit'>
&laquo;$dub_artikul->artikul&raquo;</a> уже существует <br>";

        }

        if ($flash_message_error){
            Session::flash('flash_message_error',$flash_message_error);
            return redirect()->route('adm.products.edit',[$product]);

        }


        if ($request->hasFile('_photos')) {
            $uploaded = $this->image_upload($request, $product->id);

            if ($product->photos) $fields['photos'] = array_merge($product->photos, $uploaded); // к старым фото прибавляем новые
            else $fields['photos'] = $uploaded;
        } else {
          if (isset($fields['photos'])) $fields['photos'] = explode(',', $fields['photos']);
        }
//        $fields['photos'] = '[1,2,3,4]';

        $product->fill($fields)->save();
//        $product->categories()->detach();
        $product->categories()->sync($request->category_ids);

//        $product->tvalues()->detach();
        if($request->tvalues){
            $tvalues_ids =  array_filter($request->tvalues); // remove null [удалить]
            $product->tvalues()->sync($tvalues_ids);
        }

        if($request->collections){
            $product->parent_collections()->sync($request->collections);
        }

//         нажали "сохранить  и  иодификация"
        if ($request->save_and_mod_button) {
            Session::flash('flash_message', "Создана модификация для товара: $product->name");
            $fields['parent_id']= ($product->parent_id) ? $product->parent_id : $product->id ;
            $product_mod = Product::create($fields);
            $product_mod->categories()->attach($request->category_ids);
            return redirect()->route('adm.products.edit', [$product_mod]);
        }

        //         нажали "сохранить  и  копировать"
        if ($request->save_and_copy_button) {
            Session::flash('flash_message', "Создана копия для товара: $product->name");
            $product_clone = Product::create($fields);
            $product_clone->categories()->attach($request->category_ids);
            return redirect()->route('adm.products.edit', [$product_clone]);

        }
        else { // обычное сохранение
            Session::flash('flash_message', "Изменен товар: $product->name");
            return redirect()->route('adm.products.edit', [$product]);

        // с возвратом в раздел
//            return redirect(session('last_search_url'));
//            return redirect()->route('adm.products.index');

        }
    }


    public function mod($product_id){
        $donor = Product::find($product_id);
        $product  = $donor->replicate();
        $product->parent_id = $product_id;
        $product->save();

        foreach ($donor->categories as $cat) $product->categories()->attach($cat);

        Session::flash('flash_message', "Создана модификация: $donor->name");
        return redirect()->route("adm.products.edit",[$product]);
    }


    public function copy($product_id){
        $donor = Product::find($product_id);
        $product  = $donor->replicate();
//        $product->parent_id = $product_id;
        $product->save();
        foreach ($donor->categories as $cat) $product->categories()->attach($cat);

        Session::flash('flash_message', "Создана копия: $donor->name");
        return redirect()->route("adm.products.edit",[$product]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        Session::flash('flash_message', "Удален товар: $product->name");
        $product->delete();;
        return redirect()->route('adm.products.index');
    }

}
