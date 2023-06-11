<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *  App\Models\CarteComanda
 * @property int $id_carte
 * @property int $id_comanda
 * @property int $cantitate
 * @property float $subtotal
 */

class CarteComanda extends Model
{
    use HasFactory;

    protected $table = 'carte_comanda';

    protected $columns = [
        'id_carte' => [
            'label' => 'id_carte'
        ],
        'id_comanda' => [
            'label' => 'id_comanda'
        ],
        'cantitate' => [
            'label' => 'cantitate'
        ],
        'subtotal' => [
            'label' => 'subtotal'
        ]
    ];

    protected $primaryKey = ['id_carte','id_comanda'];
}
