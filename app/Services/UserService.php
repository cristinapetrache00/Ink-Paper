<?php

namespace App\Services;

class UserService
{
    /**
     * @param $password
     * @return array
     */
    public function checkPassword($password): array
    {
        $passwordErrors = [];

        if (strlen($password) < 8) {
            $passwordErrors[] = 'Parola trebuie sa aiba cel putin 8 caractere';
        }

        if (!preg_match('/[A-Z]/', $password)) {
            $passwordErrors[] = 'Parola trebuie sa contina cel putin o majuscula';
        }

        if (!preg_match('/[a-z]/', $password)) {
            $passwordErrors[] = 'Parola trebuie sa contina cel putin o minuscula';
        }

        if (!preg_match('/\d/', $password)) {
            $passwordErrors[] = 'Parola trebuie sa contina cel putin o cifra';
        }

        if (!preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/', $password)) {
            $passwordErrors[] = 'Parola trebuie sa contina cel putin un caracter special';
        }

        return $passwordErrors;
    }

//    /**
//     * @param $phoneNumber
//     * @return array
//     */
//    public function checkPhoneNumber($phoneNumber): array
//    {
//        $phoneNumberErrors = [];
//
//        if (preg_match('/[A-Z]/', $phoneNumber) ||
//            preg_match('/[a-z]/', $phoneNumber) ||
//            preg_match('/[!@#$%^&*()\-_={};:,<.>]/', $phoneNumber)) {
//            $phoneNumberErrors[] = 'Numarul de telefon nu trebuie sa contina litere sau caractere speciale';
//        }
//
//        return $phoneNumberErrors;
//    }
}
