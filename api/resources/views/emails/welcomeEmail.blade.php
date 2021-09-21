@component('mail::message')
# Registration Notification

You have been added to the Sondi database,
you can now register for an account on our 
dashboard (<a href={{ env('SPA_URL').'/register' }}>{{ env('SPA_URL').'/register' }}</a>)
with this email ({{$potentialUser->email}}).

@if ($potentialUser->is_admin)
 As an admin the dashboard allows you to: 
  * Create and manage other users.
  * Create and manage properties.
@elseif ($potentialUser->is_agent)
 As an agent the dashboard allows you to: 
  * Create and manage properties.
@else
 As a tenant the dashboard allows you to: 
  * Send enquiries.
  * Send maintanence tickets
@endif

This service is created for your convinience 
and should be used as often as possible.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
