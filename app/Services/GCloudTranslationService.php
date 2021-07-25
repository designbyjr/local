<?php


namespace App\Services;
use Google\Cloud\Translate\V2\TranslateClient;


class GCloudTranslationService
{
    public function __construct()
    {
        putenv("GOOGLE_APPLICATION_CREDENTIALS=".base_path('keyfile.json'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function Translate(string $text,string $language) : array
    {
        $client = new TranslateClient();
        $targetLanguage = [ 'target' => $language ];
        return $client->translate(
            $text,
            $targetLanguage,
        );
    }
}
