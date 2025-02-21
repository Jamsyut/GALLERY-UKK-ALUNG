<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = ['foto_id','user_id','status'];
    public function foto()
    {
        return $this->belongsTo(Foto::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
