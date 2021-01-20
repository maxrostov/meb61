<?php

namespace App\Http\Controllers;

use App\Category;
use App\Order;
use App\Kvalue;
use App\Product;
use App\Text;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class CartController extends Controller
{
//    private $cart  = [];
//public function __construct()
//{
//    $this->cart = session('cart.items') ?? []; // или уже есть, или создаем ноаый пустой массив
//
//
//}


    public function product_add_to_cart(Request $request, $product_id)
{
    $cart = session('cart.items') ?? [];
    if($request->selected_ids){ //коллекции
        $selected_ids = json_decode($request->selected_ids,JSON_NUMERIC_CHECK);
        $cart = $cart + $selected_ids;
    } else{ // просто продукт или продукт с модами
        $id = $request->active_mod_id ?? $product_id; //
        $cart[$id] = 1;
    }


$request->session()->put('cart.items',$cart); // store

Session::flash('flash_message', "Добавлено в <a href='/cart'>корзину!</a>");
//dd();
return redirect($request->fullUrl()); //->route('product', compact('product_id'));
}

    public function show_cart()
    {
       $cart_items =  session('cart.items');

       if ($cart_items){
           $cart_products = Product::find(array_keys($cart_items))->keyBy('id');
           return view('cart',compact('cart_items','cart_products'));

       }
       else {  // корзина пуста
           return view('cart_empty');

       }

}


    public function submit_cart(Request $request)
    {
        $order = new Order;

        $order->person = $request->person;
        $order->phone = $request->phone;
        $order->email = $request->email;

//        $order->store = $request->store;
        $order->delivery = $request->delivery;
        $order->address = $request->address;

//        $order->products = json_encode($request->products);
        $order->products =  $request->cart_items;

        $order->visitor = $request->ip();
        $order->browser = $request->header('User-Agent');
        $order->save();


        $order_id = $order->id;

$msg_email = "Контакт: $request->phone ($request->person) $request->email\nПодробнее: http://mebel61.ru/adm/orders#$order_id";

$this->send_emails($msg_email,"Новый заказ №$order_id");
//$result = mail('89895332221@mail.ru', "Новый заказ №$order_id", $msg_email);


        $delivery_types = ['our_delivery' => 'Доставка по Ростову','transport' => 'Доставка ТК', 'pickup' => 'Самовывоз'];
        $delivery = 'Тип доставки: '.$delivery_types[$request->delivery]."\n";
        $adm_link = "<a href='http://mebel61.ru/adm/orders#$order_id'>Заявка №$order_id</a>";



        $msg_bitrix = "$adm_link <br><br>\n".
            $delivery. "\n<br>". $request->address .
            $this->plain_text_list_order_products($request->cart_items);
//        dd($msg_bitrix)
        $this->bitrix_submit($request, $msg_bitrix, $order_id);

        $delete_cart = $request->session()->forget('cart');

        return view('cart_thanks', compact('order_id'));
    }

private function send_emails($msg, $subj){
$kvalue = Kvalue::where('key','emails')->first();
$emails = explode(';',$kvalue->value);

foreach ($emails as $email)

mail(trim($email),$subj,$msg);
}

    private function plain_text_list_order_products($arr_products)
    {
        $txt = '';
        $arr_products = json_decode($arr_products, TRUE);
//        dd($arr_products);
        foreach ($arr_products as $key => $value) {
            $product = Product::find($key);
            $txt .= " $product->name ($value шт, $product->price р.)  <br>\n";
        }
        return $txt;
    }


    public function delete_cart(Request $request)
    {
        $request->session()->forget('cart');
        return redirect()->route('show_cart');
    }

    public function ajax_cart_update(Request $request)
    {
        $cart_items = json_decode($request->cart_items, JSON_NUMERIC_CHECK);
//        dd($cart_items);
        $request->session()->put('cart.items',$cart_items);
        return 'ok'.$request->cart_items;
    }



    private function bitrix_submit($request, $msg, $order_id)
    {


//        $utm = array_change_key_case(UtmCookie::get(),CASE_UPPER);

        $postData = [
            'TITLE' => "Заявка с сайта №$order_id", // заголовок для лида
            'NAME' => $request->person,
            'ADDRESS' => $request->address,
//            'PHONE_WORK' => $request->phone,
            'EMAIL' =>array(	// телефон в Битрикс24 = массив, поэтому даже если передаем 1 номер, то передаем его в таком формате
                "n0" => array(
                    "VALUE" =>  $request->email,	// ненастоящий номер Меган Фокс
                    "VALUE_TYPE" => "WORK",			// тип номера = мобильный
                ),
            ),
            'PHONE' =>array(	// телефон в Битрикс24 = массив, поэтому даже если передаем 1 номер, то передаем его в таком формате
                "n0" => array(
                    "VALUE" =>  $request->phone,	// ненастоящий номер Меган Фокс
                    "VALUE_TYPE" => "MOBILE",			// тип номера = мобильный
                ),
            ),
            'COMMENTS' => $msg
        ];
        $json['fields'] = $postData;//+ $utm;
        $json['params'] = ["REGISTER_SONET_EVENT" => "Y"];	// Y = произвести регистрацию события добавления лида в живой ленте. Дополнительно будет отправлено уведомление ответственному за лид.

//  dd($json);
        $queryData = http_build_query($json);



        // формируем URL, на который будем отправлять запрос
        $queryURL = "https://b24-xi1dfr.bitrix24.ru/rest/6/8d2v6t103ex9qrhz/crm.lead.add.json";



        // отправляем запрос в Б24 и обрабатываем ответ
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $queryURL,
            CURLOPT_POSTFIELDS => $queryData,
        ));
        $result = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($result,1);



    }


}
