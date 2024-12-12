<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoaSubTemplate extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan oleh model
    protected $table = 'coa_sub_template';

    // Kolom yang dapat diisi massal
    protected $fillable = ['coa_type_id', 'sub_name', 'parent_id'];

    // Relasi dengan CoaTypeTemplate (Banyak ke Satu)
    public function coaType()
    {
        return $this->belongsTo(CoaTypeTemplate::class, 'coa_type_id');
    }

    // Relasi dengan Coa (Banyak ke Satu, jika diperlukan untuk sub akun)
    public function coa()
    {
        return $this->belongsTo(CoaTemplate::class, 'coa_sub_id');
    }
}
