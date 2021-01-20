<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['register' => false]);


Route::get('/sitemap.txt', 'FrontController@sitemap_txt');




Route::get('/', 'FrontController@homepage');
Route::get('/test', 'FrontController@test');

Route::get('/text/{text_id}', 'FrontController@text');

Route::get('/cat/{category_id}', 'FrontController@category');
Route::get('/main/{category_id}', 'FrontController@main_category');

Route::get('/mebel/{product_id}', 'FrontController@product')->name('product');

// add 2 cart submit
Route::post('/mebel/{product_id}', 'CartController@product_add_to_cart')->name('product_add_to_cart');
Route::get('/cart', 'CartController@show_cart')->name('show_cart');
Route::post('/cart', 'CartController@submit_cart')->name('submit_cart');
Route::delete('/cart', 'CartController@delete_cart')->name('delete_cart');
Route::post('/ajax/cart_update', 'CartController@ajax_cart_update')->name('ajax_cart_update');


Route::get('/search', 'FrontController@search')->name('search');


//Route::get('feed', 'HomeController@feed');
//Route::get('myxmebel', 'HomeController@myxmebel');

Route::get('/factory_price_test', 'FactoryController@price_submit_test');


// АДМИНКА
Route::prefix('adm')->name('adm.')->middleware('auth')->group(function () {

    Route::resources([
        'categories' => 'CategoryController',
        'factories' => 'FactoryController',
        'materials' => 'MaterialController',
        'colors' => 'ColorController',
        'products' => 'ProductController',
        'texts' => 'TextController',
        'orders' => 'OrderController',
        'types' => 'TypeController',
        'banners' => 'BannerController',
        'kvalues' => 'KValuesController',
    ]);

    Route::get('searches', 'FrontController@search_log');

    Route::get('errors', 'FrontController@errors_log');


    Route::get('factories/{factory}/actions', 'FactoryController@actions_form')->name('factories.actions_form');
    Route::post('factories/{factory}/actions', 'FactoryController@actions_submit')->name('factories.actions_submit');

    Route::get('factories/{factory}/price', 'FactoryController@price_form')->name('factories.price_form');
//    Route::post('factories/{factory}/price', 'FactoryController@price_submit')->name('factories.price_submit');
    Route::post('factories/{factory}/price', 'FactoryController@price_submit_large')->name('factories.price_submit');

    Route::get('factories/{factory}/csv', 'FactoryController@csv')->name('factories.csv');


    Route::get('values/{type_id}/create', 'TypeController@value_create')->name('values.create');
    Route::post('values/{type_id}/create', 'TypeController@value_store')->name('values.store');

    Route::get('values/{value_id}/edit', 'TypeController@value_edit')->name('values.edit');
    Route::patch('values/{value_id}/edit', 'TypeController@value_update')->name('values.update');
    Route::delete('values/{value_id}/delete', 'TypeController@value_delete')->name('values.delete');



    Route::get('stat', 'ProductController@stat')->name('products.stat');
    Route::get('products_cat/{cat_id}', 'ProductController@products_cat')->name('products_cat');

    Route::get('products/{product_id}/copy', 'ProductController@copy')->name('products.copy');
    Route::get('products/{product_id}/mod', 'ProductController@mod')->name('products.mod');

    Route::post('ajax/detach_category', 'AjaxController@detach_category');
    Route::post('ajax/inline_price_input', 'AjaxController@inline_price_input');
    Route::post('ajax/inline_value', 'AjaxController@inline_value');

});


