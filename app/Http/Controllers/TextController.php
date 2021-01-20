<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Text;
use App\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TextController extends Controller
{

    public function index()
    {
     $texts = Text::all();
//     dd($texts);
        return view('adm/texts',['texts' => $texts]);
    }

    public function update($id, Request $request)
    {
        Text::where('id', $id)
            ->update([
//                'type_id' => $request->type_id,
                'title' => $request->title,
//                'url' => $request->url,
//                'brief' => $request->brief,
                'text' => $request->text,
            ]);
        Session::flash('flash_message', "Текст $request->title изменен");
        return redirect()->route('adm.texts.index');

    }

    public function edit($id, Request $request)
    {
        $text = Text::find($id);
        return view('adm/text_form', compact('text'));

    }
    public function show($slug)
    {


        $text = Text::where('url','=',$slug)->firstOrFail();
        return view('public/text',['head_title'=>$text->title,'text' => $text,
            'rel_canonical'=>$rel_canonical,
            'additional_code'=>$additional_code]);
    }

    public function show_url(Request $request)
    {

         $url = $request->path();
         return  self::show($url);
    }


}
