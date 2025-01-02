<?php

namespace App\Http\Controllers;

use App\Models\Coa;
use App\Models\CoaSub;
use App\Models\CoaType;
use App\Models\Umkm;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CoaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($umkm_id)
    {
        $umkm = Umkm::findOrFail($umkm_id);
        // Mengurutkan berdasarkan account_code
        $coas = Coa::where('umkm_id', $umkm_id)
            ->with('children', 'parent') // Relasi anak dan parent
            ->orderBy('account_code', 'asc') // Mengurutkan berdasarkan account_code secara ascending
            ->get();

        return view('admin.umkms.coa.index', compact('coas', 'umkm'));
    }


    /**
     * Show the form for creating a new resource.
     */

    public function create($umkm_id)
    {
        $umkm = Umkm::findOrFail($umkm_id);
        $parentCoas = Coa::where('umkm_id', $umkm_id)->get(); // Ambil COA yang ada sebagai Parent
        $coaTypes = CoaType::all(); // Ambil semua Tipe COA
        $coaSubs = CoaSub::where('umkm_id', $umkm_id)->get();

        return view('admin.umkms.coa.coa_create_page', compact('umkm', 'parentCoas', 'coaTypes', 'coaSubs'));
    }

    // Endpoint untuk mengambil Sub Akun berdasarkan COA Type
    public function getCoaSubsByType($umkm_id, $coa_type_id)
    {
        $coaSubs = CoaSub::where('umkm_id', $umkm_id)
            ->where('coa_type_id', $coa_type_id)
            ->get();

        return response()->json(['coaSubs' => $coaSubs]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $umkm_id)
    {
        $request->validate([
            'account_code' => 'required|string',
            'account_name' => 'required|string',
            'parent_id'    => 'nullable|exists:coa,id',
            'category'     => 'required|in:current,non_current',
        ]);

        Coa::create([
            'id'          => \Illuminate\Support\Str::uuid(),
            'umkm_id'     => $umkm_id,
            'coa_sub_id'  => $request->coa_sub_id,
            'account_code' => $request->account_code,
            'account_name' => $request->account_name,
            'parent_id'    => $request->parent_id,
            'category'     => $request->category,
            'is_active'    => $request->is_active ?? true,
        ]);

        return redirect()->route('super-admin.coa.index', $umkm_id)->with('success', 'COA berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Coa $coa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($umkm_id, $id)
    {
        $coa = Coa::findOrFail($id);
        $parentCoas = Coa::where('umkm_id', $umkm_id)->where('id', '!=', $id)->get();

        return view('admin.umkms.coa.coa_edit_page', compact('coa', 'parentCoas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $umkm_id, $id)
    {
        $request->validate([
            'account_code' => 'required|string',
            'account_name' => 'required|string',
            'parent_id'    => 'nullable|exists:coa,id',
            'category'     => 'required|in:current,non_current',
        ]);

        $coa = Coa::findOrFail($id);
        $coa->update($request->all());

        return redirect()->route('super-admin.coa.index', $umkm_id)->with('success', 'COA berhasil diperbarui.');
    }

    public function getCoaSub($umkmId, $coaTypeId)
    {
        try {
            $coaSubs = CoaSub::where('coa_type_id', $coaTypeId)
                ->where('umkm_id', $umkmId)
                ->get();

            return response()->json($coaSubs);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    public function generateAccountCode(Request $request, $umkm_id)
    {
        try {
            Log::info('Starting generateAccountCode function.', [
                'umkm_id' => $umkm_id,
                'request_data' => $request->all()
            ]);

            // Validasi input request
            $request->validate([
                'coa_type_id' => 'required|exists:coa_types,coa_type_id',
                'coa_sub_id' => 'required|exists:coa_subs,coa_sub_id',
            ]);

            Log::info('Request validated successfully.', [
                'coa_type_id' => $request->coa_type_id,
                'coa_sub_id' => $request->coa_sub_id,
            ]);

            // Ambil sub-akun
            $coaSub = CoaSub::where('coa_sub_id', $request->coa_sub_id)
                ->where('umkm_id', $umkm_id)
                ->firstOrFail();

            Log::info('CoaSub found.', ['coa_sub' => $coaSub]);

            $coaTypeId = $request->coa_type_id;
            $coaSubId = $request->coa_sub_id;

            // Daftar kode parent untuk tiap coa_sub_id
            $parentCodes = [
                1100, // Aktiva (coa_sub_id = 1)
                1200, // Piutang (coa_sub_id = 2)
                1300, // Persediaan (coa_sub_id = 3)
                1400, // Pengeluaran Dibayar di Muka (coa_sub_id = 4)
                1500, // Aktiva Tetap (coa_sub_id = 5)
                1600, // Akumulasi Penyusutan (coa_sub_id = 6)
                2000, // Pasiva (coa_sub_id = 7)
                2100, // Hutang (coa_sub_id = 8)
                2200, // Hutang Bank dan Institusi (coa_sub_id = 9)
                3100, // Modal (coa_sub_id = 10)
                4100, // Pendapatan (coa_sub_id = 11)
                4200, // Diskon Penjualan (coa_sub_id = 12)
                4300, // Retur Penjualan (coa_sub_id = 13)
                5100, // HPP (coa_sub_id = 14)
                5200, // Pembelian (coa_sub_id = 15)
                5300, // Diskon Pembelian (coa_sub_id = 16)
                5400, // Retur Pembelian (coa_sub_id = 17)
                6100, // Beban Pengeluaran (coa_sub_id = 18)
                7100, // Pendapatan Lain-lain (coa_sub_id = 19)
                8000, // Beban Pengeluaran Lain-lain (coa_sub_id = 20)
            ];

            // Inisialisasi counter untuk setiap coa_sub_id
            $counts = array_fill(0, count($parentCodes), 1);

            // Ambil account_code terakhir dari database untuk coa_sub_id ini
            $lastAccount = Coa::where('coa_sub_id', $coaSubId)
                ->whereHas('coaSub', function ($query) use ($coaTypeId) {
                    $query->where('coa_type_id', $coaTypeId);
                })
                ->orderBy('account_code', 'desc')
                ->first();

            // Tentukan kode parent berdasarkan coa_sub_id
            if (isset($parentCodes[$coaSubId - 1])) {
                $parentCode = $parentCodes[$coaSubId - 1];
            } else {
                throw new Exception("Invalid coa_sub_id: {$coaSubId}");
            }

            Log::info('Parent code found.', ['parent_code' => $parentCode]);

            // Ambil nomor terakhir dan generate kode baru
            $existingCodes = Coa::where('coa_sub_id', $coaSubId)
                ->pluck('account_code')
                ->toArray();

            do {
                if ($lastAccount) {
                    // Jika ada account_code terakhir, tambahkan 10
                    $newCode = $lastAccount->account_code + 10;
                } else {
                    // Jika tidak ada, generate berdasarkan parentCode dan counter
                    $newCode = $parentCode + $counts[$coaSubId - 1] * 10;
                    $counts[$coaSubId - 1]++;
                }
            } while (in_array($newCode, $existingCodes));

            Log::info('New account code generated.', ['new_account_code' => $newCode]);

            return response()->json(['account_code' => $newCode]);
        } catch (\Exception $e) {
            Log::error('Error generating account code:', [
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($umkm_id, $id)
    {
        $coa = Coa::findOrFail($id);
        $coa->delete();

        return redirect()->route('super-admin.coa.index', $umkm_id)->with('success', 'COA berhasil dihapus.');
    }
}
