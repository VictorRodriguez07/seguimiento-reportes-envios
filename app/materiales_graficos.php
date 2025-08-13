<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class materiales_graficos extends Model
{
    use HasFactory;
    protected $table = 'materiales_graficos';
    protected $fillable = [
        'img',
        'nombre',
        'cantidad',
        'disponible',
        'id_tipo_material_grafico'
    ];
}
