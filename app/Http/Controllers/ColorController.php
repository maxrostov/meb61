<?php

namespace App\Http\Controllers;


use App\Color;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colors = Color::orderBy('status', 'DESC')->orderBy('color')->get();
     return view('adm.colors',['colors'=>$colors]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adm.colors_form');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
$is_dublicate = Color::where('color',$request->color)->get();
//dd($is_dublicate);
if ($is_dublicate->count()){
    Session::flash('flash_message_error', "Не добавлено! Цвет &laquo;$request->color&raquo; уже существует");
    return view('adm.colors_form');
}else {
    $color = Color::create($request->all());



    Session::flash('flash_message', "Добавлен цвет: $color->color");
    return redirect()->route('adm.colors.create');
}

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function show(Color $color)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function edit(Color $color)
    {
return view('adm.colors_form',['color'=>$color]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Color $color)
    {


     if ($request->file('_photo')) {
         $path = $request->file('_photo')->store('colors');
         $request['photo'] =$path;
     }

     if ($request->_photo_del){
         $request['photo'] ='';
     }
        $color->fill($request->all())->save();




        Session::flash('flash_message', "Изменен цвет: $color->color");
        return redirect()->route('adm.colors.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function destroy(Color $color)
    {
        Session::flash('flash_message', "Удален цвет: $color->color");
        $color->delete();;

        return redirect()->route('adm.colors.index');
    }

    public function image_upload(Request $request, $color_id)
    {

        $photo = $request->file('_photo');
        $filenames = [];


            $extension = $photo->getClientOriginalExtension();
            $filename = $color_id . '_' . rand(1, 99) . '.' . $extension;

            Image::make($photo)->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save('upload/colors/' . $filename);
            $filenames[] = $filename;

        return $filenames;
    }

}
