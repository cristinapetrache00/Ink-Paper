<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *  App\Models\Returnare
 * @property int $id
 * @property int $id_carte
 * @property int $id_comanda
 * @property int $cantitate
 * @property float $subtotal
 */

class Returnare extends Model
{
    use HasFactory;

    protected $table = 'returnari';

    protected $columns = [
        'id' => [
            'label' => 'id'
        ],
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

    protected $primaryKey = ['id'];

    public function cartiComanda(): HasMany
    {
        return $this->HasMany(
            CarteComanda::class
        );
    }
}
