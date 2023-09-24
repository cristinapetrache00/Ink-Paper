<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\CarteCos
 * @property int $id_client
 * @property int $id_carte
 * @property int $cantitate
 * @property float $subtotal
 */

class CarteCos extends Model
{
    use HasFactory;

    protected $table = 'carte_cos';

    protected $columns = [
        'id_carte' => [
            'label' => 'id_carte'
        ],
        'id_client' => [
            'label' => 'id_client'
        ],
        'cantitate' => [
            'label' => 'cantitate'
        ],
        'subtotal' => [
            'label' => 'subtotal'
        ]
    ];

    protected $primaryKey = 'id_carte';

    public function carti(): HasMany
    {
        return $this->HasMany(
            Carte::class,
            'id',
            'id_carte'
        );
    }

}
