<?php

Route::get('/alerj/all', ['as' => 'api.alerj.all', 'uses' => 'Api@all']);
Route::get('/alerj/categoria/{id?}', ['as' => 'api.alerj.categoria', 'uses' => 'Api@categoria']);
Route::get('/alerj/informacao/{id?}', ['as' => 'api.alerj.informacao', 'uses' => 'Api@informacao']);
Route::get('/alerj/informacao/{id}/arquivos', ['as' => 'api.alerj.arquivos', 'uses' => 'Api@informacaoArquivos']);
Route::get('/alerj/arquivo/{id?}', ['as' => 'api.alerj.arquivo', 'uses' => 'Api@arquivo']);
Route::get('/alerj/conteudo/{id}', ['as' => 'api.alerj.conteudo', 'uses' => 'Api@conteudo']);
