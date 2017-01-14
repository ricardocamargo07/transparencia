<?php

namespace App\Http\Controllers;

use App\AlerjArquivo;
use App\AlerjCategoria;
use App\AlerjConteudo;
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
        return $this->find($id, AlerjConteudo::class, null, true, 'protocolo');
    }

    public function find($id, $class, $relations = null, $returnResponse = true, $keyName = null)
    {
        $query = ($object = new $class)->newQuery();

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

        return $query->get();
    }

    public function response($data)
    {
        return response()
                ->json(
                    array_utf8_encode($data->toArray())
                );
    }
}