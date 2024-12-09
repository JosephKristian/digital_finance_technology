<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coa extends Model
{
    protected $table = 'coa';
    public $incrementing = false; // Karena menggunakan UUID sebagai primary key
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'umkm_id',
        'account_code',
        'account_name',
        'account_type',
        'parent_id',
        'is_active',
        'category',
        'is_default_receipt',
        'is_default_expense',
    ];

    // Relasi ke UMKM
    public function umkm()
    {
        return $this->belongsTo(Umkm::class, 'umkm_id', 'id');
    }

    // Relasi ke parent akun (jika ada)
    public function parent()
    {
        return $this->belongsTo(Coa::class, 'parent_id', 'id');
    }

    // Relasi ke child akun
    public function children()
    {
        return $this->hasMany(Coa::class, 'parent_id', 'id');
    }
}
