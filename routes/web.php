<?php

use App\Section;

Route::get('/', function () {
    $sections = Section::all();

    return view('home.index')->with('sections', $sections);
});

Route::get('/section/{slug}', ['as' => 'section', 'SectionsController@show']);
