<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 *  App\Models\Categorie
 * @property int $id
 * @property string $nume
 * @property int $parent_id
 */

class Categorie extends Model
{
    use HasFactory;

    protected $table = 'categorie';

    protected $columns = [
        'id' => [
            'label' => 'id'
        ],
        'nume' => [
            'label' => 'nume'
        ],
        'parent_id' => [
            'label' => 'parent_id'
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
            'carte_categorie',
            'id_categorie',
            'id_carte'
        );
    }

    public function parent()
    {
        return $this->belongsTo(Categorie::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Categorie::class, 'parent_id', 'id');
    }
}
