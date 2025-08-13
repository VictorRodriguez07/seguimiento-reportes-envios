<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tipo_material_grafico extends Model
{
    use HasFactory;
    protected $table = 'tipo_material_grafico';
    protected $fillable = [
        'id',
        'nombre'
    ];
}
