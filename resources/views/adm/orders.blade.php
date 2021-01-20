@extends('adm.__layout')

@section('content')

 <h2>Заказы</h2>

{{-- <a href="/adm/colors/create" class="ui labeled icon button green"><i class="ui icon plus"></i>Добавить</a>--}}

 @php
     $delivery_types['pickup']='Самовывоз';
$delivery_types['our_delivery']='Наша доставка';
$delivery_types['transport_company']='Доставка транспортной компанией';

 @endphp

 @if($orders)
     @foreach($orders as $order)
         <div style="margin:1em 1em; padding: 0 1em; border-left: 1px solid #d8dadd;">
             <a name="{{$order->id}}"></a>
             <span style="font-size: 90%; color:grey;">{{$order->created_at}}
                 ({{ \Illuminate\Support\Facades\Date::parse($order->created_at)->diffForHumans()}})
             </span>
             <br>  <h4 style="display: inline-block;">№{{$order->id}} {{$order->person}}
                 @if($order->status) <span
                     style="text-transform: uppercase;font-size:50%;padding:2px 8px;border-radius: 4px;
                                        border: 1px solid;vertical-align: middle;color:{{$statuses[$order->status]['color']}}">
                                    {{$statuses[$order->status]['title']}}</span>@endif
             </h4>&nbsp;  {{$order->cancel_info}}<br>
             @if($order->manager)Менеджер: {{$order->manager}} <br> @endif
             {{$order->phone}} {{$order->email}} <br>
{{--             Склад: {{$order->store_name}} <br>--}}
             <i>{{$delivery_types[$order->delivery] ?? ''}}</i>
             {{$order->address}}
             <table class="ui striped table" style="width: 96%;">

                 @php
                     $a = json_decode($order->products, true);

                     $total_item = 0;
                     $total_weight = 0;
                     $total_volume = 0;
                     $total_price = 0;

                 @endphp

                 <thead>
                     <tr>

                         <th>Артикул</th>
                         <th>Товар</th>
                         <th>Материал</th>
                         <th>Цвет</th>
                         <th>Масса</th>
                         <th>Объем</th>
                         <th>Цена розн, 1 шт</th>
                         <th>Кол</th>
                         <th>Цена всего</th>
                         <th>Фото</th>
                     </tr>
                 </thead>
                 @foreach($order->items as $item)

                     @php
                         $total_item +=$a[$item->id];
                          $total_weight += $item->weight*$a[$item->id];
                          $total_volume += $item->volume*$a[$item->id];
                           $total_price += $item->public_price*$a[$item->id];
                     @endphp

                     <tr>
                         <td>{{$item->artikul}} {{$item->fabric_name}} </td>
                         <td><a href="/mebel/{{$item->id}}">{{$item->name}}</a> ({{$item->factory->factory}}) <br>
                             {{$item->mod_name}} <br>

                             <div style="font-size: 80%; color: grey">
                                 @forelse ($item->parent_collections as $col)
                                      {{ $col->name }} <br>
                                 @empty
                             @endforelse
                             </div>
                         </td>
                         <td>{{$item->material_body->material ?? ''}} {{$item->material_face->material ?? ''}}</td>
                         <td>{{$item->color_body}}; <br> {{$item->color_face}}</td>
                         <td>{{$item->weight*$a[$item->id]}}</td>
                         <td>{{$item->volume*$a[$item->id]}}</td>
                         <td>{{$item->public_price}}</td>
                         <td>{{$a[$item->id]}}</td>
                         <td>{{$item->public_price*$a[$item->id]}}</td>
                         <td>
                             @if($item->photos AND $item->photos[0])
                                 {{--                                 {{print_r($item->photos)}}--}}
                                 <img onclick="$(this).toggleClass('products_listing_img_popup')" class="products_listing_img"  src="/upload/{{$item->photos[0]}}" alt="">
                             @endif

                         </td>
                     </tr>

                 @endforeach

                 <tfoot>
                     <tr style="background: #fff;border-top: 2px solid #8b8b8b;">
                         <td>Итого</td>
                         <td></td>
                         <td>{{$total_item}}</td>
                         <td>{{$total_weight}}</td>
                         <td>{{$total_volume}}</td>
                         <td></td><td></td><td></td>
                         <td>{{$total_price}} руб.</td>
                         <td></td>
                     </tr>
                 </tfoot>
             </table>
             <span title="{{$order->visitor}} {{$order->browser}}" style="color:grey;cursor:pointer;font-size: 80%;border-bottom: 1px dashed lightgrey;">ip адрес</span>


{{--             <form xaction="#{{$order->id}}" method="post" style="font-size: 80%;width: 100%;max-width: 800px;">--}}
{{--                 @csrf--}}
{{--                 <input type="hidden" name="order_id" value="{{$order->id}}">--}}
{{--                 <input type="hidden" name="cancel_info" id="cancel_info{{$order->id}}" value="">--}}
{{--                 <input type="hidden" name="manager" id="manager{{$order->id}}" value="">--}}
{{--                 <button name="new_status" xtype="submit" value="delete" style="float: right;"--}}
{{--                         onclick="return confirm('Действительно удалить заказ №{{$order->id}}?');">удалить</button>--}}
{{--                 --}}{{--<button name="new_status" type="submit" value="formed">{{$statuses['formed']['title']}}</button>--}}
{{--                 <button name="new_status" xtype="submit" value="received">{{$statuses['received']['title']}}</button>--}}
{{--                 <button name="new_status" xtype="submit" value="canceled"--}}
{{--                         onclick="$('#cancel_info{{$order->id}}').val(prompt('Укажите причину отмены заказа'))">{{$statuses['canceled']['title']}}</button>--}}
{{--                 <button name="new_status" xtype="submit" value="manager"--}}
{{--                         onclick="$('#manager{{$order->id}}').val(prompt('Укажите менеджера'))">Менеджер</button>--}}

{{--             </form>--}}

         </div> <br>

     @endforeach
 @else
     Заявок нет.
 @endif


@endsection
