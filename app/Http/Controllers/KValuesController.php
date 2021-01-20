<?php

namespace App\Http\Controllers;


use App\Kvalue;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class KValuesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kvalues = Kvalue::all();
     return view('adm.kvalues',['kvalues'=>$kvalues]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
//    public function create()
//    {
//        return view('adm.banners_form');
//
//    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
//    public function store(Request $request)
//    {
//        $banner = Banner::create($request->all());
//
//        if ($request->hasFile('_photo')) {
////             $this->image_upload($request, $banner->id);
//            Image::make($request->file('_photo'))->save('sliders/' . $banner->id.'.jpg');
//             }
//
//    Session::flash('flash_message', "Добавлен баннер: $banner->id");
//    return redirect()->route('adm.banners.index');
//}



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function edit(Kvalue $kvalue)
    {
return view('adm.kvalues_form',['kvalue'=>$kvalue]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kvalue $kvalue)
    {


        $kvalue->value = trim($request->text);
        $kvalue->save();


        Session::flash('flash_message', "Изменена переменная: $kvalue->key");
        return redirect()->route('adm.kvalues.index');

    }

//
//    public function destroy(Banner $banner)
//    {
//        Session::flash('flash_message', "Удален баннер: $banner->id");
//        $banner->delete();
//
//        return redirect()->route('adm.banners.index');
//    }


}
