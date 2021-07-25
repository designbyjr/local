<?php

namespace Database\Seeders;

use App\Models\Key;
use Database\Factories\KeyFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(3)->create();
        \App\Models\Language::create([
            "name" => "French",
            "iso_code" => "FR"
        ]);

        \App\Models\Language::create([
            "name" => "Arabic",
            "iso_code" => "AR",
            "RTL" => 1
        ]);

        \App\Models\Language::create([
            "name" => "Lithuanian",
            "iso_code" => "LT"
        ]);

        \App\Models\Language::create([
            "name" => "Malay",
            "iso_code" => "MS"
        ]);

        \App\Models\Language::create([
            "name" => "Greek Modern",
            "iso_code" => "EL"
        ]);

        Key::factory(20)->create();
    }
}
