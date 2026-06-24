<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesSeeder::class,   // MUST come first
            UserSeeder::class,

            LegalDocumentsSeeder::class,
            LegalSectionsSeeder::class,
            LegalListItemsSeeder::class,

            ApplicationSeeder::class,
            ApplicationLogSeeder::class,
          

            AboutSeeder::class,
            AboutTableSeeder::class,

            LogoSeeder::class,
            HomeSeeder::class,
            HomeTable1Seeder::class,
            Nav1Seeder::class,
            FooterTitlesSeeder::class,
            FooterItemsSeeder::class,
            SocialsSeeder::class,
        ]);

    }
}