<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use DateTime;

/**
 *  App\Models\Comanda
 * @property int $id
 * @property int $id_client
 * @property string $tip
 * @property DateTime $data_plasare
 * @property DateTime $data_livrare
 * @property DateTime $data_predare
 * @property float $pret_comanda
 * @property string $adresa_livrare
 * @property string $oras_livrare
 * @property string $judet_livrare
 * @property string $status
 * @property string $metoda_plata
 */

class Comanda extends Model
{
    use HasFactory;

    protected $table = 'comanda';

    protected $columns = [
        'id' => [
            'label' => 'id'
        ],
        'id_client' => [
            'label' => 'id_client'
        ],
        'tip' => [
            'label' => 'tip'
        ],
        'data_plasare' => [
            'label' => 'data_plasare'
        ],
        'data_livrare' => [
            'label' => 'data_livrare'
        ],
        'data_predare' => [
            'label' => 'data_predare'
        ],
        'pret_comanda' => [
            'label' => 'pret_comanda'
        ],
        'adresa_livrare' => [
            'label' => 'adresa_livrare'
        ],
        'oras_livrare' => [
            'label' => 'oras_livrare'
        ],
        'judet_livrare' => [
            'label' => 'judet_livrare'
        ],
        'status' => [
            'label' => 'status'
        ],
        'metoda_plata' => [
            'label' => 'metoda_plata'
        ]
    ];

    protected $primaryKey = 'id';

    /**
     * @return BelongsToMany
     */
    public function carti(): BelongsToMany
    {
        return $this->belongsToMany(
            Carte::class,
            'carte_comanda',
            'id_comanda',
            'id_carte'
        );
    }

}
