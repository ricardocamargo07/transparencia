<?php

namespace App\Http\Controllers;

use App\Data as DataModel;
use App\Item as ItemModel;

class Home extends Controller
{
    public function index()
    {
        return view('home.index')->with('data', DataModel::all());
    }

    public function data($id)
    {
        $data = DataModel::findById($id);

        return view('home.data', compact('data'));
    }

    public function item($id)
    {
        $item = ItemModel::findById($id);

        return view('home.item', compact('item'));
    }
}
