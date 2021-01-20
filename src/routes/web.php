<?php
use Illuminate\Http\Request;


Route::group(['namespace' => 'Dayglor\ZSPay\Http\Controllers'], function(){
	Route::get('contact', 'ZSPayController@index')->name('contact');

	Route::post('contact', 'ZSPayController@send')->name('contact');
});