<?php

namespace App\Http\Controllers;

use App\Section as SectionModel;

class Sections extends Controller
{
    public function show($slug)
    {
        $section = SectionModel::findById($slug);

        return view('home.section', compact('section'));
    }
}
