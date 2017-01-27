<?php

Route::get('/', ['as' => 'home', 'uses' => 'Home@index']);

Route::get('/section/{id}', ['as' => 'section', 'uses' => 'Home@data']);

Route::get('/section/report/{id}', ['as' => 'report', 'uses' => 'Home@item']);

Route::get('/cache/clear/{key?}', ['as' => 'cache.clear', 'uses' => 'Cache@clear']);

Route::get('/protocolo', ['as' => 'protocol', 'uses' => 'Protocol@index']);
Route::post('/protocolo', ['as' => 'protocol.show', 'uses' => 'Protocol@show']);

Route::get('/categoria', function () {

    $data = DB::connection('alerj')->table('tb_informacao')->where('idInformacao', 71)->get();

    dd($data);

});
