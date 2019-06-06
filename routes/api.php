<?php

use App\AlerjInformacao;

Route::get('/alerj/all', ['as' => 'api.alerj.all', 'uses' => 'Api@all']);
Route::get('/alerj/categoria/{id?}', ['as' => 'api.alerj.categoria', 'uses' => 'Api@categoria']);
Route::get('/alerj/informacao/{id?}', ['as' => 'api.alerj.informacao', 'uses' => 'Api@informacao']);
Route::get('/alerj/informacao/{id}/arquivos', ['as' => 'api.alerj.arquivos', 'uses' => 'Api@informacaoArquivos']);
Route::get('/alerj/arquivo/{id?}', ['as' => 'api.alerj.arquivo', 'uses' => 'Api@arquivo']);
Route::get('/alerj/conteudo/{id}', ['as' => 'api.alerj.conteudo', 'uses' => 'Api@conteudo']);
Route::get('/alerj/conteudo/{id}/arquivos', ['as' => 'api.alerj.conteudo.arquivos', 'uses' => 'Api@conteudoArquivos']);
Route::get('/alerj/protocolo/{year}/{number}', ['as' => 'api.alerj.protocolo', 'uses' => 'Api@protocolo']);

Route::get('/alerj/test', function() {
    dd(AlerjInformacao::where('idInformacao', 71));
});
