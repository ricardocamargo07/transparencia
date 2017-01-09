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
                            <p>Os salários dos deputados estaduais são limitados a 75% dos salários dos deputados federais, conforme determina o artigo 27 da Constituição Federal. Atualmente, o valor bruto é de R$ 25.322,25.
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
                                        <div class="col-xs-3 col-sm-4">
                                            <div class="item">R$  25.322,25</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-3 col-sm-8">
                                            <div class="item">Previdência</div>
                                        </div>
                                        <div class="col-xs-3 col-sm-4">
                                            <div class="item">R$ 	513,01</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-3 col-sm-8">
                                            <div class="item">IR</div>
                                        </div>
                                        <div class="col-xs-3 col-sm-4">
                                            <div class="item">R$ 	5.996,39</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-3 col-sm-8">
                                            <div class="item">Líquido</div>
                                        </div>
                                        <div class="col-xs-3 col-sm-4">
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
                        'slug' => 'tabela-de-vencimentos',
                        'link' => 'route:report',
                    ],
                    [
                        'id' => 'report-'.$id++,
                        'title' => 'Tabela de Benefícios',
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
