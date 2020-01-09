@extends('layouts.app')

@section('content')

    <div class="d-flex flex-row mb-3">
        <a href="{{ route('profile.edit') }}" class="btn btn-dark btn-sm">
            {{ trans('messages.profile_update') }}
        </a>
        &nbsp;
        <a href="{{ route('profile.password') }}" class="btn btn-dark btn-sm">
            {{ trans('messages.admin_btn_password') }}
        </a>
    </div>

    <table class="table table-striped table-bordered">
        <tr>
            <th>{{ trans('messages.admin_users_id') }}</th>
            <td>{{ $profile->id }}</td>
        </tr>
        <tr>
            <th>
                {{ trans('messages.admin_users_name') }}
            </th>
            <td>
                {{ $profile->name }}
            </td>
        </tr>
        <tr>
            <th>
                {{ trans('messages.admin_users_username') }}
            </th>
            <td>
                {{ $profile->username }}
            </td>
        </tr>
        <tr>
            <th>
                {{ trans('messages.admin_users_email') }}
            </th>
            <td>
                <a href="mailto://{{ $profile->email }}">{{ $profile->email }}</a>
            </td>
        </tr>
        <tr>
            <th>
                {{ trans('messages.admin_users_phone') }}
            </th>
            <td>
                <a href="callto://{{ $profile->phone }}">{{ $profile->phone }}</a>
            </td>
        </tr>
        <tr>
            <th>Роль</th>
            <td>
                @if ($profile->isAdmin())
                    <span class="badge badge-primary">
                            {{ trans('roles.admin') }}
                        </span>
                @endif
                @if ($profile->isUser())
                    <span class="badge badge-success">
                            {{ trans('roles.user') }}
                        </span>
                @endif
            </td>
            </td>
        </tr>
    </table>

@endsection
