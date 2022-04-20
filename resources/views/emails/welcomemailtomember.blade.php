@component('mail::message')
# Hi, {{ $details['name'] }}!

You've got an invitation to be a part of the team to manage <b>{{ Session::get('property_name') }}</b> with the role of <b>{{ $details['role'] }}</b>.
<br>

Please press the continue button below to accept the invitation and use the credentails found below: 
<br>
Email: {{ $details['email'] }}
<br>
Username: {{ $details['username'] }}
<br>
Password: {{ $details['password'] }}
<br>

@component('mail::button', ['url' => $url])
Accept Invitation
@endcomponent

Regards,<br>
{{ auth()->user()->name }}

<b>This email is automatically generated by the system, please do not reply.</b>
@endcomponent
