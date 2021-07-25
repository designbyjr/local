<?php

namespace Database\Factories;

use App\Models\Key;
use App\Models\KeysPivot;
use App\Models\Language;
use App\Models\Translation;
use App\Services\GCloudTranslationService;
use Illuminate\Database\Eloquent\Factories\Factory;

class KeyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Key::class;
    protected $google = GCloudTranslationService::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->city,
            'input' => $this->faker->unique()->realText(250)
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Key $key) {
            $codes =Language::get(['id','iso_code']);

            foreach ($codes as $code)
            {
               $data =  (new $this->google)->translate($key->input,$code->iso_code);
               $translate = Translation::create([
                   'language_id' => $code->id,
                   'output' => $data['text']
               ]);

               KeysPivot::create([
                   'key_id' => $key->id,
                   'translation_id' => $translate->id
               ]);
            }

        });
    }
}
