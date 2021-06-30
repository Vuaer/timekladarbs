@component('mail::message')
# Welcome to memehub {{$name}}!

Thanks for joining us!

@component('mail::button', ['url' => route('upload')])
Upload your first meme!
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
