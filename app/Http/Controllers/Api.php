<?php

namespace App\Http\Controllers;

use App\AlerjArquivo;
use App\AlerjConteudo;
use App\AlerjProtocolo;
use App\AlerjCategoria;
use App\AlerjInformacao;
use App\Support\Encodable;

class Api extends Controller
{
    use Encodable;

    public function all()
    {
        return $this->categoria();
    }

    public function categoria($id = null)
    {
        return $this->find($id, AlerjCategoria::class, ['informacoes.categoria']);
    }

    private function findProtocolo($year, $number)
    {
        return AlerjProtocolo::with('arquivos')->where('ano', $year)->where('numero', $number)->first();
    }

    public function informacao($id = null)
    {
        return $this->find($id, AlerjInformacao::class, ['arquivos', 'categoria']);
    }

    public function informacaoArquivos($id)
    {
        $data = $this->find($id, AlerjInformacao::class, 'arquivos', false)->first();

        return $this->response($data->arquivos);
    }

    public function arquivo($id = null)
    {
        return $this->find($id, AlerjArquivo::class);
    }

    public function conteudo($id)
    {
        return $this->find($id, AlerjConteudo::class, ['arquivos'], true, 'protocolo');
    }

    public function conteudoArquivos($id)
    {
        if ($data = $this->find($id, AlerjConteudo::class, 'arquivos', false)->first()) {
            return $this->response($data->arquivos);
        }

        return null;
    }

    public function protocolo($year, $number)
    {
        return $this->findProtocolo($year, $number);
    }

    public function find($id, $class, $relations = null, $returnResponse = true, $keyName = null)
    {
        $object = new $class;

        $query = $object->newQuery();

        $keyName = $keyName ?: $object->getKeyName();

        if ($relations) {
            $query->with($relations);
        }

        if ($id) {
            $query->where($keyName, $this->decode($id));
        }

        $result = $query->get();

        if ($returnResponse) {
            return $this->response($result);
        }

        return $result;
    }

    public function response($data)
    {
        return response()
                ->json(
                    array_utf8_encode($data->toArray())
                );
    }
}

//http://transparencia.antoniocarlosribeiro.com/api/alerj/informacao/71/arquivos
//#http://local.transparencia.com/api/alerj/informacao/71/arquivos
//http://transparencia.dev/section/report/71
