<?php

namespace App\Http\Controllers;

use App\Category;
use App\Color;
use App\Order;
use App\Product;
use App\Text;
use Carbon\Carbon;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class OrderController extends Controller
{


    public function index()
    {
        $orders = Order::orderBy('created_at','DESC')->get();

        $statuses = $this->statuses();


        $orders->map(function ($i) {
//            $stores = [1 => 'Ростов', 2 => 'Ростов', 3 => 'Шахты', 4 => 'Шахты', 5 => 'Крым', 6 => 'Краснодар', 7 => 'Краснодар'];
//            $delivery_types = ['transport' => 'Доставка', 'pickup' => 'Самовывоз'];


            $ids = array_keys(json_decode($i->products, true));
            $i['items'] = Product::whereIn('id', $ids)->get();
            $i['date'] = (new Carbon($i->created_at))->diffForHumans();
//            $i['store_name'] = $stores[$i->store];
//            $i['delivery_name'] = $delivery_types[$i->delivery];
        });


        return view('adm.orders',compact('orders','statuses'));
    }


    public function statuses()
    {

        $status['formed'] = ['title'=>'Сформирован','color'=>'#781d9a'];
        $status['received'] = ['title'=>'Выполнен','color'=>'green'];
        $status['canceled'] = ['title'=>'Отменен','color'=>'#ff9100'];

        $status['manager'] = ['title'=>'Менеджер','color'=>'#ff9100'];
        $status['delete'] = ['title'=>'Удалено','color'=>'#ff9100'];

        return $status;

    }
}
