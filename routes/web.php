<?php

use App\AlerjArquivo;
use App\AlerjCategoria;
use App\AlerjConteudo;
use App\AlerjInformacao;
use App\Section;
use App\User;

Route::get('/', ['as' => 'home', 'uses' => 'Home@index']);

Route::get('/section/{id}', ['as' => 'section', 'uses' => 'Home@data']);

Route::get('/section/report/{id}', ['as' => 'report', 'uses' => 'Home@item']);

Route::get('/cache/clear/{key?}', ['as' => 'cache.clear', 'uses' => 'Cache@clear']);

Route::get('/protocolo', ['as' => 'protocol', 'uses' => 'Protocol@index']);
Route::post('/protocolo', ['as' => 'protocol.show', 'uses' => 'Protocol@show']);

Route::get('/categoria', function () {
    dd(
        AlerjCategoria::with('informacoes.arquivos')->take(5)->get()->toArray()
    );
});

