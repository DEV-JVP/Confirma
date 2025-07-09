<?php

namespace App\Models;
use App\Models\Asistencia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Persona extends Model
{
    use HasFactory;

    protected $fillable = [
        'dni',
        'nombre_completo',
        'fecha_nacimiento',
        'bautizo',
        'eucaristia',
        'contacto',
        'nombre_apoderado',
        'telefono_apoderado',
    ];

    protected $casts = [
      
        'bautizo' => 'boolean',
        'eucaristia' => 'boolean',
    ];

    public function asistencias()
{
    return $this->hasMany(Asistencia::class);
}

public function asistioEnFecha(string $fecha): ?bool
    {
        $asistencia = $this->asistencias()
            ->where('fecha', $fecha)
            ->first();
            
        return $asistencia ? $asistencia->asistio : null;
    }

    public function comunidad()
{
    return $this->hasOne(Comunidad::class);
}

}
