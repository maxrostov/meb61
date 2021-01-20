<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::where('parent_id',0)->orderBy('category')->get();
        return view('adm.categories',['categories'=>$categories]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $cat_id= $request->cat_id;
        $subcat_id= $request->subcat_id;

        $top_categories = Category::where('parent_id',0)->pluck('category','id');
        $categories = Category::for_select();
        return view('adm.categories_form',compact('categories','subcat_id','cat_id','top_categories'));

    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = Category::create(['parent_id'=>($request->parent_id ?? 0),
        'subparent_id'=>($request->subparent_id ?? 0),
        'category'=>$request->category,
            'info'=>$request->info,
            'shortname'=>$request->shortname,
            ]);
        Session::flash('flash_message', "Добавлен раздел: $category->category");
        return redirect()->route('adm.categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $categories = Category::for_select();
        $top_categories = Category::where('parent_id',0)->pluck('category','id');
        return view('adm.categories_form',compact('categories','category','top_categories'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
//        dd($category->id);
        $category->fill(
            ['category' => $request->category,
              'parent_id'=>($request->parent_id ?? 0),
        'subparent_id'=>($request->subparent_id ?? 0),
                'shortname'=>$request->shortname,
                'info'=>$request->info,
                'is_hidden'=>$request->is_hidden,
            ]
        )->save();
        Session::flash('flash_message', "Изменен раздел: $request->category");
        return redirect()->route('adm.categories.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        Session::flash('flash_message', "Удален раздел: $category->category");
        $category->delete();

        return redirect()->route('adm.categories.index');
    }
}
