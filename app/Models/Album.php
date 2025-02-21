<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class album extends Model
{
    use HasFactory;

    protected $table = 'albums';
    protected $fillable = ['nama_album', 'deskripsi', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fotos()
    {
        return $this->hasMany(Foto::class, 'album_id');
    }
}
