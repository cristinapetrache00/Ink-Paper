@component('mail::message')
    # Bine ati venit pe site-ul nostru!

    Va multumim pentru inregistrarea pe site-ul nostru! Suntem incantati sa va avem alaturi de noi.

    Acestea sunt detaliile inregistrarii:

    {{ $user->email }}

    Pentru confirmarea contului, va rugam sa accesati link-ul de mai jos:

    {{ $url }}


    Daca aveti intrebari sau aveti nevoie de asistenta, nu ezitati sa ne contactati.

    Multumim,
    Echipa Ink&Paper
@endcomponent

