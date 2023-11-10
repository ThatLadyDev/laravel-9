<?php

namespace Database\Seeders;

use App\Models\ApiToken;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApiTokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        ApiToken::query()->create([
            'token' => Str::random(18)
        ]);
    }
}
