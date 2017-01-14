<?php

namespace App;

class AlerjInformacao extends Alerj
{
    protected $table = 'tb_informacao';

    protected $primaryKey = 'idInformacao';

    public function arquivos()
    {
        return $this->hasMany(AlerjArquivo::class, 'idInformacao');
    }

    public function categoria()
    {
        return $this->belongsTo(AlerjCategoria::class, 'idCategoria');
    }
}
