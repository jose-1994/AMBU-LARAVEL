<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class perfiles extends Model
{
    use HasFactory;

    protected $table = 'perfiles';

    protected $fillable = [
        'idArea',
        'NombrePerfil',
    ] ;
}
