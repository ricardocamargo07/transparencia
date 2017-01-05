<?php

namespace App;

use Carbon\Carbon;

class Webservice
{
    public function convertDate($date)
    {
        if (! $date) {
            return null;
        }

        return Carbon::createFromFormat('d/m/Y', $date);
    }

    private function getIcon($slug)
    {
        return "/images/icons/$slug.svg";
    }

    private function toFiles($ListaArquivos)
    {
        $files = collect($ListaArquivos)->map(function($item) {
            return [
                'id' => 'file-' . $item['IdArquivo'],
                'title' => $item['Titulo'],
                'name' => $item['NomArquivo'],
                'status' => $item['status'] == 'S',
                'contents' => $item['ConteudoArquivo'],
                'type' => $item['Tipo'],
                'published_at_string' => $item['DatPublicacao'],
                'published_at' => $this->convertDate($item['DatPublicacao']),
                'url' => $item['Url'],
            ];
        });

        if ($files->count()) dd($files);

        return $files;
    }

    private function toSections($data)
    {
        $data = collect($data);

        return $data->map(function ($item) {
            /**
             * @param $item
             * @return static
             */
            return [
                'id' => $section_id = $item['IdCategoria'],
                'title' => $item['Nome'],
                'slug' => $slug = str_slug($item['Nome']),
                'icon' => $this->getIcon($slug),
                'links' => $this->getSectionLinks($section_id),
                'published_at_string' => $item['DatPublicacao'],
                'published_at' => $this->convertDate($item['DatPublicacao']),
                'status' => $item['status'] == 'S',
            ];
        });
    }

    private function toSection($data)
    {
        $data = collect($data);

        return $data->map(function ($item) {
            return [
                'id' => $report_id = $item['IdInformacao'],
                'section_id' => $section_id = $item['Categoria']['IdCategoria'],
                'title' => $item['Titulo'],
                'body' => $item['Texto'],
                'link' => route('report', [$report_id]),
                'published_at_string' => $item['DatPublicacao'],
                'published_at' => $this->convertDate($item['DatPublicacao']),
                'status' => $item['Status'] == 'S',
                'url' => $item['Url'],
                'schedule_start' => $item['AgendarEntrada'] == 'S',
                'schedule_end' => $item['AgendarSaida'] == 'S',
                'start_date' => $this->convertDate($item['DatAgendaEntrada']),
                'end_date' => $this->convertDate($item['DatAgendaSaida']),
                'redirect_file' => $item['RedirecionaArquivo'] == 'S',
                'section' => [
                    'id' => $item['Categoria']['IdCategoria'],
                    'title' => $item['Categoria']['Nome'],
                    'published_at_string' => $item['DatPublicacao'],
                    'published_at' => $this->convertDate($item['DatPublicacao']),
                    'status' => $item['Categoria']['status'] == 'S',
                ],
                'files' => $this->toFiles($item['ListaArquivos']),
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
