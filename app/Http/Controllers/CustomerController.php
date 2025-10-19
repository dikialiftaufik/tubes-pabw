<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = [
            [
                'id' => 1,
                'name' => 'Fateh',
                'email' => 'fthh@gmail.com',
                'phone' => '081494507490',
                'joined' => '2024-08-12',
            ],
            [
                'id' => 2,
                'name' => 'Santoso',
                'email' => 'santo@gmail.com',
                'phone' => '081298765432',
                'joined' => '2024-09-01',
            ],
            [
                'id' => 3,
                'name' => 'Zufar',
                'email' => 'par@gmail.com',
                'phone' => '0895331464728',
                'joined' => '2024-09-04',
            ],
            [
                'id' => 4,
                'name' => 'Amara',
                'email' => 'mara@gmail.com',
                'phone' => '081229120736',
                'joined' => '2024-09-04',
            ],
            [
                'id' => 5,
                'name' => 'Yani',
                'email' => 'yaniru@gmail.com',
                'phone' => '089698765432',
                'joined' => '2024-09-03',
            ],
        ];

        return view('admin.customers', ['customers' => $customers]);
    }
}
