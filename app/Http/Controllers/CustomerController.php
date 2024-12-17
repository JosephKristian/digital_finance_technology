<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    // Menampilkan daftar pelanggan
    public function index()
    {
        $umkm = Umkm::where('user_id', Auth::user()->id)->firstOrFail();
        $customers = Customer::where('umkm_id', $umkm->id)->get();

        return view('umkm.customers.index', compact('customers', 'umkm'));
    }

    // Menyimpan pelanggan baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'preferred_contact_method' => 'nullable|in:phone,email',
        ]);

        $umkm = Umkm::where('user_id', Auth::user()->id)->firstOrFail();

        Customer::create([
            'umkm_id' => $umkm->id,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'preferred_contact_method' => $request->preferred_contact_method,
        ]);

        return redirect()->back()->with('success', 'Hore.. anda berhasil menambahkan pelanggan ' . $request->name . ' !');
    }

    // Memperbarui data pelanggan
    public function update(Request $request, $id)
    {
        $umkm = Umkm::where('user_id', Auth::user()->id)->firstOrFail();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'preferred_contact_method' => 'nullable|in:phone,email',
        ]);
        


        $customer = Customer::where('id', $id)
            ->where('umkm_id', $umkm->id)
            ->firstOrFail();
            
        $customer->update($request->all());

        return redirect()->back()->with('success', 'Pelanggan ' . $request->name . ' berhasil diperbaharui!');
    }

    // Menghapus pelanggan
    public function destroy($id)
    {
        $customer = Customer::where('id', $id)
            ->whereHas('umkm', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })
            ->firstOrFail();
        $customerName = $customer->name;
        $customer->delete();

        return redirect()->back()->with('success', 'Pelanggan ' . $customerName . ' berhasil dihapus!');
    }
}
