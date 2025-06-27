<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    // Gunakan guarded agar semua bisa diisi kecuali slug
    protected $guarded = ['slug'];
}
