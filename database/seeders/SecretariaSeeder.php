<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SecretariaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Secretaria::factory(10)->create();
    }
}
