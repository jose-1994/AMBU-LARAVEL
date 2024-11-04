<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parques extends Model
{
    use HasFactory;

    protected $table = 'parques';

    protected $fillable = [
        'idMunicipio',
        'NombreParque',
        'colonia',
        'codigo_postal',
        'direccion',
    ];

    public function municipio()
    {
        return $this->belongsTo(Municipios::class, 'idMunicipio');
    }
}
