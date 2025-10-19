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
                'name' => 'Yani',
                'email' => 'yaniru@gmail.com',
                'phone' => '089698765432',
                'joined' => '2024-09-03',
            ],
        ];

        return view('admin.customers', ['customers' => $customers]);
    }
}
