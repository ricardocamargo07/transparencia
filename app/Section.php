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
                $item['links'][$key]['link'] = route($name, [$item['links'][$key]['slug']]);
            }
        }

        return $item;
    }

    private function populateInternalSections()
    {
        $id = 1000000001;

        $this->sections = [
//            1 => [
//                'id' => $id++,
//                'title' => 'PERGUNTAS FREQUENTES',
//                'slug' => 'faq',
//                'icon' => 'images/icons/perguntas-frequentes.svg',
//                'links' => [
//                    [
//                        'id' => $id++,
//                        'title' => 'Perguntas e Respostas - FAQ',
//                        'slug' => 'faq',
//                        'link' => 'route:section',
//                    ],
//                    [
//                        'id' => $id++,
//                        'title' => 'Como acompanhar o seu pedido?',
//                        'slug' => 'pedido',
//                        'link' => 'route:section',
//                    ],
//                    [
//                        'id' => $id++,
//                        'title' => 'Ato da Alerj',
//                        'slug' => 'ato',
//                        'link' => 'route:section',
//                    ],
//                    [
//                        'id' => $id++,
//                        'title' => 'A lei na íntegra',
//                        'slug' => 'lei',
//                        'link' => 'route:section',
//                    ],
//                    [
//                        'id' => $id++,
//                        'title' => 'Mapa da lei',
//                        'slug' => 'mapa',
//                        'link' => 'route:section',
//                    ],
//                    [
//                        'id' => $id++,
//                        'title' => 'Quais as exceções',
//                        'slug' => 'excecoes',
//                        'link' => 'route:section',
//                    ],
//                ]
//            ],
//
//            2 => [
//                'id' => $id++,
//                'title' => 'DEPUTADOS',
//                'slug' => 'deputados',
//                'icon' => '/images/icons/deputados.svg',
//                'links' => [
//                    [
//                        'id' => $id++,
//                        'title' => 'Salário',
//                        'slug' => 'salario',
//                        'link' => 'route:section',
//                    ],
//                    [
//                        'id' => $id++,
//                        'title' => 'Benefícios',
//                        'slug' => 'beneficios',
//                        'link' => 'route:section',
//                    ],
//                    [
//                        'id' => $id++,
//                        'title' => 'Lista de Presença',
//                        'slug' => 'lista-presenca',
//                        'link' => 'route:section',
//                    ],
//                    [
//                        'id' => $id++,
//                        'title' => 'Folha de pagamento',
//                        'slug' => 'folha-pagamento',
//                        'link' => 'route:section',
//                    ],
//                ]
//            ],
//
//            3 => [
//                'id' => $id++,
//                'title' => 'VIAGENS AUTORIZADAS',
//                'slug' => 'viagens-autorizadas',
//                'icon' => '/images/icons/viagens-autorizadas.svg',
//                'links' => [
//                    [
//                        'id' => $id++,
//                        'title' => 'Deputados',
//                        'slug' => 'deputados',
//                        'link' => 'route:section',
//                    ],
//                    [
//                        'id' => $id++,
//                        'title' => 'Funcionários',
//                        'slug' => 'funcionarios',
//                        'link' => 'route:section',
//                    ],
//                ]
//            ],
//
//            4 => [
//                'id' => $id++,
//                'title' => 'BOLSA REFORÇO ESCOLAR',
//                'slug' => 'bolsa-reforco-escolar',
//                'icon' => '/images/icons/bolsa-reforco-escolar.svg',
//                'links' => [
//                    [
//                        'id' => $id++,
//                        'title' => 'Geral',
//                        'slug' => 'geral',
//                        'link' => 'route:section',
//                    ],
//                    [
//                        'id' => $id++,
//                        'title' => 'Na Administração',
//                        'slug' => 'administracao',
//                        'link' => 'route:section',
//                    ],
//                    [
//                        'id' => $id++,
//                        'title' => 'Nos gabinetes',
//                        'slug' => 'gabinetes',
//                        'link' => 'route:section',
//                    ],
//                    [
//                        'id' => $id++,
//                        'title' => 'Nas Lideranças',
//                        'slug' => 'liderancas',
//                        'link' => 'route:section',
//                    ],
//                ]
//            ],
//
//            5 => [
//                'id' => $id++,
//                'title' => 'FUNCIONÁRIOS',
//                'slug' => 'funcionarios',
//                'icon' => '/images/icons/funcionarios.svg',
//                'links' => [
//                    [
//                        'id' => $id++,
//                        'title' => 'Tabela de Vencimentos',
//                        'slug' => 'tabela-de-vencimentos',
//                        'link' => 'route:section',
//                    ],
//                    [
//                        'id' => $id++,
//                        'title' => 'Tabela de Benefícios',
//                        'slug' => 'tabela-de-beneficios',
//                        'link' => 'route:section',
//                    ],
//                    [
//                        'id' => $id++,
//                        'title' => 'Folha de Pagamento',
//                        'slug' => 'folha-de-pagamento',
//                        'link' => 'route:section',
//                    ],
//                ]
//            ],
//
//            6 => [
//                'id' => $id++,
//                'title' => 'ESTAGIÁRIOS',
//                'slug' => 'estagiarios',
//                'icon' => '/images/icons/estagiarios.svg',
//                'links' => [
//                    [
//                        'id' => $id++,
//                        'title' => 'Nível médio',
//                        'slug' => 'nivel-medio',
//                        'link' => 'route:section',
//                    ],
//                    [
//                        'id' => $id++,
//                        'title' => 'Nível superior',
//                        'slug' => 'nivel-superior',
//                        'link' => 'route:section',
//                    ],
//                ]
//            ],
//
//
//            7 => [
//                'id' => $id++,
//                'title' => 'ORÇAMENTO E FINANÇAS',
//                'slug' => 'orcamento-e-financa',
//                'icon' => '/images/icons/orcamento-e-financas.svg',
//                'links' => [
//                    [
//                        'id' => $id++,
//                        'title' => 'Relatório de Gestão Fiscal',
//                        'slug' => 'relatorio-de-gestao-Fiscal',
//                        'link' => 'route:section',
//                    ],
//                    [
//                        'id' => $id++,
//                        'title' => 'Gastos do Poder Legislativo',
//                        'slug' => 'gastos-do-poder-Legislativo',
//                        'link' => 'route:section',
//                    ],
//                ]
//            ],
//
//            8 => [
//                'id' => $id++,
//                'title' => 'TRANSPARÊNCIA NO RIO DE JANEIRO',
//                'slug' => 'transparenciaRJ',
//                'icon' => '/images/icons/transparencia-no-rj.svg',
//                'links' => [
//                    [
//                        'id' => $id++,
//                        'title' => 'Executivo',
//                        'slug' => 'executivo',
//                        'link' => 'route:section',
//                    ],
//                    [
//                        'id' => $id++,
//                        'title' => 'Judiciario',
//                        'slug' => 'judiciario',
//                        'link' => 'route:section',
//                    ],
//                    [
//                        'id' => $id++,
//                        'title' => 'Ministerio Publico',
//                        'slug' => 'ministerio-publico',
//                        'link' => 'route:section',
//                    ],
//                    [
//                        'id' => $id++,
//                        'title' => 'TCE',
//                        'slug' => 'tce',
//                        'link' => 'route:section',
//                    ],
//                    [
//                        'id' => $id++,
//                        'title' => 'Junta Comercial',
//                        'slug' => 'junta-comercial',
//                        'link' => 'route:section',
//                    ],
//                ]
//            ],
//
//            9 => [
//                'id' => $id++,
//                'title' => 'DIÁRIO OFICIAL',
//                'slug' => 'diario-oficial',
//                'icon' => '/images/icons/diario-oficial.svg',
//                'links' => [
//                    [
//                        'id' => $id++,
//                        'title' => 'Poder Legislativo',
//                        'slug' => 'poder-legislativo',
//                        'link' => 'route:section',
//                    ],
//                    [
//                        'id' => $id++,
//                        'title' => 'D.O. Notícias',
//                        'slug' => 'do-noticias',
//                        'link' => 'route:section',
//                    ],
//                    [
//                        'id' => $id++,
//                        'title' => 'Parte I (Poder Executivo)',
//                        'slug' => 'poder-executivo',
//                        'link' => 'route:section',
//                    ],
//                    [
//                        'id' => $id++,
//                        'title' => 'Parte IA - (Ministério Público)',
//                        'slug' => 'ministerio-publico',
//                        'link' => 'route:section',
//                    ],
//                    [
//                        'id' => $id++,
//                        'title' => 'Parte IB - (Tribunal de Contas)',
//                        'slug' => 'tribunal-de-contas',
//                        'link' => 'route:section',
//                    ],
//                ],
//            ],

            10 => [
                'webservice' => 'viagens-autorizadas',
                'slug' => 'viagens',
            ],

            11 => [
                'webservice' => 'deputados',
                'slug' => 'deputados',
            ],
        ];
    }
}
