@component('mail::message')
    # Welcome to Our Application

    Thank you for registering with us! We are excited to have you on board.

    Here are your registration details:

    {{ $user->name }}
    {{ $user->email }}

    Verify your email address by accessing the link below.

    {{ $url }}

    If you have any questions or need assistance, feel free to reach out to our support team.

    Thanks,
    The Application Team
@endcomponent
