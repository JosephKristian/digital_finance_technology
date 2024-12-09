<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Token extends Model
{
    use HasFactory;

    // Tentukan nama tabel (jika berbeda dengan nama model dalam bentuk plural)
    protected $table = 'tokens';

    // Tentukan kolom yang boleh diisi (Mass Assignment)
    protected $fillable = ['token', 'expires_at'];

    // Tentukan tipe kolom yang digunakan untuk tanggal
    protected $dates = ['expires_at'];

    /**
     * Cek apakah token sudah kedaluwarsa.
     *
     * @return bool
     */
    public function isExpired()
    {
        // Mengecek apakah waktu kedaluwarsa sudah lewat
        return Carbon::now()->greaterThan($this->expires_at);
    }
}
