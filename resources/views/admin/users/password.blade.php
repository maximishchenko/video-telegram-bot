@extends('layouts.app')

@section('breadcrumbs')
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a class="baselink" href="{{ route('home') }}">
                {{ trans('messages.breadcrumbs_homelink') }}
            </a>
        </li>
        <li class="breadcrumb-item">
            <a class="baselink" href="{{ route('admin.users.index') }}">
                {{ trans('messages.admin_users') }}
            </a>
        </li>
        <li class="breadcrumb-item">
            <a class="baselink" href="{{ route('admin.users.show', $user) }}">
                {{ $user->name }}
            </a>
        </li>
        <li class="breadcrumb-item active">
            {{ trans('messages.admin_btn_change_password') }}
        </li>
    </ul>
@endsection
@section('content')
    <h4>{{ trans('messages.change_password') }}</h4>
    <hr>
    <form method="POST" action="{{ route('admin.users.setpassword', $user) }}">
    @csrf

        <div class="form-group">
            <input id="password" placeholder="{{ trans('messages.register_password') }}" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-group">
            <input id="password-confirm" placeholder="{{ trans('messages.register_password_confirm') }}" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">

            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="form-group text-center">
            <button type="submit" class="btn btn-dark btn-sm">
                {{ trans('messages.admin_btn_password') }}
            </button>
            <a class="btn btn-dark btn-sm" onclick="window.backUrl()" href="javascript:void(0);">
                {{ trans('messages.go_back') }}
            </a>
        </div>
    </form>


@endsection
