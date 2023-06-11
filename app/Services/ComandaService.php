<?php

namespace App\Services;

use App\Models\Comanda;

class ComandaService
{
    public function __construct()
    {
        //
    }

    public function setProperties(Comanda $comanda, array $properties): void
    {
        if (!empty($properties['id_client'])) {
            $comanda->id_client = $properties['id_client'];
        }

        if (!empty($properties['tip'])) {
            $comanda->status = $properties['tip'];
        }

        if (!empty($properties['data_plasare'])) {
            $comanda->data_plasare = $properties['data_plasare'];
        }

        if (!empty($properties['data_livrare'])) {
            $comanda->data_livrare = $properties['data_livrare'];
        }

        if (!empty($properties['data_predare'])) {
            $comanda->data_plasare = $properties['data_predare'];
        }

        if (!empty($properties['pret_comanda'])) {
            $comanda->pret_comanda = $properties['pret_comanda'];
        }

        if (!empty($properties['adresa_livrare'])) {
            $comanda->adresa_livrare = $properties['adresa_livrare'];
        }

        if (!empty($properties['oras_livrare'])) {
            $comanda->oras_livrare = $properties['oras_livrare'];
        }

        if (!empty($properties['judet_livrare'])) {
            $comanda->judet_livrare = $properties['judet_livrare'];
        }

        if (!empty($properties['status'])) {
            $comanda->status = $properties['status'];
        }

        if (!empty($properties['metoda_plata'])) {
            $comanda->metoda_plata = $properties['metoda_plata'];
        }
    }
}
