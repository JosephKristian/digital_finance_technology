<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoaType extends Model
{
    use HasFactory;

    protected $table = 'coa_types'; // Nama tabel di database
    protected $primaryKey = 'coa_type_id'; // Primary key
    public $timestamps = true;

    protected $fillable = [
        'type_name',
        'coa_type_id',
    ];

    /**
     * Relasi ke tabel CoaSub.
     * Satu CoaType memiliki banyak CoaSub.
     */
    public function coaSubs()
    {
        return $this->hasMany(CoaSub::class, 'coa_type_id', 'coa_type_id');
    }
}
