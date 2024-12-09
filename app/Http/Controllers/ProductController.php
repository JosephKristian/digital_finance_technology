<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Pest\Laravel\get;

class ProductController extends Controller
{
    // Menampilkan daftar produk
    public function index()
    {
        $umkm = Umkm::where('user_id', Auth::user()->id)->firstOrFail();
        $products = Product::where('umkm_id', $umkm->id)->get();

        // dd($umkm, $products, $umkm->id);
        return view('umkm.products.index', compact('products', 'umkm'));
    }

    // Menyimpan produk baru
    public function store(Request $request)
    {
        $umkm = Umkm::where('user_id', Auth::user()->id)->firstOrFail();
        // dd($request, $umkm);
        $request->validate([
            'name' => 'required|string|max:255',
            'purchase_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
        ]);

        $productId = 'PRD-' . date('Ymd') . substr(uniqid('', true), -4);

        Product::create([
            'id' => $productId,
            'umkm_id' => $umkm->id,
            'name' => $request->name,
            'purchase_price' => $request->purchase_price,
            'selling_price' => $request->selling_price,
            'stock_quantity' => $request->stock_quantity,
            'status' => 'active',
        ]);

        return redirect()->back()->with('success', 'Produk ' . $request->name . ' berhasil didaftarkan!');
    }

    // Memperbarui produk
    public function update(Request $request, $id)
    {
        $umkm = Umkm::where('user_id', Auth::user()->id)->firstOrFail();
        $request->validate([
            'name' => 'required|string|max:255',
            'purchase_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
        ]);

        $product = Product::where('id', $id)
            ->where('umkm_id', $umkm->id)
            ->firstOrFail();


        $product->update($request->all());

        return redirect()->back()->with('success', 'Produk ' . $request->name . ' berhasil diperbaharui!');
    }

    // Menghapus produk
    public function destroy($id)
    {
        $umkm = Umkm::where('user_id', Auth::user()->id)->firstOrFail();
        $product = Product::where('id', $id)
            ->where('umkm_id', $umkm->id)
            ->firstOrFail();
        $productName = $product->name;
        $product->delete();

        return redirect()->back()->with('success', 'Produk ' . $productName . '  berhasil di hapus!');
    }
}
