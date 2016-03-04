<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('/');;
Route::get('crawl', function () {
    return view('crawl');
})->name('crawl');;
Route::get('search', function () {
    return view('search');
})->name('search');;
Route::post('crawl_url', 'CrawlController@initiate')->name('crawl_url');;
Route::get('extract', 'ExtractController@displayUrlList')->name('extract');;
Route::post('process_url', 'ExtractController@processUrl')->name('process_url');;
Route::get('index', 'IndexController@displaySettings')->name('index');;
Route::post('index_preference', 'IndexController@index_preference')->name('index_preference');;
Route::get('create_invertedindex', 'IndexController@create_invertedindex')->name('create_invertedindex');;
//Route::post('search', 'SearchController@search')->name('search');;
Route::get('report', 'ReportController@displayReport')->name('report');;
//Route::post('search_result', 'SearchController@search')->name('search_result');;
Route::post('search_process', 'SearchController@search')->name('search_process');;
Route::get('search_process', 'SearchController@search_result_display')->name('search_process');;