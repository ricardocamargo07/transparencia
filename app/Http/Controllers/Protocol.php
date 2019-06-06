<?php

namespace App\Http\Controllers;

use Throwable;
use Exception;
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

    /**
     * @return $this
     */
    private function redirectWrongProtocol()
    {
        return redirect()->back()->withInput()->withErrors('Este número de protocolo não existe.');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    private function sanitizeProtocolNumber(Request $request)
    {
        $protocol = trim($request->get('protocol'));

        if (empty($protocol)) {
            return [null, 'Por favor digite um número de protocolo.'];
        }

        $protocol = preg_replace("/[^0-9\/.]/", "", $protocol);

        if (empty($protocol)) {
            return [null, 'Número de protocolo inválido, por favor digite o número, seguido de uma barra ( / ) e do ano.'];
        }

        if (! str_contains($protocol, '/')) {
            return [null, 'Número de protocolo incorreto, por favor digite o número, seguido de uma barra (/) e do ano.'];
        }

        return [$protocol, ''];
    }

    public function show(Request $request, ProtocolModel $protocol)
    {
        list($number, $message) = $this->sanitizeProtocolNumber($request);

        if (is_null($number)) {
            return redirect()->back()->withInput()->withErrors($message);
        }

        try {
            if (! $result = $protocol->findByProtocol($number)) {
                if (! $result = $protocol->findByGeneralProtocol($number)) {
                    return $this->redirectWrongProtocol();
                }
            }
        } catch (Exception $exception) {
            return $this->redirectWrongProtocol();
        } catch (Throwable $e) {
            return $this->redirectWrongProtocol();
        }

        if (isset($result['created_at'])) {
            $result['created_at'] = $result['created_at']->format('d/m/Y');
        }

        return view('protocol.show', ['protocol' => $result]);
    }
}
