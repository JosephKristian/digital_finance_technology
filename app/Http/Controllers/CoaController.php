<?php

namespace App\Http\Controllers;

use App\Models\Coa;
use App\Models\CoaSub;
use App\Models\CoaType;
use App\Models\Umkm;
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

            // Ambil nomor terakhir berdasarkan coa_sub dan coa_type
            $lastAccount = Coa::where('coa_sub_id', $request->coa_sub_id)
                ->whereHas('coaSub', function ($query) use ($coaTypeId) {
                    $query->where('coa_type_id', $coaTypeId);
                })
                ->orderBy('account_code', 'desc')
                ->first();

            Log::info('Last account fetched.', [
                'last_account' => $lastAccount ? $lastAccount->toArray() : null,
            ]);

            // Ambil dua digit terakhir dari account_code jika ada
            $lastNumber = $lastAccount ? (int) substr($lastAccount->account_code, -2) : 0;

            Log::info('Last number calculated.', ['last_number' => $lastNumber]);

            // Generate kode baru
            $newAccountCode = sprintf('%01d%02d%02d', $coaTypeId, $request->coa_sub_id, $lastNumber + 1);

            Log::info('New account code generated.', ['new_account_code' => $newAccountCode]);

            return response()->json(['account_code' => $newAccountCode]);
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
