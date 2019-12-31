@extends('layouts.app')

@section('content')
    @include('admin.users._nav')

        <h1 class="text-center">{{ trans('messages.admin_users_create') }}</h1>

        <hr>


    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf

        <div class="form-group">
            <label for="name" class="col-form-label">
                {{ trans('messages.admin_users_name') }}
            </label>
            <input id="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" type="text" name="name" value="{{ old('name') }}" required>
            @if ($errors->has('name'))
                <span class="invalid-feedback"><strong>{{ $errors->first('name') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="username" class="col-form-label">
                {{ trans('messages.admin_users_username') }}
            </label>
            <input id="username" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" type="text" name="username" value="{{ old('username') }}" required>
            @if ($errors->has('username'))
                <span class="invalid-feedback"><strong>{{ $errors->first('username') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="email" class="col-form-label">
                {{ trans('messages.admin_users_email') }}
            </label>
            <input id="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" type="email" name="email" value="{{ old('email') }}" required>
            @if ($errors->has('email'))
                <span class="invalid-feedback"><strong>{{ $errors->first('email') }}</strong></span>
            @endif
        </div>

        <hr>

        <div class="form-group text-center">
            <button type="submit" class="btn btn-outline-dark btn-sm">
                {{ trans('messages.btn_save') }}
            </button>

            <a class="btn btn-outline-dark btn-sm" href="{{ route('admin.users.index') }}">
                {{ trans('messages.breadcrumbs_admin_users') }}
            </a>
        </div>
    </form>

@endsection
