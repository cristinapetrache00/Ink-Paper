<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_carte
 * @property int $id_categorie
 */
class CarteCategorie extends Model
{
    use HasFactory;

    protected $table='carte_categorie';

    protected $primaryKey = 'id_carte';
}
