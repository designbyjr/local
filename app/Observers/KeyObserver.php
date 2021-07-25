<?php

namespace App\Observers;

use App\Models\Key;
use App\Models\KeysPivot;
use App\Models\Language;
use App\Models\Translation;
use App\Services\GCloudTranslationService;

class KeyObserver
{
    public function created(Key $key)
    {
        $codes = Language::get(['id','iso_code']);

        foreach ($codes as $code)
        {
            $data =  (new GCloudTranslationService())->translate($key->input,$code->iso_code);
            $translate = Translation::create([
                'language_id' => $code->id,
                'output' => $data['text']
            ]);

            KeysPivot::create([
                'key_id' => $key->id,
                'translation_id' => $translate->id
            ]);
        }
    }

    public function updated(Key $key)
    {
        if($key->isDirty('input')) {
            foreach ($key->translations as $translation) {
                $data = (new GCloudTranslationService())->translate($key->input, $translation->language->iso_code);
                Translation::update([
                    "id" => $translation->id,
                    'output' => $data['text']
                ]);
            }
        }
    }

    public function deleting(Key $key)
    {
        $key->translations()->forceDelete();
        $key->pivot()->forceDelete();
    }
}
