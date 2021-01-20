<?php
use Illuminate\Http\Request;


Route::group(['namespace' => 'Dayglor\Z4Money\Http\Controllers'], function(){
	Route::get('contact', 'Z4moneyController@index')->name('contact');

	Route::post('contact', 'Z4moneyController@send')->name('contact');
});