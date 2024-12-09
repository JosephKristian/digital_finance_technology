<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    //
    use HasFactory;

     // Mengatur nama kolom primary key
     protected $primaryKey = 'id';

     // Menyatakan bahwa primary key bukan auto-incrementing
     public $incrementing = false;
 
     // Mengatur tipe data primary key
     protected $keyType = 'string';

    protected $fillable = ['name', 'description'];

    // Relasi jika diperlukan, contoh jika PaymentMethod berelasi dengan Transactions
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'payment_method_id');
    }
}
