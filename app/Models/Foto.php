<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Foto extends Model
{
    use HasFactory;
    protected $fillable = ['judul','deskripsi','image','visibility','album_id','user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function album()
    {
        return $this->belongsTo(Album::class)->withDefault([
            'nama_album'=> '-',
        ]);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function activeLikes()
    {
        return $this->hasMany(Like::class)->where('status', 'liked');
    }

    public function isLikedByUser($userId)
    {
        return $this->likes()
                    ->where('user_id', $userId)
                    ->where('status', 'liked')
                    ->exists();
    }

    public function komentars()
    {
        return $this->hasMany(KomentarFoto::class);
    }
}
