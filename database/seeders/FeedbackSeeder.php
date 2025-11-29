<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeedbackSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('feedback')->insert([
            [
                'user_id' => 1,
                'menu_id' => 1,
                'komentar' => 'Makanannya enak dan pelayanannya cepat.',
                'rating' => 5,
            ],
            [
                'user_id' => 2,
                'menu_id' => 2,
                'komentar' => 'Tempatnya nyaman dan bersih.',
                'rating' => 4,
            ],
            [
                'user_id' => 3,
                'menu_id' => 1,
                'komentar' => 'Sedikit lambat saat jam ramai, tapi tetap bagus.',
                'rating' => 4,
            ],
            [
                'user_id' => 4,
                'menu_id' => 3,
                'komentar' => 'Meja outdoor sangat nyaman!',
                'rating' => 5,
            ],
        ]);
    }
}
