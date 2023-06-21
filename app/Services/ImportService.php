<?php

namespace App\Services;

use App\Models\Carte;
use App\Models\Categorie;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ImportService
{
    public function import($fileName)
    {
        $filePath = public_path('import/' . $fileName);
        $file = fopen($filePath, 'r');

        $header = fgetcsv($file);
        while ($row = fgetcsv($file)) {

            $data = array_combine($header, $row);

            switch ($fileName) {
                case 'useri.csv':
                    $user = new User();
                    $user->email = $data['email'];
                    $user->password = Hash::make($data['parola']);
                    $user->save();

                    break;

                case 'clienti.csv':
                    $client = new Client();
                    $client->nume = $data['nume'];
                    $client->prenume = $data['prenume'];
                    $client->nr_telefon = $data['nr_telefon'];
                    $client->adresa = $data['adresa'];
                    $client->oras = $data['localitate'];
                    $client->judet = $data['judet'];
                    $client->save();

                    $user = User::where(fn ($query) =>
                        $query->where('email', 'like', '%' . $client->nume . '%')
                              ->orWhere('email', 'like', '%' . $client->prenume . '%')
                    )->first();

                    $client->user()->associate($user);
                    $client->save();

                    $user->client()->associate($client);
                    $user->save();

                    break;

                case 'carti.csv':
                    $carte = new Carte();
                    $carte->titlu = $data['titlu'];
                    $carte->autor = $data['autor'];
                    $carte->imagine = $data['isbn'] . '.jpg';
                    $carte->isbn = $data['isbn'];
                    $carte->editura = $data['editura'];
                    $carte->pret = $data['pret'];
                    $carte->an_aparitie = $data['an_aparitie'];
                    $carte->nr_pg = $data['nr_pg'];
                    $carte->tip_coperta = $data['tip_coperta'];
                    $carte->limba = $data['limba'];
                    $carte->dimensiune = $data['dimensiune'];
                    $carte->cantitate = $data['cantitate'];

                    $carte->save();

                    foreach (explode(',', $data['categorie_id']) as $categorie) {
                        if (count(explode(',', $data['categorie_id'])) > 1) {
                            $categorie = ltrim($categorie);
                        }
                        $carte->categorii()->attach(Categorie::where('nume', $categorie)->first());
                        $carte->save();
                    }

                    break;

                case 'categorii.csv':
                    $categorie = new Categorie();
                    $categorie->nume = $data['nume'];

                    if ($data['parent_id'] == "0") {
                        $categorie->parent_id = $data['parent_id'];
                    } else {
                        $categorie->parent()->associate(Categorie::where('nume', '=', $data['parent_id'])->first());
                    }

                    $categorie->save();

                    break;
            }
        }

        fclose($file);
    }
}
