@component('mail::message')
# {{$message->subject}}

{{$message->message}}

To reply to this message please email (<a href="mailto:{{$message->from}}">{{$message->from}}</a>)

Thanks You<br>
{{ config('app.name') }}
@endcomponent
