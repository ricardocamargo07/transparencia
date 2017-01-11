<?php

use App\Section;
use App\User;

Route::get('/', function () {
    $sections = Section::all();

    return view('home.index')->with('sections', $sections);
});

Route::get('/section/{id}', ['as' => 'section', 'uses' => 'Sections@section']);

Route::get('/section/report/{id}', ['as' => 'report', 'uses' => 'Sections@report']);

Route::get('/cache/clear/{key?}', ['as' => 'cache.clear', 'uses' => 'Cache@clear']);

Route::get('/gettype', function () {
    $remates = new User();

    return (string)(gettype($remates) != 'NULL');
});

