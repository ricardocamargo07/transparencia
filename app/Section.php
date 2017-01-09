<?php

namespace App;

class Section
{
    private $sections;

    public function __construct()
    {
        $this->webservice = app(Webservice::class);

        $this->loadSections();
    }

    public static function all()
    {
        return (new static())->getSections();
    }

    public static function findBySlug($slug)
    {
        return static::all()->where('slug', $slug);
    }

    public static function findById($slug)
    {
        return static::all()->where('id', $slug)->first();
    }

    private function getSections()
    {
        return $this->sections;
    }

    private function loadFromWebService($item)
    {
//        $section = $this->sections[2];

//        $section['title'] = 'DO WEBSERVICE';

//        return $section;
        return $this->webservice->getSection($item['slug']);
    }

    private function loadSections()
    {
        $this->populateInternalSections();

        $this->sections = collect($this->sections);

        $this->sections = $this->sections->map(function($item) {
            if (isset($item['webservice'])) {
                return $this->loadFromWebService($item);
            }

            return $this->populate($item);
        });

        return $this->sections;
    }

    private function populate($item)
    {
        foreach ($item['links'] as $key => $link) {
            list($command, $name) = explode(':', $link['link']);

            if ($command == 'route') {
                $item['links'][$key]['link'] = route($name, [$item['links'][$key]['id']]);
            }
        }

        return $item;
    }

    private function populateInternalSections()
    {
        $id = 1000000001;

        $this->sections = [
            1 => [
                'id' => 'section-'.$id++,
                'title' => 'PERGUNTAS FREQUENTES',
                'slug' => 'faq',
                'icon' => 'images/icons/perguntas-frequentes.svg',
                'links' => [
                    [
                        'id' => 'report-'.$id++,
                        'title' => 'Perguntas e Respostas - FAQ',
                        'slug' => 'faq',
                        'link' => 'route:report',
                    ],
                    [
                        'id' => 'report-'.$id++,
                        'title' => 'Como acompanhar o seu pedido?',
                        'slug' => 'pedido',
                        'link' => 'route:report',
                    ],
                    [
                        'id' => 'report-'.$id++,
                        'title' => 'Ato da Alerj',
                        'slug' => 'ato',
                        'link' => 'route:report',
                    ],
                    [
                        'id' => 'report-'.$id++,
                        'title' => 'A lei na íntegra',
                        'slug' => 'lei',
                        'link' => 'route:report',
                    ],
                    [
                        'id' => 'report-'.$id++,
                        'title' => 'Mapa da lei',
                        'slug' => 'mapa',
                        'link' => 'route:report',
                    ],
                    [
                        'id' => 'report-'.$id++,
                        'title' => 'Quais as exceções',
                        'slug' => 'excecoes',
                        'link' => 'route:report',
                    ],
                ]
            ],

            2 => [
                'id' => 'section-'.$id++,
                'title' => 'DEPUTADOS',
                'slug' => 'deputados',
                'icon' => '/images/icons/deputados.svg',
                'links' => [
                    [
                        'id' => 'report-'.$id++,
                        'title' => 'Salário',
                        'body' => '<div class="graficos-desc">
                            <p>Os salários dos deputados estaduais são limitados a 75% dos salários dos deputados federais, conforme determina o artigo 27 da <a href="https://www.planalto.gov.br/ccivil_03/constituicao/constituicao.htm" target="_blank"> Constituição Federal</a>. Atualmente, o valor bruto é de R$ 25.322,25.
                            </p>
                        </div>
                        <div class="row tabelas">

                                <div id="rates">
                                    <!--<div class="row head">-->
                                        <!--<div class="col-xs-12 text-center">-->
                                            <!--<h3>Salários dos deputados</h3>-->
                                        <!--</div>-->
                                    <!--</div>-->
                                    <div class="row">
                                        <div class="col-xs-3 col-sm-8">
                                            <div class="item">Bruto</div>
                                        </div>
                                        <div class="col-xs-3 col-sm-4 text-right">
                                            <div class="item">R$  25.322,25</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-3 col-sm-8">
                                            <div class="item">Previdência</div>
                                        </div>
                                        <div class="col-xs-3 col-sm-4 text-right">
                                            <div class="item">R$ 	513,01</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-3 col-sm-8">
                                            <div class="item">IR</div>
                                        </div>
                                        <div class="col-xs-3 col-sm-4 text-right">
                                            <div class="item">R$ 	5.996,39</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-3 col-sm-8">
                                            <div class="item">Líquido</div>
                                        </div>
                                        <div class="col-xs-3 col-sm-4 text-right">
                                            <div class="item">R$ 	18.812,85</div>
                                        </div>
                                    </div>
                                </div>
                        </div>',
                        'slug' => 'salario',
                        'link' => 'route:report',
                    ],
                    [
                        'id' => 'report-'.$id++,
                        'title' => 'Benefícios',
                        'body' => '<div class="graficos-desc">
                            <p>Diferentemente de parlamentares de outros parlamentos estaduais, os deputados fluminenses não recebem uma série de benefícios como auxílio-educação, verba de gabinete, jeton por sessão extraordinária,  auxílio-paletó nem têm aposentadoria especial. Também não têm plano de saúde ou auxílio-doença. Os parlamentares que residem a mais de 150 km da capital têm direito ao auxílio-moradia, no valor bruto de R$ 3.189,85.</p>
                            <p>Em novembro de 2016, em meio à calamidade financeira do Rio, foram tomadas outras medidas: extinção da cota de mil selos/mês por gabinete; fim de solenidades fora do horário de expediente e proibição de a Alerj pagar por buffets. A Casa também decidiu não vai mais renovar a frota de carros oficiais: a partir de dezembro de 2018, a Alerj será a primeira assembleia do Brasil cujos deputados não terão mais direito a carro oficial. Os cortes vão gerar economia de R$ 30 milhões/ano, mas, mais do que a economia, trata-se de um gesto de austeridade que a Alerj acredita que deveria ser estendida aos outros Poderes.</p>
                        </div>
                        <div class="row tabelas">

                                <div id="rates">
                                    <!--<div class="row head">-->
                                        <!--<div class="col-xs-12 text-center">-->
                                            <!--<h3>Salários dos deputados</h3>-->
                                        <!--</div>-->
                                    <!--</div>-->
                                    <div class="row">
                                        <div class="col-xs-3 col-sm-4">
                                            <div class="item">Auxílio-moradia</div>
                                        </div>
                                        <div class="col-xs-3 col-sm-8">
                                            <div class="item">R$ 3.189,85/mês – só para quem mora a mais de 150 Km de distância da capital</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-3 col-sm-4">
                                            <div class="item">Carro oficial</div>
                                        </div>
                                        <div class="col-xs-3 col-sm-8">
                                            <div class="item">02 por deputado – fim da frota prevista para dezembro de 2018</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-3 col-sm-4">
                                            <div class="item">Cota	de combustível</div>
                                        </div>
                                        <div class="col-xs-3 col-sm-8">
                                            <div class="item">R$ 1.250/mês</div>
                                        </div>
                                    </div>
                                </div>
                        </div>',
                        'slug' => 'beneficios',
                        'link' => 'route:report',
                    ],
                    [
                        'id' => 'report-'.$id++,
                        'title' => 'Lista de Presença',
                        'slug' => 'lista-presenca',
                        'link' => 'route:report',
                    ],
                    [
                        'id' => 'report-'.$id++,
                        'title' => 'Folha de pagamento',
                        'slug' => 'folha-pagamento',
                        'link' => 'route:report',
                    ],
                ]
            ],

            3 => [
                'id' => 'section-'.$id++,
                'title' => 'VIAGENS AUTORIZADAS',
                'slug' => 'viagens-autorizadas',
                'icon' => '/images/icons/viagens-autorizadas.svg',
                'links' => [
                    [
                        'id' => 'report-'.$id++,
                        'title' => 'Deputados',
                        'slug' => 'deputados',
                        'link' => 'route:report',
                    ],
                    [
                        'id' => 'report-'.$id++,
                        'title' => 'Funcionários',
                        'slug' => 'funcionarios',
                        'link' => 'route:report',
                    ],
                ]
            ],

            4 => [
                'id' => 'section-'.$id++,
                'title' => 'BOLSA REFORÇO ESCOLAR',
                'slug' => 'bolsa-reforco-escolar',
                'icon' => '/images/icons/bolsa-reforco-escolar.svg',
                'links' => [
                    [
                        'id' => 'report-'.$id++,
                        'title' => 'Geral',
                        'slug' => 'geral',
                        'link' => 'route:report',
                    ],
                    [
                        'id' => 'report-'.$id++,
                        'title' => 'Na Administração',
                        'slug' => 'administracao',
                        'link' => 'route:report',
                    ],
                    [
                        'id' => 'report-'.$id++,
                        'title' => 'Nos gabinetes',
                        'slug' => 'gabinetes',
                        'link' => 'route:report',
                    ],
                    [
                        'id' => 'report-'.$id++,
                        'title' => 'Nas Lideranças',
                        'slug' => 'liderancas',
                        'link' => 'route:report',
                    ],
                ]
            ],

            5 => [
                'id' => 'section-'.$id++,
                'title' => 'FUNCIONÁRIOS',
                'slug' => 'funcionarios',
                'icon' => '/images/icons/funcionarios.svg',
                'links' => [
                    [
                        'id' => 'report-'.$id++,
                        'title' => 'Tabela de Vencimentos',
                        'body' => '
 <div class="row tabelas">

                                <div id="rates">
                                    <div class="row head">
                                        <div class="col-xs-12 text-center">
                                            <h3>Quadro Remuneratório</h3>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-2 col-sm-2">
                                            <div class="item">Cargo</div>
                                        </div>
                                        <div class="col-xs-2 col-sm-2">
                                            <div class="item">Nível</div>
                                        </div>
                                        <div class="col-xs-2 col-sm-2">
                                            <div class="item">Bruto</div>
                                        </div>
                                        <div class="col-xs-2 col-sm-2">
                                            <div class="item">Previdência</div>
                                        </div>                                        
                                        <div class="col-xs-2 col-sm-2">
                                            <div class="item">IR</div>
                                        </div>
                                        <div class="col-xs-2 col-sm-2">
                                            <div class="item">Líquido</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-2 col-sm-2">
                                            <div class="item">Especialista Legislativo</div>
                                        </div>
                                        <div class="col-xs-2 col-sm-2">
                                            <div class="item">1.000</div>
                                        </div>
                                        <div class="col-xs-2 col-sm-2">
                                            <div class="item">R$ 5.546,19</div>
                                        </div>
                                        <div class="col-xs-2 col-sm-2">
                                            <div class="item">R$ 610,08</div>
                                        </div>                                        
                                        <div class="col-xs-2 col-sm-2">
                                            <div class="item">R$ 531,28 </div>
                                        </div>
                                        <div class="col-xs-2 col-sm-2">
                                            <div class="item">R$ 4.404,83</div>
                                        </div>
                                    </div>       
                                    <div class="row">
                                        <div class="col-xs-2 col-sm-2">
                                            <div class="item">Especialista Legislativo</div>
                                        </div>
                                        <div class="col-xs-2 col-sm-2">
                                            <div class="item">1.100</div>
                                        </div>
                                        <div class="col-xs-2 col-sm-2">
                                            <div class="item">R$ 5.750,00</div>
                                        </div>
                                        <div class="col-xs-2 col-sm-2">
                                            <div class="item">R$ 632,50</div>
                                        </div>                                        
                                        <div class="col-xs-2 col-sm-2">
                                            <div class="item">R$ 581,16</div>
                                        </div>
                                        <div class="col-xs-2 col-sm-2">
                                            <div class="item">R$ 4.536,34</div>
                                        </div>
                                    </div>                                                                       
                                    
                                    
                                    
                                    
                                </div>
                        </div>

<div class="panel-group accordion" id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading1">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                            2016
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading1">
                                    <div class="panel-body">
                                        <div class="row linha-mes"> <div class="col-md-offset-3 col-md-3 mes-label" >Janeiro  </div>      <div class="col-md-3"><i class="btn fa fa-file-pdf-o" aria-hidden="true"> <span class="label-dowload-tipo">pdf </span></i> <i class="btn fa fa-file-excel-o" aria-hidden="true"> <span class="label-dowload-tipo">excel</span></i></a></div></div>
                                        <div class="row linha-mes"> <div class="col-md-offset-3 col-md-3 mes-label" >Fevereiro  </div>    <div class="col-md-3"><i class="btn fa fa-file-pdf-o" aria-hidden="true"> <span class="label-dowload-tipo">pdf </span></i> <i class="btn fa fa-file-excel-o" aria-hidden="true"> <span class="label-dowload-tipo">excel</span></i></a></div></div>
                                        <div class="row linha-mes"> <div class="col-md-offset-3 col-md-3 mes-label" >Março  </div>        <div class="col-md-3"><i class="btn fa fa-file-pdf-o" aria-hidden="true"> <span class="label-dowload-tipo">pdf </span></i> <i class="btn fa fa-file-excel-o" aria-hidden="true"> <span class="label-dowload-tipo">excel</span></i></a></div></div>
                                        <div class="row linha-mes"> <div class="col-md-offset-3 col-md-3 mes-label" >Abril  </div>        <div class="col-md-3"><i class="btn fa fa-file-pdf-o" aria-hidden="true"> <span class="label-dowload-tipo">pdf </span></i> <i class="btn fa fa-file-excel-o" aria-hidden="true"> <span class="label-dowload-tipo">excel</span></i></a></div></div>
                                        <div class="row linha-mes"> <div class="col-md-offset-3 col-md-3 mes-label" >Maio  </div>         <div class="col-md-3"><i class="btn fa fa-file-pdf-o" aria-hidden="true"> <span class="label-dowload-tipo">pdf </span></i> <i class="btn fa fa-file-excel-o" aria-hidden="true"> <span class="label-dowload-tipo">excel</span></i></a></div></div>
                                        <div class="row linha-mes"> <div class="col-md-offset-3 col-md-3 mes-label" >Junho  </div>        <div class="col-md-3"><i class="btn fa fa-file-pdf-o" aria-hidden="true"> <span class="label-dowload-tipo">pdf </span></i> <i class="btn fa fa-file-excel-o" aria-hidden="true"> <span class="label-dowload-tipo">excel</span></i></a></div></div>
                                        <div class="row linha-mes"> <div class="col-md-offset-3 col-md-3 mes-label" >Julho  </div>        <div class="col-md-3"><i class="btn fa fa-file-pdf-o" aria-hidden="true"> <span class="label-dowload-tipo">pdf </span></i> <i class="btn fa fa-file-excel-o" aria-hidden="true"> <span class="label-dowload-tipo">excel</span></i></a></div></div>
                                        <div class="row linha-mes"> <div class="col-md-offset-3 col-md-3 mes-label" >Agosto  </div>       <div class="col-md-3"><i class="btn fa fa-file-pdf-o" aria-hidden="true"> <span class="label-dowload-tipo">pdf </span></i> <i class="btn fa fa-file-excel-o" aria-hidden="true"> <span class="label-dowload-tipo">excel</span></i></a></div></div>
                                        <div class="row linha-mes"> <div class="col-md-offset-3 col-md-3 mes-label" >Setembro  </div>     <div class="col-md-3"><i class="btn fa fa-file-pdf-o" aria-hidden="true"> <span class="label-dowload-tipo">pdf </span></i> <i class="btn fa fa-file-excel-o" aria-hidden="true"> <span class="label-dowload-tipo">excel</span></i></a></div></div>
                                        <div class="row linha-mes"> <div class="col-md-offset-3 col-md-3 mes-label" >Novembro  </div>     <div class="col-md-3"><i class="btn fa fa-file-pdf-o" aria-hidden="true"> <span class="label-dowload-tipo">pdf </span></i> <i class="btn fa fa-file-excel-o" aria-hidden="true"> <span class="label-dowload-tipo">excel</span></i></a></div></div>
                                        <div class="row linha-mes"> <div class="col-md-offset-3 col-md-3 mes-label" >Dezembro </div>      <div class="col-md-3"><i class="btn fa fa-file-pdf-o" aria-hidden="true"> <span class="label-dowload-tipo">pdf </span></i> <i class="btn fa fa-file-excel-o" aria-hidden="true"> <span class="label-dowload-tipo">excel</span></i></a></div></div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading2">
                                    <h4 class="panel-title">
                                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                            2015
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading2">
                                    <div class="panel-body">
                                            <div class="row linha-mes"> <div class="col-md-offset-3 col-md-3 mes-label" >Janeiro  </div>      <div class="col-md-3"><i class="btn fa fa-file-pdf-o" aria-hidden="true"> <span class="label-dowload-tipo">pdf </span></i> <i class="btn fa fa-file-excel-o" aria-hidden="true"> <span class="label-dowload-tipo">excel</span></i></a></div></div>
                                            <div class="row linha-mes"> <div class="col-md-offset-3 col-md-3 mes-label" >Fevereiro  </div>    <div class="col-md-3"><i class="btn fa fa-file-pdf-o" aria-hidden="true"> <span class="label-dowload-tipo">pdf </span></i> <i class="btn fa fa-file-excel-o" aria-hidden="true"> <span class="label-dowload-tipo">excel</span></i></a></div></div>
                                            <div class="row linha-mes"> <div class="col-md-offset-3 col-md-3 mes-label" >Março  </div>        <div class="col-md-3"><i class="btn fa fa-file-pdf-o" aria-hidden="true"> <span class="label-dowload-tipo">pdf </span></i> <i class="btn fa fa-file-excel-o" aria-hidden="true"> <span class="label-dowload-tipo">excel</span></i></a></div></div>
                                            <div class="row linha-mes"> <div class="col-md-offset-3 col-md-3 mes-label" >Abril  </div>        <div class="col-md-3"><i class="btn fa fa-file-pdf-o" aria-hidden="true"> <span class="label-dowload-tipo">pdf </span></i> <i class="btn fa fa-file-excel-o" aria-hidden="true"> <span class="label-dowload-tipo">excel</span></i></a></div></div>
                                            <div class="row linha-mes"> <div class="col-md-offset-3 col-md-3 mes-label" >Maio  </div>         <div class="col-md-3"><i class="btn fa fa-file-pdf-o" aria-hidden="true"> <span class="label-dowload-tipo">pdf </span></i> <i class="btn fa fa-file-excel-o" aria-hidden="true"> <span class="label-dowload-tipo">excel</span></i></a></div></div>
                                            <div class="row linha-mes"> <div class="col-md-offset-3 col-md-3 mes-label" >Junho  </div>        <div class="col-md-3"><i class="btn fa fa-file-pdf-o" aria-hidden="true"> <span class="label-dowload-tipo">pdf </span></i> <i class="btn fa fa-file-excel-o" aria-hidden="true"> <span class="label-dowload-tipo">excel</span></i></a></div></div>
                                            <div class="row linha-mes"> <div class="col-md-offset-3 col-md-3 mes-label" >Julho  </div>        <div class="col-md-3"><i class="btn fa fa-file-pdf-o" aria-hidden="true"> <span class="label-dowload-tipo">pdf </span></i> <i class="btn fa fa-file-excel-o" aria-hidden="true"> <span class="label-dowload-tipo">excel</span></i></a></div></div>
                                            <div class="row linha-mes"> <div class="col-md-offset-3 col-md-3 mes-label" >Agosto  </div>       <div class="col-md-3"><i class="btn fa fa-file-pdf-o" aria-hidden="true"> <span class="label-dowload-tipo">pdf </span></i> <i class="btn fa fa-file-excel-o" aria-hidden="true"> <span class="label-dowload-tipo">excel</span></i></a></div></div>
                                            <div class="row linha-mes"> <div class="col-md-offset-3 col-md-3 mes-label" >Setembro  </div>     <div class="col-md-3"><i class="btn fa fa-file-pdf-o" aria-hidden="true"> <span class="label-dowload-tipo">pdf </span></i> <i class="btn fa fa-file-excel-o" aria-hidden="true"> <span class="label-dowload-tipo">excel</span></i></a></div></div>
                                            <div class="row linha-mes"> <div class="col-md-offset-3 col-md-3 mes-label" >Novembro  </div>     <div class="col-md-3"><i class="btn fa fa-file-pdf-o" aria-hidden="true"> <span class="label-dowload-tipo">pdf </span></i> <i class="btn fa fa-file-excel-o" aria-hidden="true"> <span class="label-dowload-tipo">excel</span></i></a></div></div>
                                            <div class="row linha-mes"> <div class="col-md-offset-3 col-md-3 mes-label" >Dezembro </div>      <div class="col-md-3"><i class="btn fa fa-file-pdf-o" aria-hidden="true"> <span class="label-dowload-tipo">pdf </span></i> <i class="btn fa fa-file-excel-o" aria-hidden="true"> <span class="label-dowload-tipo">excel</span></i></a></div></div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading3">
                                    <h4 class="panel-title">
                                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                            2014
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading3">
                                    <div class="panel-body">
                                        <div class="row linha-quadrimestre"> <div class="col-md-offset-2 col-md-4 quad-label" >1º Quadrimestre<br><span class="quadrimeste">( jan-fev-mar-abr )</span>  </div>     <div class="col-md-4"><i class="btn fa fa-file-pdf-o" aria-hidden="true"> <span class="label-dowload-tipo">pdf </span></i> <i class="btn fa fa-file-excel-o" aria-hidden="true"> <span class="label-dowload-tipo">excel</span></i></a></div></div>
                                        <div class="row linha-quadrimestre"> <div class="col-md-offset-2 col-md-4 quad-label" >2º Quadrimestre<br><span class="quadrimeste">( mai-jun-jul-ago )</span>  </div>     <div class="col-md-4"><i class="btn fa fa-file-pdf-o" aria-hidden="true"> <span class="label-dowload-tipo">pdf </span></i> <i class="btn fa fa-file-excel-o" aria-hidden="true"> <span class="label-dowload-tipo">excel</span></i></a></div></div>
                                        <div class="row linha-quadrimestre"> <div class="col-md-offset-2 col-md-4 quad-label" >3º Quadrimestre<br><span class="quadrimeste">( set-out-nov-dez )</span> </div>      <div class="col-md-4"><i class="btn fa fa-file-pdf-o" aria-hidden="true"> <span class="label-dowload-tipo">pdf </span></i> <i class="btn fa fa-file-excel-o" aria-hidden="true"> <span class="label-dowload-tipo">excel</span></i></a></div></div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading4">
                                    <h4 class="panel-title">
                                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                            2013
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading4">
                                    <div class="panel-body">
                                        <p>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR></p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading5">
                                    <h4 class="panel-title">
                                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse5" aria-expanded="false" aria-controls="collapse5">
                                            2012
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse5" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading5">
                                    <div class="panel-body">
                                        <p>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR></p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading6">
                                    <h4 class="panel-title">
                                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse6" aria-expanded="false" aria-controls="collapse6">
                                            2011
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse6" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading6">
                                    <div class="panel-body">
                                        <p>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR></p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading7">
                                    <h4 class="panel-title">
                                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse7" aria-expanded="false" aria-controls="collapse7">
                                            2010
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse7" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading7">
                                    <div class="panel-body">
                                        <p>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR></p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading8">
                                    <h4 class="panel-title">
                                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse8" aria-expanded="false" aria-controls="collapse8">
                                            2009
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse8" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading8">
                                    <div class="panel-body">
                                        <p>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR></p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading9">
                                    <h4 class="panel-title">
                                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse9" aria-expanded="false" aria-controls="collapse9">
                                            2008
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse9" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading9">
                                    <div class="panel-body">
                                        <p>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR></p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading10">
                                    <h4 class="panel-title">
                                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse10" aria-expanded="false" aria-controls="collapse10">
                                            2007
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse10" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading10">
                                    <div class="panel-body">
                                        <p>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR></p>
                                    </div>
                                </div>
                            </div>
                        </div>',
                        'slug' => 'tabela-de-vencimentos',
                        'link' => 'route:report',
                    ],
                    [
                        'id' => 'report-'.$id++,
                        'title' => 'Tabela de Benefícios',
                        'body' => '<div class="graficos-desc">
                        </div>
                        <div class="row tabelas">

                                <div id="rates">
                                    <!--<div class="row head">-->
                                        <!--<div class="col-xs-12 text-center">-->
                                            <!--<h3>Salários dos deputados</h3>-->
                                        <!--</div>-->
                                    <!--</div>-->
                                    <div class="row">
                                        <div class="col-xs-3 col-sm-6 text-center">
                                            <div class="item">Alimentação</div>
                                        </div>
                                        <div class="col-xs-3 col-sm-6">
                                            <div class="item">R$ 40 por dia dia útil trabalhado.</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-3 col-sm-6 text-center">
                                            <div class="item">Bolsa de reforço escolar para até 2 dependentes por funcionário</div>
                                        </div>
                                        <div class="col-xs-3 col-sm-6">
                                            <div class="item">R$ 1.052 cada bolsa</div>
                                        </div>
                                    </div>
                                </div>
                        </div>',
                        'slug' => 'tabela-de-beneficios',
                        'link' => 'route:report',
                    ],
                    [
                        'id' => 'report-'.$id++,
                        'title' => 'Folha de Pagamento',
                        'slug' => 'folha-de-pagamento',
                        'link' => 'route:report',
                    ],
                ]
            ],

            6 => [
                'id' => 'section-'.$id++,
                'title' => 'ESTAGIÁRIOS',
                'slug' => 'estagiarios',
                'icon' => '/images/icons/estagiarios.svg',
                'links' => [
                    [
                        'id' => 'report-'.$id++,
                        'title' => 'Nível médio',
                        'slug' => 'nivel-medio',
                        'link' => 'route:report',
                    ],
                    [
                        'id' => 'report-'.$id++,
                        'title' => 'Nível superior',
                        'slug' => 'nivel-superior',
                        'link' => 'route:report',
                    ],
                ]
            ],


            7 => [
                'id' => 'section-'.$id++,
                'title' => 'ORÇAMENTO E FINANÇAS',
                'slug' => 'orcamento-e-financa',
                'icon' => '/images/icons/orcamento-e-financas.svg',
                'links' => [
                    [
                        'id' => 'report-'.$id++,
                        'title' => 'Relatório de Gestão Fiscal',
                        'slug' => 'relatorio-de-gestao-Fiscal',
                        'link' => 'route:report',
                    ],
                    [
                        'id' => 'report-'.$id++,
                        'title' => 'Gastos do Poder Legislativo',
                        'slug' => 'gastos-do-poder-Legislativo',
                        'link' => 'route:report',
                    ],
                ]
            ],

            8 => [
                'id' => 'section-'.$id++,
                'title' => 'TRANSPARÊNCIA NO RIO DE JANEIRO',
                'slug' => 'transparenciaRJ',
                'icon' => '/images/icons/transparencia-no-rj.svg',
                'links' => [
                    [
                        'id' => 'report-'.$id++,
                        'title' => 'Executivo',
                        'slug' => 'executivo',
                        'link' => 'route:report',
                    ],
                    [
                        'id' => 'report-'.$id++,
                        'title' => 'Judiciario',
                        'slug' => 'judiciario',
                        'link' => 'route:report',
                    ],
                    [
                        'id' => 'report-'.$id++,
                        'title' => 'Ministerio Publico',
                        'slug' => 'ministerio-publico',
                        'link' => 'route:report',
                    ],
                    [
                        'id' => 'report-'.$id++,
                        'title' => 'TCE',
                        'slug' => 'tce',
                        'link' => 'route:report',
                    ],
                    [
                        'id' => 'report-'.$id++,
                        'title' => 'Junta Comercial',
                        'slug' => 'junta-comercial',
                        'link' => 'route:report',
                    ],
                ]
            ],

            9 => [
                'id' => 'section-'.$id++,
                'title' => 'DIÁRIO OFICIAL',
                'slug' => 'diario-oficial',
                'icon' => '/images/icons/diario-oficial.svg',
                'links' => [
                    [
                        'id' => 'report-'.$id++,
                        'title' => 'Poder Legislativo',
                        'slug' => 'poder-legislativo',
                        'link' => 'route:report',
                    ],
                    [
                        'id' => 'report-'.$id++,
                        'title' => 'D.O. Notícias',
                        'slug' => 'do-noticias',
                        'link' => 'route:report',
                    ],
                    [
                        'id' => 'report-'.$id++,
                        'title' => 'Parte I (Poder Executivo)',
                        'slug' => 'poder-executivo',
                        'link' => 'route:report',
                    ],
                    [
                        'id' => 'report-'.$id++,
                        'title' => 'Parte IA - (Ministério Público)',
                        'slug' => 'ministerio-publico',
                        'link' => 'route:report',
                    ],
                    [
                        'id' => 'report-'.$id++,
                        'title' => 'Parte IB - (Tribunal de Contas)',
                        'slug' => 'tribunal-de-contas',
                        'link' => 'route:report',
                    ],
                ],
            ],

            10 => [
                'webservice' => 'viagens-autorizadas',
                'slug' => 'viagens',
            ],

            11 => [
                'webservice' => 'deputados',
                'slug' => 'deputados',
            ],

            12 => [
                'webservice' => 'licitacoes',
                'slug' => 'licitacoes',
            ],
        ];
    }
}
