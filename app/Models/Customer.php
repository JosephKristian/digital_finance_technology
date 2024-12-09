<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Customer extends Model
{
    use HasFactory;

    // Mengatur nama kolom primary key
    protected $primaryKey = 'id';

    // Menyatakan bahwa primary key bukan auto-incrementing
    public $incrementing = false;

    // Mengatur tipe data primary key
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'umkm_id',
        'name',
        'phone',
        'email',
        'address',
        'preferred_contact_method',
    ];

    public function umkm()
    {
        return $this->belongsTo(Umkm::class, 'umkm_id');
    }
}
