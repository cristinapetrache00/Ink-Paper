<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *  App\Models\Carte
 * @property int $id
 * @property string $titlu
 * @property string $autor
 * @property string $imagine
 * @property string $isbn
 * @property string $editura
 * @property float $pret
 * @property int $an_aparitie
 * @property int $nr_pg
 * @property string $tip_coperta
 * @property string $limba
 * @property string $dimensiune
 * @property string $cantitate
 * @property int $nr_reviewuri
 * @property float $rating
 */

class Carte extends Model
{
    use HasFactory;

    protected $table = 'carte';

    protected $columns = [
        'id' => [
            'label' => 'id'
        ],
        'titlu' => [
            'label' => 'titlu'
        ],
        'autor' => [
            'label' => 'autor'
        ],
        'imagine'=> [
            'label' => 'imagine'
        ],
        'isbn' => [
            'label' => 'isbn'
        ],
        'editura' => [
            'label' => 'editura'
        ],
        'pret' => [
            'label' => 'pret'
        ],
        'an_aparitie' => [
            'label' => 'an_aparitie'
        ],
        'nr_pg' => [
            'label' => 'nr_pg'
        ],
        'tip_coperta' => [
            'label' => 'tip_coperta'
        ],
        'limba' => [
            'label' => 'limba'
        ],
        'dimensiune' => [
            'label' => 'dimensiune'
        ],
        'cantitate' => [
            'label' => 'cantitate'
        ]
    ];

    protected $primaryKey = 'id';

    /**
     * @return HasMany
     */
    public function reviewuri(): HasMany
    {
        return $this->HasMany(
            Review::class,
            'id_carte',
            'id'
        );
    }

    /**
     * @return BelongsToMany
     */
    public function comenzi(): BelongsToMany
    {
        return $this->belongsToMany(
            Comanda::class,
            'carte_comanda',
            'id_carte',
            'id_comanda'
        );
    }

    /**
     * @return BelongsToMany
     */
    public function categorii(): BelongsToMany
    {
        return $this->belongsToMany(
            Categorie::class,
            'carte_categorie',
            'id_carte',
            'id_categorie'
        );
    }
}
