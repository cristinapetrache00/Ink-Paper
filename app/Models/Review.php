<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *  App\Models\Review
 * @property int $id
 * @property int $id_client
 * @property int $id_carte
 * @property string $comentariu
 * @property float $rating
 * @property DateTime $data_review
 * @property string $titlu
*/

class Review extends Model
{
    use HasFactory;

    protected $table = 'review';

    protected $columns = [
        'id' => [
            'label' => 'id'
        ],
        'id_client' => [
            'label' => 'id_client'
        ],
        'id_carte' => [
            'label' => 'id_carte'
        ],
        'comentariu' => [
            'label' => 'comentariu'
        ],
        'rating' => [
            'label' => 'rating'
        ],
        'data_review' => [
            'label' => 'data_review'
        ],
        'titlu' => [
            'label' => 'titlu'
        ]
    ];

    protected $primaryKey = 'id';

    /**
     * @return BelongsTo
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(
            Client::class,
            'id_client',
            'id'
        );
    }

    /**
     * @return BelongsTo
     */
    public function carte(): BelongsTo
    {
        return $this->belongsTo(
            Carte::class,
            'id_carte',
            'id'
        );
    }
}
