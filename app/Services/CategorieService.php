<?php

namespace App\Services;

use App\Models\Categorie;

class CategorieService
{
    public function __construct()
    {
        //
    }

    public function setProperties(Categorie $categorie, array $properties): void
    {
        if (!empty($properties['nume'])) {
            $categorie->nume = $properties['nume'];
        }

        if (!empty($properties['parent_id'])) {
//            $categorie->parent_id = $properties['parent_id'];
            $parentCategorie = Categorie::find($properties['parent_id']);
            $categorie->parent()->associate($parentCategorie);
            $categorie->save();

        }
    }
}
