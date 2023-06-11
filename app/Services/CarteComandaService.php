<?php

namespace App\Services;

use App\Models\CarteComanda;

class CarteComandaService
{
    public function __construct()
    {
        //
    }

    public function setProperties(CarteComanda $cartecomanda, array $properties): void
    {
        if (!empty($properties['id_carte'])) {
            $cartecomanda->id_carte = $properties['id_carte'];
        }

        if (!empty($properties['id_comanda'])) {
            $cartecomanda->id_comanda = $properties['id_comanda'];
        }

        if (!empty($properties['cantitate'])) {
            $cartecomanda->cantitate = $properties['cantitate'];
        }

        if (!empty($properties['subtotal'])) {
            $cartecomanda->subtotal = $properties['subtotal'];
        }
    }
}
