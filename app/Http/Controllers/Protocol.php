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
        $protocol = trim($request->get('protocol'));

        if (empty($protocol)) {
            return redirect()->back()->withInput()->withErrors('Por favor digite um número de protocolo.');
        }

        try {
            if (! $result = $protocol->findByProtocol())
            {
                return redirect()->back()->withInput()->withErrors('Este número de protocolo não existe.');
            }
        } catch (\Exception $exception) {
            return redirect()->back()->withInput()->withErrors('Este número de protocolo não existe.');
        }

        $result['created_at'] = $result['created_at']->format('d/m/Y');

        return view('protocol.show', ['protocol' => $result]);
    }
}
