<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoaTypeTemplate extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan oleh model
    protected $table = 'coa_types_template';

    // Kolom yang dapat diisi massal
    protected $fillable = ['type_name'];

    // Relasi dengan CoaSubTemplate (Satu ke Banyak)
    public function coaSubs()
    {
        return $this->hasMany(CoaSubTemplate::class, 'coa_type_id');
    }
}
