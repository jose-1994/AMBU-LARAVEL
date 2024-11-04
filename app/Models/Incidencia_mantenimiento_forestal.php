<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incidencia_mantenimiento_forestal extends Model
{
    use HasFactory;

    protected $table = "incidencia_mantenimiento_forestal";

    protected $fillable = [
        "id_parque",
        "id_municipio",
        "id_user",
        "folio",
        "tipo",
        "descripcion",
        "imagenes",
        "estado",
        "created_at",
        "updated_at"
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
