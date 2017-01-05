<?php

namespace App\Http\Controllers;

use App\Section as SectionModel;
use App\Report as ReportModel;

class Sections extends Controller
{
    public function section($id)
    {
        $section = SectionModel::findById($id);

        return view('home.section', compact('section'));
    }

    public function report($id)
    {
        $report = ReportModel::findById($id);

        return view('home.report', compact('report'));
    }
}
