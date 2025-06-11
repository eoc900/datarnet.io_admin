<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Maestro;

class MaestroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
      public function run()
    {
        // Generate 10 Maestros using the factory
        Maestro::factory()->count(10)->create();
    }
}
