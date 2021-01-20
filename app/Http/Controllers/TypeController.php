<?php

namespace App\Http\Controllers;


use App\Type;
use App\Tvalues;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = Type::all();
     return view('adm.types',['types'=>$types]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adm.types_form');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
$is_dublicate = Type::where('type',$request->type)->get();
//dd($is_dublicate);
if ($is_dublicate->count()){
    Session::flash('flash_message_error', "Не добавлено!   &laquo;$request->color&raquo; уже существует");
    return view('adm.types_form');
}else {
    $type = Type::create($request->all());

    Session::flash('flash_message', "Добавлен: $type->type");
    return redirect()->route('adm.types.index');
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
    public function edit(Type $type)
    {
return view('adm.types_form',['type'=>$type]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Type $type)
    {

        $type->fill($request->all())->save();

        Session::flash('flash_message', "Изменен: $type->type");
        return redirect()->route('adm.types.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type $type)
    {
        Session::flash('flash_message', "Удален: $type->type");
        $type->delete();

        return redirect()->route('adm.types.index');
    }


    ///////
    ///
    ///
    ///
    ///
    public function value_create($type_id)
    {
        $type = Type::find($type_id);
        return view('adm.values_form',['type'=>$type]);

    }

    public function value_store(Request $request, $type_id)
    {
        $is_dublicate = Tvalues::where('type_id',$type_id)->where('value',$request->value)->get();
//dd($is_dublicate);
        if ($is_dublicate->count()){
            Session::flash('flash_message_error', "Не добавлено!   &laquo;$request->value&raquo; уже существует");
            return redirect()->route('adm.types.index');
        }else {
            $value= Tvalues::create(['value'=>$request->value,'type_id'=>$type_id]);

            Session::flash('flash_message', "Добавлен: $value->value");
            return redirect()->route('adm.types.index');
        }

    }


    public function value_edit($value_id)
    {
        $value = Tvalues::find($value_id);
        return view('adm.values_form',['value'=>$value]);
    }

    public function value_update($value_id, Request $request)
    {
        $value = Tvalues::find($value_id);
        $value->value = $request->value;
        $value->save();
//        $value->update(['value'=>$request->value])->save();

        Session::flash('flash_message', "Изменено значение: $value->value");
        return redirect()->route('adm.types.index');
    }

    public function value_delete($value_id)
    {
        $value = Tvalues::find($value_id);
        Session::flash('flash_message', "Удален: $value->value");
        $value->delete();

        return redirect()->route('adm.types.index');
    }



}
