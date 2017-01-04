<?php

namespace App;

class Webservice
{
    private function getIcon($slug)
    {
        return "/images/icons/$slug.svg";
    }

    private function toSections($data)
    {
        $data = collect($data);

        return $data->map(function ($item) {
            return [
                'id' => $section_id = $item['IdCategoria'],
                'title' => $item['Nome'],
                'slug' => $slug = str_slug($item['Nome']),
                'icon' => $this->getIcon($slug),
                'links' => $this->getSectionLinks($section_id),
                'published_at' => $item['DatPublicacao'],
                'status' => $item['status'] == 'S',
            ];
        });
    }

    private function toSection($data)
    {
        $data = collect($data);

        return $data->map(function ($item) {
            return [
                'id' => $item['IdInformacao'],
                'section_id' => $item['Categoria']['IdCategoria'],
                'title' => $item['Titulo'],
                'body' => $item['Texto'],
                'published_at' => $item['DatPublicacao'],
                'status' => $item['Status'] == 'S',
                'url' => $item['Url'],
                'schedule_start' => $item['AgendarEntrada'],
                'schedule_end' => $item['AgendarSaida'],
                'start_date' => $item['DatAgendaEntrada'],
                'end_date' => $item['DatAgendaSaida'],
                'redirect_file' => $item['RedirecionaArquivo'],
                'section' => $item['Categoria'],
                'files' => $item['ListaArquivos'],
            ];
        });
    }

    private function getSectionLinks($id)
    {
        return $this->toSection($this->requestJson('file-licitacoes.json'))->toArray();
    }

    public function getSection($sectionId)
    {
        return $this->getSections()->where('slug', $sectionId)->values()[0];
    }

    private function requestJson($url)
    {
       return json_decode(file_get_contents(database_path($url)), true);
    }

    public function getSections()
    {
        return $this->toSections(
            $this->requestJson('file-sections.json')
        );
    }
}
