<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
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
        'purchase_price',
        'selling_price',
        'stock_quantity',
        'status',
    ];

    public function umkm()
    {
        return $this->belongsTo(Umkm::class, 'umkm_id');
    }
}
