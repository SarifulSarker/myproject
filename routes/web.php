<?php

use Illuminate\Support\Facades\Route;



Route::group(['namespace' => 'App\Http\Controllers\Front'],function(){
     Route::get('/', 'IndexController@index');
});
