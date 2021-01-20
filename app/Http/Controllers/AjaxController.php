<?php

namespace App\Http\Controllers;

use App\Category;
use App\Color;
use App\Factory;
use App\Material;
use App\Product;
use App\Status;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

class AjaxController extends Controller
{





    public function detach_category(Request $request)
    {

        Product::find($request->product_id)->categories()->detach($request->category_id);

        return response()->json(['status' => 'ok']);

    }



    public function inline_value(Request $request)
    {
// TODO какая-то проверка типа и защита
        Product::find($request->product_id)->update([$request->field => $request->value]);

        return response()->json(['field_updated_to' => $request->value ]);

    }



}
