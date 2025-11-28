<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dt_menu = [
            [
                'nama' => 'Nasi Goreng Ayam',
                'foto' => 'nasi-goreng.jpg', 
                'harga' => 25000,
                'stok' => 50,
                'bahan' => 'Nasi, Telur, Kecap, Bawang, Ayam',
                'kalori' => 450,
                'kategori' => 'main course',
                'deskripsi' => 'Nasi goreng khas dengan bumbu rempah pilihan.'
            ],
            [
                'nama' => 'Sate Ayam',
                'foto' => 'sate-ayam.jpg',
                'harga' => 30000,
                'stok' => 40,
                'bahan' => 'Daging Ayam, Bumbu Kacang, Kecap, Bawang',
                'kalori' => 350,
                'kategori' => 'main course',
                'deskripsi' => 'Sate ayam dengan bumbu kacang yang gurih dan daging yang empuk.'
            ],
            [
                'nama' => 'Sate Kambing',
                'foto' => 'sate-kambing.jpg',
                'harga' => 45000,
                'stok' => 30,
                'bahan' => 'Daging Kambing, Bumbu Kacang, Kecap, Bawang',
                'kalori' => 500,
                'kategori' => 'main course',
                'deskripsi' => 'Sate kambing yang juicy disajikan dengan bumbu yang melimpah.'
            ],
            [
                'nama' => 'Sate Sapi',
                'foto' => 'sate-sapi.jpg',
                'harga' => 40000,
                'stok' => 35,
                'bahan' => 'Daging Sapi, Bumbu Kacang, Kecap, Bawang',
                'kalori' => 480,
                'kategori' => 'main course',
                'deskripsi' => 'Sate sapi yang juicy disajikan dengan bumbu yang kaya rasa.'
            ],
            [
                'nama' => 'Tengkleng Kambing',
                'foto' => 'tengkleng-kambing.jpg',
                'harga' => 50000,
                'stok' => 20,
                'bahan' => 'Tulang Kambing, Santan Cair, Kunyit, Cabai',
                'kalori' => 600,
                'kategori' => 'main course',
                'deskripsi' => 'Olahan tulang kambing segar dengan kuah gulai encer yang pedas.'
            ],
            [
                'nama' => 'Tongseng Ayam',
                'foto' => 'tongseng-ayam.jpg',
                'harga' => 28000,
                'stok' => 45,
                'bahan' => 'Daging Ayam, Kol, Tomat, Santan, Kecap',
                'kalori' => 400,
                'kategori' => 'main course',
                'deskripsi' => 'Tongseng ayam dengan kuah santan yang segar dan manis gurih.'
            ],
            [
                'nama' => 'Tongseng Kambing',
                'foto' => 'tongseng-kambing.jpg',
                'harga' => 48000,
                'stok' => 25,
                'bahan' => 'Daging Kambing, Kol, Tomat, Santan Kental',
                'kalori' => 550,
                'kategori' => 'main course',
                'deskripsi' => 'Tongseng kambing legendaris dengan daging empuk.'
            ],
            [
                'nama' => 'Tongseng Kering Sapi',
                'foto' => 'tongseng-kering-sapi.jpg',
                'harga' => 42000,
                'stok' => 30,
                'bahan' => 'Daging Sapi, Kecap, Merica, Kol',
                'kalori' => 420,
                'kategori' => 'main course',
                'deskripsi' => 'Varian tongseng tanpa kuah (nyemek) dengan daging sapi pilihan.'
            ],
            [
                'nama' => 'Tongseng Sapi',
                'foto' => 'tongseng-sapi.jpg',
                'harga' => 42000,
                'stok' => 30,
                'bahan' => 'Daging Sapi, Santan, Sayuran Segar',
                'kalori' => 470,
                'kategori' => 'main course',
                'deskripsi' => 'Tongseng sapi berkuah kental yang nikmat.'
            ],
        ];

        foreach ($dt_menu as $data) {
            Menu::create($data);
        }
    }
}
