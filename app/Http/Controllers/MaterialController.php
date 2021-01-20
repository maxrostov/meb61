<?php

namespace App\Http\Controllers;

use App\Material;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $materials = material::orderBy('material')->get();
        return view('adm.materials',['materials'=>$materials]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adm.materials_form');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $material = material::create(['material'=>$request->material]);
        Session::flash('flash_message', "Добавлен цвет: $material->material");
        return redirect()->route('adm.materials.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function show(Material $material)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function edit(Material $material)
    {
        return view('adm.materials_form',['material'=>$material]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Material $material)
    {
        $material->fill(['material' => $request->material])->save();
        Session::flash('flash_message', "Изменен цвет: $material->material");
        return redirect()->route('adm.materials.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function destroy(Material $material)
    {
        Session::flash('flash_message', "Удален цвет: $material->material");
        $material->delete();;

        return redirect()->route('adm.materials.index');
    }
}
