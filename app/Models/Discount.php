<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $id_carte
 * @property int $promotie
 */
class Discount extends Model
{
    use HasFactory;

    protected $table = 'discounts';
}
