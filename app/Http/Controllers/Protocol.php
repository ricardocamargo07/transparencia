<?php

namespace App\Http\Controllers;

use App\Support\Encodable;
use Illuminate\Http\Request;
use App\Protocol as ProtocolModel;

class Protocol extends Controller
{
    use Encodable;

    public function index()
    {
        return view('protocol.index');
    }

    public function show(Request $request, ProtocolModel $protocol)
    {
        if (! $result = $protocol->findByProtocol($request->get('protocol')))
        {
            return redirect()->back()->withErrors('Este número de protocolo não existe.');
        }

        $result['created_at'] = $result['created_at']->format('d/m/Y');

        return view('protocol.show', ['protocol' => $result]);
    }
}
