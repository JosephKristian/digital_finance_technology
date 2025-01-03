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
        'coa_sub_id',
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

    // Relasi ke CoaSub
    public function coaSub()
    {
        return $this->belongsTo(CoaSub::class, 'coa_sub_id', 'coa_sub_id');
    }


    // Relasi ke parent Coa
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }

    // Relasi ke child Coa
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }
}
