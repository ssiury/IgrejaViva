<?php

namespace Database\Seeders;

use App\Modules\Culto\database\seeders\CultoSeeder;
use App\Modules\InformacaoIgreja\database\seeders\InformacaoIgrejaSeeder;
use App\Modules\Ministerio\database\seeders\MinisterioSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CultoSeeder::class,
            MinisterioSeeder::class,
            InformacaoIgrejaSeeder::class,
        ]);
    }
}
