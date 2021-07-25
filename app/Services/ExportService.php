<?php
namespace App\Services;

use App\Models\Language;
use App\Models\Translation;

class ExportService
{
    public function toJsonFile(Language $language){

        $translations = Translation::where('language_id',$language->id)->get();
        $array = [];
        foreach ($translations as $t)
        {
            $array[$t->key->name] = $t->output;
        }

        $file = $language->name."-iso.json";
        file_put_contents($file, json_encode($array,true));
        return $file;
    }

    public function toYamlFile(){
        $translations = Translation::get();
        $array = [];

        foreach ($translations as $t)
        {
            $array[$t->language->name][$t->key->name] = $t->output;
        }

        $file = "translations.yaml";
        $data = yaml_emit($array,YAML_UTF8_ENCODING);
        file_put_contents($file, $data);
        return $file;
    }
}
