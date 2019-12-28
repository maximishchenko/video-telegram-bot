@component('mail::message')
# {{ trans('messages.email_confirmation_header') }}

{{ trans('messages.email_go_link') }}

@component('mail::button', ['url' => route('register.verify', ['token' => $user->verify_token])])
{{ trans('messages.email_btn_verify_email') }}
@endcomponent

{{ trans('messages.email_thanks') }}<br>
{{ config('app.name') }}
@endcomponent
