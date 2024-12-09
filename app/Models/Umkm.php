<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Umkm extends Model
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
        'user_id',
        'name',
        'address',
        'phone',
        'tax_id',
        'business_type',
        'pdf_path',
        'approve'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}
