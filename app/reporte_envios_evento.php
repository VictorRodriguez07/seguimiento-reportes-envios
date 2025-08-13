<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reporte_envios_evento extends Model
{
    use HasFactory;
    protected $table = 'reporte_envio_evento';
    protected $fillable = [
        'fecha_envio',
        'nombre_evento',
        'direccion_entrega',
        'observaciones',
        'id_destinatario',
        'id_responsable'
    ];
}
