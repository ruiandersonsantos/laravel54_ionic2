
<h3>{{ config('app.name') }}</h3>
<p>
Sua conta na plataforma foi criada!
</p>

<p>
    Clique
    <a href="{{ $link = route('email-verification.check', $user->verification_token) . '?email=' . urlencode($user->email) }}">aqui</a>
     para verificar sua conta.
</p>
<p>E-mail gerado de forma automatica, não deve ser respondido.</p>