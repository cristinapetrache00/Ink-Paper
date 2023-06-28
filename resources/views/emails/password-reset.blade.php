@component('mail::message')
    # Link pentru resetarea parolei

    Am primit o cerere de resetare a parolei pentru contul dvs.

    {{ $user->email }}

    Pentru resetarea parolei, va rugam sa accesati link-ul de mai jos:

    {{ $url }}

    Daca aveti intrebari sau aveti nevoie de asistenta, nu ezitati sa ne contactati.

    Multumim,
    Echipa Ink&Paper
@endcomponent
