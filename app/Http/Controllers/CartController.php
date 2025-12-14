<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class CartController extends Controller
{
    // Menampilkan isi keranjang
    public function viewCart()
    {
        $cart = session()->get('cart', []);
        return view('pembayaran.cart', compact('cart')); // Kita akan buat view ini nanti
    }

    // Menambah item ke keranjang
    public function addToCart(Request $request, $id)
    {
        $menu = Menu::find($id);
        
        if(!$menu) {
            abort(404);
        }

        $cart = session()->get('cart', []);

        // Jika menu sudah ada di cart, tambah quantity
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            // Jika belum, masukkan data menu
            $cart[$id] = [
                "name" => $menu->nama_menu, // Pastikan sesuai nama kolom di DB Menu Diki
                "quantity" => 1,
                "price" => $menu->harga,
                "image" => $menu->gambar // Sesuaikan jika ada kolom gambar
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Menu berhasil ditambahkan ke keranjang!');
    }

    // Hapus item
    public function removeFromCart($id)
    {
        $cart = session()->get('cart');
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Menu dihapus dari keranjang');
    }
}