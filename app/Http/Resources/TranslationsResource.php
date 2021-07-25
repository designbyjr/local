<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TranslationsResource extends JsonResource
{
    public static $wrap = 'translations';
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => (string)$this->id,
            'key_id' => $this->key->name,
            'language_id' => $this->language_id,
            'language' => LanguageResource::make($this->language),
            'output' => $this->output,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at
        ];
    }
}
