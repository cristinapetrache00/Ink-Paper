<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

/**
 *  App\Models\Client
 * @property int $id
 * @property string $nume
 * @property string $prenume
 * @property string $nr_telefon
 * @property string $adresa
 * @property string $oras
 * @property string $judet
 */

class Client extends Model
{
    use HasFactory;

    protected $table = 'client';

    protected $columns = [
        'id' => [
            'label' => 'id'
        ],
        'nume' => [
            'label' => 'nume'
        ],
        'prenume' => [
            'label' => 'prenume'
        ],
        'nr_telefon' => [
            'label' => 'nr_telefon'
        ],
        'adresa' => [
            'label' => 'adresa'
        ],
        'oras' => [
            'label' => 'oras'
        ],
        'judet' => [
            'label' => 'judet'
        ]
    ];

    protected $primaryKey = 'id';

    /**
     * @return HasMany
     */
    public function comenzi(): HasMany
    {
        return $this->HasMany(
            Comanda::class,
            'id_client',
            'id'
        );
    }

    /**
     * @return HasMany
     */
    public function reviewuri(): HasMany
    {
        return $this->HasMany(
            Review::class,
            'id_client',
            'id'
        );
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany
     */
    public function cartiCos(): HasMany
    {
        return $this->HasMany(
           CarteCos::class,
           'id_client',
            'id'
        );
    }

    /**
     * @return HasMany
     */
    public function favorite(): HasMany
    {
        return $this->HasMany(
            Favorit::class,
            'id_client',
            'id'
        );
    }
}
