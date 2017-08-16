<?php

namespace App\Http\Controllers;

use Cache;
use App\Data as DataModel;
use App\Item as ItemModel;

class Home extends Controller
{
    public function index()
    {
        $data = Cache::remember('transparencia-home', 10000, function () {
            return DataModel::all();
        });

        return view('home.index')->with('data', $data);
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
