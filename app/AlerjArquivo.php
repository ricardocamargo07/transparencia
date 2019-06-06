<?php

namespace App;

class AlerjArquivo extends Alerj
{
    protected $table = 'tb_arquivo';

    protected $primaryKey = 'idArquivo';

    protected $hidden = ['blob'];

    public function getUrlAttribute()
    {
        return $this->makeUrl(
            config('app.webservice.urls.file'),
            $this->id
        );
    }
}
