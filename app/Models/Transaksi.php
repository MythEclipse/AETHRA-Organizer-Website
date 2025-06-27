<?php

// app/Models/Transaksi.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_code',
        'user_id',
        'paket_id',
        'event_date',
        'total_amount',
        'status',
        'payment_method',
        'payment_proof',
    ];

    protected $casts = [
        'event_date' => 'date',
    ];

    /**
     * Relasi ke model User (satu transaksi dimiliki oleh satu user).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke model Paket (satu transaksi untuk satu paket).
     */
    public function paket()
    {
        return $this->belongsTo(Paket::class);
    }
}
