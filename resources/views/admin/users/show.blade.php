@extends('layouts.app')

@section('content')

    <div class="d-flex flex-row mb-3">
        <a href="{{ route('admin.users.index') }}" class="btn btn-primary btn-sm mr-1">
            {{ trans('messages.breadcrumbs_admin_users') }}
        </a>
        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary btn-sm mr-1">
            {{ trans('messages.admin_btn_update') }}
        </a>
        <a href="{{ route('admin.users.password', $user) }}" class="btn btn-primary btn-sm mr-1">
            {{ trans('messages.admin_btn_password') }}
        </a>


        <form method="post" action="{{ route('admin.users.changeStatus', $user) }}" class="mr-1" onSubmit="return confirm(' {{ $user->changeStatusConfirmMessage() }} ');">
            @csrf
            <button class="btn btn-primary btn-sm">
                {{ $user->changeStatusButtonText() }}
            </button>
        </form>

        <form method="post" action="{{ route('admin.users.update', $user) }}" class="mr-1" onSubmit="return confirm(' {{ trans('messages.delete_confirm') }} ');">
            @csrf
            @method('DELETE')
            <button class="btn btn-primary btn-sm">
                {{ trans('messages.admin_btn_delete') }}
            </button>
        </form>
    </div>


    <h3>Данные пользователя</h3>
    <hr>

    <table class="table table table-bordered">
        <tbody>
            <tr>
                <th>{{ trans('messages.admin_users_id') }}</th>
                <td>{{ $user->id }}</td>
            </tr>
            <tr>
                <th>{{ trans('messages.admin_users_name') }}</th>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <th>{{ trans('messages.admin_users_username') }}</th>
                <td>{{ $user->username }}</td>
            </tr>
            <tr>
                <th>{{ trans('messages.admin_users_phone') }}</th>
                <td><a href="callto://{{ $user->phone }}">{{ $user->phone }}</a></td>
            </tr>
            <tr>
                <th>{{ trans('messages.admin_users_email') }}</th>
                <td><a href="mailto://{{ $user->email }}">{{ $user->email }}</a></td>
            </tr>
            <tr>
                <th>{{ trans('messages.admin_users_role') }}</th>
                <td>
                    @if ($user->isAdmin())
                        <span class="badge badge-primary">
                            {{ trans('roles.admin') }}
                        </span>
                    @endif
                    @if ($user->isUser())
                        <span class="badge badge-success">
                            {{ trans('roles.user') }}
                        </span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>{{ trans('messages.admin_users_status') }}</th>
                <td>
                    @if ($user->isActive())
                        <span class="badge badge-success">
                            {{ trans('messages.status_active') }}
                        </span>
                    @endif
                    @if ($user->isWait())
                        <span class="badge badge-warning">
                            {{ trans('messages.status_wait') }}
                        </span>
                    @endif
                    @if ($user->isBlocked())
                        <span class="badge badge-danger">
                            {{ trans('messages.status_blocked') }}
                        </span>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>


    <h3>Доступ к группам</h3>
    <hr>

    @if ($user->isUser())
        <table class="table table-bordered table-striped">
            <thead>
                <th>{{ trans('messages.admin_vpngroups_id') }}</th>
                <th>{{ trans('messages.admin_vpngroups_name') }}</th>
                <th>{{ trans('messages.admin_vpngroups_comment') }}</th>
                <th>{{ trans('messages.admin_vpngroups_status') }}</th>
            </thead>
            <tbody>
            @foreach($user->vpngroups as $group)
                <tr>
                    <td>
                        {{ $group->id }}
                    </td>
                    <td>
                        {{ $group->name }}
                    </td>
                    <td>
                        {{ $group->comment }}
                    </td>
                    <td>
                        @if ($group->isActive())
                            <span class="badge badge-success">{{ trans('messages.status_active') }}</span>
                        @endif
                        @if ($group->isBlocked())
                            <span class="badge badge-danger">{{ trans('messages.status_blocked') }}</span>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
    @if ($user->isAdmin())
        <hr>
        {{ trans('messages.admin_access_to_all_groups') }}
    @endif

@endsection
