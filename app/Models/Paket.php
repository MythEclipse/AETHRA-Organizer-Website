<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Paket extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'price'];

    public function fiturs()
    {
        return $this->belongsToMany(Fitur::class, 'fitur_paket');
    }
}
