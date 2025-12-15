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

        if (!$menu) {
            abort(404);
        }

        $cart = session()->get('cart', []);
        $quantity = $request->input('quantity', 1); // Default 1 jika tidak ada input

        // Jika menu sudah ada di cart, tambah quantity sesuai input (atau +1 jika dari tombol biasa)
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            // Jika belum, masukkan data menu
            $cart[$id] = [
                "name" => $menu->nama, // Perbaikan nama kolom
                "quantity" => $quantity,
                "price" => $menu->harga,
                "image" => $menu->foto // Perbaikan nama kolom
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('cart.view')->with('success', 'Menu berhasil ditambahkan ke keranjang!');
    }

    // Hapus item
    public function removeFromCart($id)
    {
        $cart = session()->get('cart');
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Menu dihapus dari keranjang');
    }
}