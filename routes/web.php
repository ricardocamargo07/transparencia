<?php

use App\Section;

Route::get('/', function () {
    $sections = Section::all();

    return view('home.index')->with('sections', $sections);
});

Route::get('/section/{id}', ['as' => 'section', 'uses' => 'Sections@section']);

Route::get('/section/report/{id}', ['as' => 'report', 'uses' => 'Sections@report']);
