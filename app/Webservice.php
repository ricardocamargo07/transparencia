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
        $data = $this->readJson('file'.$sectionId.'.json');

        return $this->convertDatamodel($data);
    }

    private function readJson($file)
    {
       return json_decode(
           file_get_contents(database_path($file))
       );
    }
}
