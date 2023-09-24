<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Favorit
 * @property int $id_client
 * @property int $id_carte
 */


class Favorit extends Model
{
    use HasFactory;

    protected $table = 'favorite';

    protected $columns = [
        'id_carte' => [
            'label' => 'id_carte'
        ],
        'id_client' => [
            'label' => 'id_client'
        ]
    ];

    protected $primaryKey = 'id_carte';

    public function carti(): HasMany
    {
        return $this->hasMany(
            Carte::class,
            'id',
            'id_carte'
        );
    }
}
