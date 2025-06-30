<?php
namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = []; // Izinkan semua diisi untuk kemudahan

    public function user() { return $this->belongsTo(User::class); }
    public function parent() { return $this->belongsTo(Conversation::class, 'parent_id'); }
    public function replies() { return $this->hasMany(Conversation::class, 'parent_id'); }
}
