<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incidencia_limpieza_del_parque extends Model
{
    use HasFactory;

    protected $table = "incidencia_limpieza_parques";

    protected $fillable = [
        "folio",
        "id_municipio",
        "id_parque",
        "id_user",
        "tipo",
        "descripcion",
        "imagenes",
        "estado",
    ];
    //Relaciones
    public function municipio()
    {
        return $this->belongsTo(Municipios::class, "id_municipio");
    }
    public function parque()
    {
        return $this->belongsTo(Parques::class, 'id_parque');
    }
    public function user()
    {
        return $this->belongsTo(Usuarios::class, 'id_user');
    }
}
