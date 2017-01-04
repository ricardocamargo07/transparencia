<?php

namespace App;

class Section
{
    private $sections = [
        1 => [
            'id' => 1,
            'title' => 'PERGUNTAS FREQUENTES',
            'slug' => 'faq',
            'icon' => 'images/icons/perguntas-frequentes.svg',
            'links' => [
                [
                    'title' => 'Perguntas e Respostas - FAQ',
                    'slug' => 'faq',
                    'link' => 'route:section',
                ],
                [
                    'title' => 'Como acompanhar o seu pedido?',
                    'slug' => 'pedido',
                    'link' => 'route:section',
                ],
                [
                    'title' => 'Ato da Alerj',
                    'slug' => 'ato',
                    'link' => 'route:section',
                ],
                [
                    'title' => 'A lei na íntegra',
                    'slug' => 'lei',
                    'link' => 'route:section',
                ],
                [
                    'title' => 'Mapa da lei',
                    'slug' => 'mapa',
                    'link' => 'route:section',
                ],
                [
                    'title' => 'Quais as exceções',
                    'slug' => 'excecoes',
                    'link' => 'route:section',
                ],
            ]
        ],

        2 => [
            'id' => 2,
            'title' => 'DEPUTADOS',
            'slug' => 'deputados',
            'icon' => '/images/icons/deputados.svg',
            'links' => [
                [
                    'title' => 'Salário',
                    'slug' => 'salario',
                    'link' => 'route:section',
                ],
                [
                    'title' => 'Benefícios',
                    'slug' => 'beneficios',
                    'link' => 'route:section',
                ],
                [
                    'title' => 'Lista de Presença',
                    'slug' => 'lista-presenca',
                    'link' => 'route:section',
                ],
                [
                    'title' => 'Folha de pagamento',
                    'slug' => 'folha-pagamento',
                    'link' => 'route:section',
                ],
            ]
        ],

        3 => [
            'id' => 3,
            'title' => 'VIAGENS AUTORIZADAS',
            'slug' => 'viagens-autorizadas',
            'icon' => '/images/icons/viagens-autorizadas.svg',
            'links' => [
                [
                    'title' => 'Deputados',
                    'slug' => 'deputados',
                    'link' => 'route:section',
                ],
                [
                    'title' => 'Funcionários',
                    'slug' => 'funcionarios',
                    'link' => 'route:section',
                ],
            ]
        ],

        4 => [
            'id' => 4,
            'title' => 'BOLSA REFORÇO ESCOLAR',
            'slug' => 'bolsa-reforco-escolar',
            'icon' => '/images/icons/bolsa-reforco-escolar.svg',
            'links' => [
                [
                    'title' => 'Geral',
                    'slug' => 'geral',
                    'link' => 'route:section',
                ],
                [
                    'title' => 'Na Administração',
                    'slug' => 'administracao',
                    'link' => 'route:section',
                ],
                [
                    'title' => 'Nos gabinetes',
                    'slug' => 'gabinetes',
                    'link' => 'route:section',
                ],
                [
                    'title' => 'Nas Lideranças',
                    'slug' => 'liderancas',
                    'link' => 'route:section',
                ],
            ]
        ],

        5 => [
            'id' => 5,
            'title' => 'FUNCIONÁRIOS',
            'slug' => 'funcionarios',
            'icon' => '/images/icons/funcionarios.svg',
            'links' => [
                [
                    'title' => 'Tabela de Vencimentos',
                    'slug' => 'tabela-de-vencimentos',
                    'link' => 'route:section',
                ],
                [
                    'title' => 'Tabela de Benefícios',
                    'slug' => 'tabela-de-beneficios',
                    'link' => 'route:section',
                ],
                [
                    'title' => 'Folha de Pagamento',
                    'slug' => 'folha-de-pagamento',
                    'link' => 'route:section',
                ],
            ]
        ],

        6 => [
            'id' => 6,
            'title' => 'ESTAGIÁRIOS',
            'slug' => 'estagiarios',
            'icon' => '/images/icons/estagiarios.svg',
            'links' => [
                [
                    'title' => 'Nível médio',
                    'slug' => 'nivel-medio',
                    'link' => 'route:section',
                ],
                [
                    'title' => 'Nível superior',
                    'slug' => 'nivel-superior',
                    'link' => 'route:section',
                ],
            ]
        ],


        7 => [
            'id' => 7,
            'title' => 'ORÇAMENTO E FINANÇAS',
            'slug' => 'orcamento-e-financa',
            'icon' => '/images/icons/orcamento-e-financas.svg',
            'links' => [
                [
                    'title' => 'Relatório de Gestão Fiscal',
                    'slug' => 'relatorio-de-gestao-Fiscal',
                    'link' => 'route:section',
                ],
                [
                    'title' => 'Gastos do Poder Legislativo',
                    'slug' => 'gastos-do-poder-Legislativo',
                    'link' => 'route:section',
                ],
            ]
        ],

        8 => [
            'id' => 8,
            'title' => 'TRANSPARÊNCIA NO RIO DE JANEIRO',
            'slug' => 'transparenciaRJ',
            'icon' => '/images/icons/transparencia-no-rj.svg',
            'links' => [
                [
                    'title' => 'Executivo',
                    'slug' => 'executivo',
                    'link' => 'route:section',
                ],
                [
                    'title' => 'Judiciario',
                    'slug' => 'judiciario',
                    'link' => 'route:section',
                ],
                [
                    'title' => 'Ministerio Publico',
                    'slug' => 'ministerio-publico',
                    'link' => 'route:section',
                ],
                [
                    'title' => 'TCE',
                    'slug' => 'tce',
                    'link' => 'route:section',
                ],
                [
                    'title' => 'Junta Comercial',
                    'slug' => 'junta-comercial',
                    'link' => 'route:section',
                ],
            ]
        ],

        9 => [
            'id' => 9,
            'title' => 'DIÁRIO OFICIAL',
            'slug' => 'diario-oficial',
            'icon' => '/images/icons/diario-oficial.svg',
            'links' => [
                [
                    'title' => 'Poder Legislativo',
                    'slug' => 'poder-legislativo',
                    'link' => 'route:section',
                ],
                [
                    'title' => 'D.O. Notícias',
                    'slug' => 'do-noticias',
                    'link' => 'route:section',
                ],
                [
                    'title' => 'Parte I (Poder Executivo)',
                    'slug' => 'poder-executivo',
                    'link' => 'route:section',
                ],
                [
                    'title' => 'Parte IA - (Ministério Público)',
                    'slug' => 'ministerio-publico',
                    'link' => 'route:section',
                ],
                [
                    'title' => 'Parte IB - (Tribunal de Contas)',
                    'slug' => 'tribunal-de-contas',
                    'link' => 'route:section',
                ],
            ],
        ],

        10 => [
            'webservice' => 'deputados',
            'slug' => 'deputados',
        ],
    ];

    public function __construct()
    {
        $this->webservice = app(Webservice::class);
    }

    public static function all()
    {
        $me = new static();

        return $me->loadSections();
    }

    public static function findBySlug($slug)
    {
        return static::all()->where('slug', $slug);
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
        $sections = collect($this->sections);

        $sections = $sections->map(function($item) {
            if (isset($item['webservice'])) {
                return $this->loadFromWebService($item);
            }

            return $this->populate($item);
        });

        return $sections;
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
}
