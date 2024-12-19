<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
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
        'transaction_id',
        'umkm_id',
        'customer_id',
        'information',
        'transaction_date',
        'total_amount',
    ];

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function umkm()
    {
        return $this->belongsTo(UMKM::class);
    }

    public function journals()
    {
        return $this->hasMany(Journal::class, 'transaction_id');
    }
}
