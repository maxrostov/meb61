<?php

namespace App\Providers;

use App\Category;
use App\Text;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @re/_tmp
    turn void
     */
    public function boot()
    {
$main_categories = Category::with('children')->has('children')
->where('parent_id',0)->where('is_hidden',NULL)->get();

View::share('main_categories', $main_categories);


        $footer_middle = Text::find(9);
        View::share('footer_middle', $footer_middle);

        $footer_right = Text::find(10);
        View::share('footer_right', $footer_right);


        $header_desktop = Text::find(11);
        View::share('header_desktop', $header_desktop);

        $header_mobile = Text::find(12);
        View::share('header_mobile', $header_mobile);



        DB::enableQueryLog(); // Enable query log


//        Paginator::defaultView('vendor/pagination/semantic-ui');
        Paginator::defaultView('vendor/pagination/bulma');



//        Log::listen(function($level, $message, $context)
//        {
////           file_put_contents('__max.log',$message);
//        });



    }
}
