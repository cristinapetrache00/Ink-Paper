<?php

namespace App\Services;

use App\Models\Client;

class ClientService
{
    public function __construct()
    {
        //
    }

    public function setProperties(Client $client, array $properties): void
    {
        if (!empty($properties['nume'])) {
            $client->nume = $properties['nume'];
        }

        if (!empty($properties['prenume'])) {
            $client->prenume = $properties['prenume'];
        }

        if (!empty($properties['nr_telefon'])) {
            $client->nr_telefon = $properties['nr_telefon'];
        }

        if (!empty($properties['adresa'])) {
            $client->adresa = $properties['adresa'];
        }

        if (!empty($properties['oras'])) {
            $client->oras = $properties['oras'];
        }

        if (!empty($properties['judet'])) {
            $client->judet = $properties['judet'];
        }
    }
}
