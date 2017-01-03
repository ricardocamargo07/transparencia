<?php

namespace App\Http\Controllers;

use App\Section as SectionModel;

class Sections extends Controller
{
    public function show($slug)
    {
        $section = SectionModel::findBySlug($slug);

        return view('partials.section', compact('section'));
    }
}
