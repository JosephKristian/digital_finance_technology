<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoaTemplate extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'coa_templates';

    // Kolom yang bisa diisi
    protected $fillable = [
        'id',
        'account_code',
        'account_name',
        'account_type',
        'parent_id',
        'category',
        'is_default_receipt',
        'is_default_expense',
    ];

    // Kolom default untuk tipe UUID
    public $incrementing = false;
    protected $keyType = 'string';

    // Relasi parent-child
    public function parent()
    {
        return $this->belongsTo(CoaTemplate::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(CoaTemplate::class, 'parent_id');
    }
}
