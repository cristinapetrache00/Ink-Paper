<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *  App\Models\Donatie
 * @property int $id
 * @property string $nume
 * @property string $prenume
 * @property string $nr_telefon
 * @property string $email
 * @property string $titlu
 * @property string $autor
 * @property string $isbn
 * @property string $adresa_ridicare
 * @property string $oras_ridicare
 * @property string $judet_ridicare
 */

class Donatie extends Model
{
    use HasFactory;

    protected $table = 'donatii';

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
        'email' => [
            'label' => 'email'
        ],
        'titlu' => [
            'label' => 'titlu'
        ],
        'autor' => [
            'label' => 'autor'
        ],
        'isbn' => [
            'label' => 'isbn'
        ],
        'adresa_ridicare' => [
            'label' => 'adresa_ridicare'
        ],
        'oras_ridicare' => [
            'label' => 'oras_ridicare'
        ],
        'judet_ridicare' => [
            'label' => 'judet_ridicare'
        ]
    ];

    protected $primaryKey = 'id';
}
