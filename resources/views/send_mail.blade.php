@component('mail::message')
<p>Greetings User,</p>
<p>Your account has been created. Password of your web & crafts account is <b>{{$password}}</b>. Do not share it with any one.</p>
Thanks,<br>
{{ config('app.name') }}
@endcomponent