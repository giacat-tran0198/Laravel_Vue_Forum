@component('mail::message')
    # Une dernière étape

    Nous avons juste besoin que vous confirmiez votre adresse e-mail pour prouver que vous êtes un humain. Vous comprenez, non? Roucouler.
    @component('mail::button', ['url' => url('/register/confirm?token=' . $user->confirmation_token)])
        Confirmez votre e-mail
    @endcomponent

    Cordialement,<br>
    {{ config('app.name') }}
@endcomponent
