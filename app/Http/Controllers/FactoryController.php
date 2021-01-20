<?php

namespace App\Http\Controllers;

use App\Factory;
use App\Product;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PDOStatement;
use SimpleXLSX;

// my_vendor
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;


class FactoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $factories = Factory::orderBy('factory')->get();
//TODO все налету из справочников, а не захардкожено

        $total_total = DB::table('products')
            ->selectRaw('count(*) total')
            ->get()->pluck('total')->toArray()[0];


        $total = DB::table('products')
            ->select('factory_id')
            ->selectRaw('count(*) total')
            ->groupBy('factory_id')
            ->get()->pluck('total','factory_id')->toArray();


        $deleted_total = DB::table('products')
            ->selectRaw('count(*) total')
            ->whereNotNull('deleted_at')->get()->pluck('total')->toArray()[0];



        $status_1_total = DB::table('products')
            ->selectRaw('count(status_id) count_status_id')
            ->groupBy('status_id')
                ->whereNull('deleted_at')->having('status_id',1)->get()->pluck('count_status_id')[0]?? '-';


        $status_2_total = DB::table('products')
            ->selectRaw('count(status_id) count_status_id')
            ->groupBy('status_id')
                ->whereNull('deleted_at')->having('status_id',2)->get()->pluck('count_status_id')[0]?? '-';

        $status_3_total = DB::table('products')
            ->selectRaw('count(status_id) count_status_id')
            ->groupBy('status_id')
                ->whereNull('deleted_at')->having('status_id',3)->get()->pluck('count_status_id')[0]?? '-';


        $status_4_total = DB::table('products')
            ->selectRaw('count(status_id) count_status_id')
            ->groupBy('status_id')
                ->whereNull('deleted_at')->having('status_id',4)->get()->pluck('count_status_id')[0] ?? '-';

//        dd($status_3_total);


        $deleted_by_factory = DB::table('products')
            ->select('factory_id')
            ->selectRaw('count(*) total')
            ->groupBy('factory_id')
            ->whereNotNull('deleted_at')->get()->pluck('total','factory_id')->toArray();



        $status_1 = DB::table('products')
            ->select('factory_id')
            ->selectRaw('count(status_id) count_status_id')
            ->groupBy('factory_id')
            ->groupBy('status_id')
            ->having('status_id',1)->get()->pluck('count_status_id','factory_id');
        $status_2 = DB::table('products')
            ->select('factory_id')
            ->selectRaw('count(status_id) count_status_id')
            ->groupBy('factory_id')
            ->groupBy('status_id')
            ->having('status_id',2)->get()->pluck('count_status_id','factory_id');
        $status_3 = DB::table('products')
            ->select('factory_id')
            ->selectRaw('count(status_id) count_status_id')
            ->groupBy('factory_id')
            ->groupBy('status_id')
            ->having('status_id',3)->get()->pluck('count_status_id','factory_id');
        $status_4 = DB::table('products')
            ->select('factory_id')
            ->selectRaw('count(status_id) count_status_id')
            ->groupBy('factory_id')
            ->groupBy('status_id')
            ->having('status_id',4)->get()->pluck('count_status_id','factory_id');


        return view('adm.factories',
//            compact('factories','status_1','status_2','status_3','status_4')
        ['deleted_total'=>$deleted_total,'deleted_by_factory'=>$deleted_by_factory,'factories'=>$factories,'total'=>$total,'status_1'=>$status_1,'status_2'=>$status_2,
            'status_3'=>$status_3,'status_4'=>$status_4,
        'total_total'=>$total_total, 'status_1_total'=>$status_1_total, 'status_2_total'=>$status_2_total,
        'status_3_total'=>$status_3_total, 'status_4_total'=>$status_4_total]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adm.factories_form');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $factory = Factory::create(['factory'=>$request->factory]);
        Session::flash('flash_message', "Добавлена фабрика: $factory->factory");
        return redirect()->route('adm.factories.create');
    }


    public function csv(Factory $factory)
    {

       $products = Product::where('factory_id',$factory->id)->get();
        return view('adm.factories_csv',['products'=>$products]);


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Factory  $factory
     * @return \Illuminate\Http\Response
     */
    public function edit(Factory $factory)
    {
        return view('adm.factories_form',['factory'=>$factory]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Factory  $factory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Factory $factory)
    {
        $factory->fill(['factory' => $request->factory,
            'margin' => $request->margin])->save();
        Session::flash('flash_message', "Изменена фабрика: $factory->factory");
        return redirect()->route('adm.factories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Factory  $factory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Factory $factory)
    {
        Session::flash('flash_message', "Удален цвет: $factory->factory");
        $factory->delete();;

        return redirect()->route('adm.factories.index');
    }




    public function price_form(Factory $factory)
    {
        return view('adm.factories_price_form',['factory'=>$factory,'log'=>[],'field'=>'']);

    }



    public function price_submit_large(Request $request, Factory $factory)
    {
// на больших файлах затыкается query builder - поэтому посылаю просто сырыми запросами.
        // количество строк пока тоже не понял как быстро подсчитать, поэтому юзер ставит галочку.

        $path = $request->file('xlsx_file')->getRealPath();

        $reader = ReaderEntityFactory::createXLSXReader();
        $reader->open($path);


        foreach ($reader->getSheetIterator() as $sheet) {
        }
//        $row_count = 0;
        $row_count = iterator_count($sheet->getRowIterator());


        $sqls = '';

        $factory_id = $factory->id;

//        $large_excel_flag = ($request->is_large_excel) ? 1 : 0; // html checkbox
        $large_excel_flag = ($row_count>1000) ? 1 : 0;



                foreach ($sheet->getRowIterator() as $row) {
                    $cells = $row->getCells();
                    $label = trim($cells[0]);
                    $price = trim($cells[1]);

            if ($label=='') continue; // если пусто -- пропускаем

            $request_field  = $request->field; // 'factory_name' или 'artikul'

            if ($large_excel_flag){

                $sqls .= "UPDATE products SET price=$price
        WHERE factory_id=$factory_id AND $request_field='$label';\n ";
                $log = $row_count;

            } else{
                $result =  Product::
                where($request_field,$label)
                    ->where('factory_id',$factory_id)
                    ->update(['price'=>$price]);
                $log[] = compact('label','price','result');

            }
//                    $row_count++;
        }


                if ($large_excel_flag){
                    $affected_rows = DB::unprepared($sqls);
                    $log = $row_count;
                }

        return view('adm.factories_price_form',['factory'=>$factory,'log'=>$log,'field'=>$request_field]);

    }




//    public function price_submit(Request $request, Factory $factory)
//    {
//        $path = $request->file('xlsx_file')->getRealPath();
//        $xlsx = SimpleXLSX::parse($path);
//
//        if (!$xlsx) echo SimpleXLSX::parseError();
//
//        $row_count = count($xlsx->rows());
////        dd();
//
//
//            foreach ($xlsx->rows() as $row){
//                $label = trim($row[0]);
//                $price = trim($row[1]);
//
//                if ($label=='') continue; // если пусто -- пропускаем
//
//            $request_field  = $request->field; // 'factory_name' или 'artikul'
//
//                if ($row_count > 5000){
//
//                    $sqls .= "UPDATE products SET price=$price
//        WHERE factory_id=$factory_id AND $field='$label';\n ";
//$log = $row_count;
//
//                } else{
//                    $result =  Product::
//                    where($request_field,$label)
//                        ->where('factory_id',$factory->id)
//                        ->update(['price'=>$price]);
//                    $log[] = compact('label','price','result');
//
//                }
//            }
//
//        return view('adm.factories_price_form',['factory'=>$factory,'log'=>$log,'field'=>$request_field]);
//
//    }
//
//    public function price_submit2(Request $request, Factory $factory)
//    {
//        $path = $request->file('xlsx_file')->getRealPath();
////dd($path);
//        $reader = ReaderEntityFactory::createXLSXReader();
//        $reader->open($path);
//
////        $xlsx = SimpleXLSX::parse($path);
//
//        foreach ($reader->getSheetIterator() as $sheet) {
//            foreach ($sheet->getRowIterator() as $row) {
//                // do stuff with the row
//                $cells = $row->getCells();
////                echo '<pre>';
//                $label = trim($cells[0]);
//                $price = trim($cells[1]);
//// echo "$label => $price";
//
////            $request->field  == 'factory_name' или 'artikul'
//                $result =  Product::
//                where($request->field,$label)
//                    ->where('factory_id',$factory->id)
//                    ->update(['price'=>$price]);
//
//               $log[] = compact('label','price','result');
//            }
//        }
//
//        $reader->close();
//
//        return view('adm.factories_price_form',['factory'=>$factory,'log'=>$log,'field'=>$request->field]);
//
//    }
//
//
//    public function price_submit_test(Request $request, Factory $factory)
//    {
//        $path = 'tmp/avalon.xlsx';
//        $reader = ReaderEntityFactory::createXLSXReader();
//        $reader->open($path);
//
//        $sqls = '';
//
//        foreach ($reader->getSheetIterator() as $sheet) {
//            foreach ($sheet->getRowIterator() as $row) {
//                // do stuff with the row
//                $cells = $row->getCells();
////                echo '<pre>';
//                $label = trim($cells[0]);
//                $price = trim($cells[1]);
//if ($label=='') continue;
//
//                $field = 'artikul';
//                $factory_id = 248;
////                $result =  Product::
////                where('artikul',$label)
////                    ->where('factory_id',248)
////                    ->update(['price'=>$price]);
//
//                $sqls .= "UPDATE products SET price=$price
//        WHERE factory_id=$factory_id AND $field='$label';\n ";
//
////                $log[] = compact('label','price',1);
//            }
//        }
//
//        $reader->close();
//
//        $affected_rows = DB::unprepared($sqls);
//        print_r($affected_rows);
//
////        $count = \Illuminate\Database\Connection::affectingStatement;
////        print_r($count);
////        echo($sqls);
//
//
//        return '=='; //view('adm.factories_price_form',['factory'=>$factory,'log'=>$log,'field'=>$request->field]);
//
//    }
//

    public function actions_form(Factory $factory)
    {

        return view('adm.factories_action_form',[ 'factory'=>$factory]);

    }

    public function actions_submit(Request $request, Factory $factory)
    {

        if($request->action=='set_zero_price'){

            Product::where('factory_id',$factory->id)->update(['price'=>0]);
            Session::flash('flash_message', "Установлены нулевые цены для фабрики: $factory->factory");

        }
        elseif($request->action=='set_price_margin'){
$margin = (float) $request->margin;

            Product::where('factory_id',$factory->id)->update(['price'=>DB::raw("CEILING(price*$margin/10)*10")]);
            Session::flash('flash_message', "Обновлены цены для фабрики: $factory->factory");

        }
        elseif($request->action=='set_status_1'){

            Product::where('factory_id',$factory->id)->update(['status_id'=>1]);
            Session::flash('flash_message', "Статус &laquo;Не проверено&raquo; установлен для всех товаров фабрики: $factory->factory");

        }
        elseif($request->action=='set_status_2'){

            Product::where('factory_id',$factory->id)->update(['status_id'=>2]);
            Session::flash('flash_message', "Статус &laquo;Проверено&raquo; установлен для всех товаров фабрики: $factory->factory");

        }
        elseif($request->action=='set_status_3'){

            Product::where('factory_id',$factory->id)->update(['status_id'=>3]);
            Session::flash('flash_message', "Статус &laquo;Недочеты&raquo; установлен для всех товаров фабрики: $factory->factory");

        }elseif($request->action=='set_status_4'){

        Product::where('factory_id',$factory->id)->update(['status_id'=>4]);
        Session::flash('flash_message', "Статус &laquo;Скрыто&raquo; установлен для всех товаров фабрики:  $factory->factory");

        }



        return redirect()->route('adm.factories.index');

    }

}
