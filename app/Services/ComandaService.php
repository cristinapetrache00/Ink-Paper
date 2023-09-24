<?php

namespace App\Services;

use App\Models\Comanda;
use Illuminate\Support\Carbon;

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
            $comanda->tip = $properties['tip'];
        }

        $currentDate = Carbon::now();
        $futureDate = $currentDate->addDays(7)->format('Y-m-d');

        $comanda->data_plasare = Carbon::now()->format('Y-m-d');

        $comanda->data_livrare = $futureDate;

        $comanda->data_predare = $futureDate;

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
