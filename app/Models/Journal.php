<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'coa_id',
        'umkm_id',
        'description',
        'amount',
        'type',
    ];

    /**
     * Relasi dengan model Coa
     */
    public function coa()
    {
        return $this->belongsTo(Coa::class);
    }

    /**
     * Relasi dengan model OtherTransaction
     */
    public function Transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }
}
