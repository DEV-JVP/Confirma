<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comunidad extends Model
{
    use HasFactory;

     protected $table = 'comunidades';

    protected $fillable = ['persona_id', 'mesa_id'];

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

    public function mesa()
    {
        return $this->belongsTo(Mesa::class);
    }
}
