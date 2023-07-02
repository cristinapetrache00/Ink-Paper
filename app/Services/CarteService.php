<?php

namespace App\Services;

use App\Models\Carte;
use App\Models\Categorie;

class CarteService
{
    public function __construct()
    {
        //
    }

    public function setProperties(Carte $carte, array $properties): void
    {
        if (!empty($properties['titlu'])) {
            $carte->titlu = $properties['titlu'];
        }

        if (!empty($properties['autor'])) {
            $carte->autor = $properties['autor'];
        }

        if (!empty($properties['imagine'])) {
            $carte->imagine = $properties['imagine'];
        }

        if (!empty($properties['isbn'])) {
            $carte->isbn = $properties['isbn'];
        }

        if (!empty($properties['editura'])) {
            $carte->editura = $properties['editura'];
        }

        if (!empty($properties['pret'])) {
            $carte->pret = $properties['pret'];
        }

        if (!empty($properties['an_aparitie'])) {
            $carte->an_aparitie = $properties['an_aparitie'];
        }

        if (!empty($properties['nr_pg'])) {
            $carte->nr_pg = $properties['nr_pg'];
        }

        if (!empty($properties['tip_coperta'])) {
            $carte->tip_coperta = $properties['tip_coperta'];
        }

        if (!empty($properties['limba'])) {
        $carte->limba = $properties['limba'];
        }

        if (!empty($properties['dimensiune'])) {
            $carte->dimensiune = $properties['dimensiune'];
        }

        if (!empty($properties['cantitate'])) {
            $carte->cantitate = $properties['cantitate'];
        }

        $carte->save();
    }
}
