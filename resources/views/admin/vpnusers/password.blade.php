@extends('layouts.app')

@section('breadcrumbs')
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a class="baselink" href="{{ route('home') }}">
                {{ trans('messages.breadcrumbs_homelink') }}
            </a>
        </li>
        <li class="breadcrumb-item">
            <a class="baselink" href="{{ route('admin.vpnusers.index') }}">
                {{ trans('messages.admin_vpnusers') }}
            </a>
        </li>
        <li class="breadcrumb-item">
            <a class="baselink" href="{{ route('admin.vpnusers.show', $user) }}">
                {{ $user->name }}
            </a>
        </li>
        <li class="breadcrumb-item active">
            {{ trans('messages.admin_btn_change_password') }}
        </li>
    </ul>
@endsection
@section('content')

    <h4>
        {{ trans('messages.change_client_password') }}
    </h4>
    <hr>

    <form method="POST" action="{{ route('admin.vpnusers.setpassword', $user) }}">
    @csrf

        <div class="form-group">
            <input id="password_plain" placeholder="{{ trans('messages.register_password') }}" type="password" class="form-control @error('password_plain') is-invalid @enderror" name="password_plain" required autocomplete="off">

            @error('password_plain')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-group">
            <input id="password_plain-confirm" placeholder="{{ trans('messages.register_password_confirm') }}" type="password" class="form-control" name="password_plain_confirmation" required autocomplete="new-password">
        </div>

        <hr>

        <div class="form-group text-center">
            <button type="submit" class="btn btn-dark btn-sm">
                {{ trans('messages.admin_btn_password') }}
            </button>
            <a class="btn btn-dark btn-sm" onclick="window.backUrl()" href="javascript:void(0);">
                {{ trans('messages.go_back') }}
            </a>
            <a class="btn btn-dark btn-sm" href="{{ route('admin.vpnusers.index') }}">
                {{ trans('messages.admin_vpnusers') }}
            </a>
        </div>
    </form>


@endsection
