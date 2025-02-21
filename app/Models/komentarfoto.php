<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class komentarfoto extends Model
{
    use HasFactory;

    protected $fillable = ['foto_id', 'user_id', 'komentar'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
