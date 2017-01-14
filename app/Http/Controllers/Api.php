<?php

namespace App\Http\Controllers;

use App\AlerjArquivo;
use App\AlerjCategoria;
use App\AlerjInformacao;

class Api extends Controller
{
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

    public function find($id, $class, $relations = null, $returnResponse = true)
    {
        $query = ($object = new $class)->newQuery();

        if ($relations) {
            $query->with($relations);
        }

        if ($id) {
            $query->where($object->getKeyName(), $id);
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
