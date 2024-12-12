<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoaSub extends Model
{
    use HasFactory;

    protected $primaryKey = ['umkm_id', 'coa_sub_id'];
    public $incrementing = false;
    protected $fillable = [
        'umkm_id',
        'coa_sub_id',
        'coa_type_id',
        'sub_name',
        'parent_id'
    ];

    // Relasi ke UMKM
    public function umkm()
    {
        return $this->belongsTo(Umkm::class, 'umkm_id', 'id');
    }

    // Relasi ke CoaType
    public function coaType()
    {
        return $this->belongsTo(CoaType::class, 'coa_type_id', 'coa_type_id');
    }

    // Relasi ke parent CoaSub
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id', 'coa_sub_id')
            ->where('umkm_id', $this->umkm_id);
    }

    // Relasi ke child CoaSub
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'coa_sub_id')
            ->where('umkm_id', $this->umkm_id);
    }


}
