<?php

Route::get('/', ['as' => 'home', 'uses' => 'LinksController@create']);
Route::post('links', 'LinksController@store');
Route::get('{hash}', 'LinksController@processHash');



Route::group(array('prefix' => 'api/v1'), function()
{
    Route::resource('url', 'LinksController');
});
