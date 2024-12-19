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

    public function oppositeJournalCredit()
    {
        return $this->hasOne(self::class, 'transaction_id', 'transaction_id')
            ->where('type', '=', 'debit'); // Ambil jurnal dengan tipe lawan
    }

    public function oppositeCoaCredit()
    {
        return $this->hasOneThrough(
            Coa::class,
            self::class,
            'transaction_id', // Foreign key pada jurnal lawan
            'id',             // Foreign key pada CoA
            'transaction_id', // Local key pada model ini
            'coa_id'          // Local key pada jurnal lawan
        )->where('journals.type', '=', 'debit'); // Filter untuk tipe debit
    }
}
