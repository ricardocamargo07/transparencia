<?php

namespace App;

class Webservice
{
    private function convertDatamodel($data)
    {
        return $data;
    }

    public function getSection($sectionId)
    {
        $data = $this->requestJson('file'.$sectionId.'.json');

        return $this->convertDatamodel($data);
    }

    public function get($sectionId)
    {
        $data = $this->requestJson('file'.$sectionId.'.json');

        return $this->convertDatamodel($data);
    }

    private function requestJson($file)
    {
       return json_decode(
           file_get_contents(database_path($file))
       );
    }

    public function getSections()
    {
        return $this->requestJson();
    }
}
