<?php

namespace App;

use App\Data\Scopes\Published;

class AlerjConteudo extends Alerj
{
    protected $table = 'tb_conteudo';

    protected $primaryKey = 'idConteudo';

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new Published());
    }

    public function arquivos()
    {
        return $this->hasMany(AlerjArquivo::class, 'idConteudo');
    }
}
