<?php

namespace App;

class Section
{
    private $sections = [
        1 => [
            'title' => 'PERGUNTAS FREQUENTES',
            'slug' => 'faq',
            'icon' => 'images/icones_0001.png',
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
        return $this->sections[1];

        return $this->webservice->getSection(1);
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
