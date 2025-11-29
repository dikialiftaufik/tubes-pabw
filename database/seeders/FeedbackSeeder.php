<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeedbackSeeder extends Seeder
{
    public function run()
    {
        DB::table('feedback')->insert([
            [
                'nama' => 'Budi Santoso',
                'feedback' => 'Makanannya enak dan pelayanannya cepat.'
            ],
            [
                'nama' => 'Siti Aisyah',
                'feedback' => 'Tempatnya nyaman dan bersih.'
            ],
            [
                'nama' => 'Andi Wijaya',
                'feedback' => 'Sedikit lambat saat jam ramai, tapi tetap bagus.'
            ],
            [
                'nama' => 'Rina Oktavia',
                'feedback' => 'Meja outdoor sangat nyaman!'
            ],
            [
                'nama' => 'Dedi Pratama',
                'feedback' => 'Harga terjangkau dan rasa tetap juara.'
            ],
        ]);
    }
}
