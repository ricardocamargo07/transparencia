<?php

use App\AlertCategoria;
use App\Section;
use App\User;

Route::get('/', ['as' => 'home', 'uses' => 'Home@index']);

Route::get('/section/{id}', ['as' => 'section', 'uses' => 'Home@data']);

Route::get('/section/report/{id}', ['as' => 'report', 'uses' => 'Home@item']);

Route::get('/cache/clear/{key?}', ['as' => 'cache.clear', 'uses' => 'Cache@clear']);

Route::get('/categoria', function () {
    phpinfo();
    AlertCategoria::find('1');
});
