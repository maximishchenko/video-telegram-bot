@extends('layouts.app')

@section('content')
    @include('admin.vpnusers._nav')


    <div class="d-flex flex-row mb-3">
        <a href="{{ route('admin.vpnusers.index') }}" class="btn btn-primary btn-sm mr-1">
            {{ trans('messages.admin_vpnusers') }}
        </a>
        <a href="{{ route('admin.vpnusers.edit', $user) }}" class="btn btn-primary btn-sm mr-1">
            {{ trans('messages.admin_btn_update') }}
        </a>

        <a href="{{ route('admin.vpnusers.password', $user) }}" class="btn btn-primary btn-sm mr-1">
            {{ trans('messages.admin_btn_password') }}
        </a>

        <form method="post" action="{{ route('admin.vpnusers.changeStatus', $user) }}" class="mr-1" onSubmit="return confirm(' {{ $user->changeStatusConfirmMessage() }} ');">
            @csrf
            <button class="btn btn-primary btn-sm">
                {{ $user->changeStatusButtonText() }}
            </button>
        </form>

        <form method="post" action="{{ route('admin.vpnusers.update', $user) }}" class="mr-1" onSubmit="return confirm(' {{ trans('messages.delete_confirm') }} ');">
            @csrf
            @method('DELETE')
            <button class="btn btn-primary btn-sm">
                {{ trans('messages.admin_btn_delete') }}
            </button>
        </form>
    </div>

    <table class="table table table-bordered">
        <tbody>
        <tr>
            <th>{{ trans('messages.admin_vpnusers_id') }}</th>
            <td>{{ $user->id }}</td>
        </tr>
        <tr>
            <th>{{ trans('messages.admin_vpnusers_name') }}</th>
            <td>{{ $user->name }}</td>
        </tr>
        <tr>
            <th>{{ trans('messages.admin_vpnusers_login') }}</th>
            <td>{{ $user->login }}</td>
        </tr>
        <tr>
            <th>{{ trans('messages.admin_vpnusers_group_id') }}</th>
            <td>{{ $user->group->name }}</td>
        </tr>
        <tr>
            <th>{{ trans('messages.admin_vpnusers_password_plain') }}</th>
            <td>{{ $user->password_plain }}</td>
        </tr>
        <tr>
            <th>{{ trans('messages.admin_vpngroups_status') }}</th>
            <td>
                @if ($user->isActive())
                    <span class="badge badge-success">
                            {{ trans('messages.status_active') }}
                        </span>
                @endif
                @if ($user->isBlocked())
                    <span class="badge badge-danger">
                            {{ trans('messages.status_blocked') }}
                        </span>
                @endif
            </td>
        </tr>
        <tr>
            <th>{{ trans('messages.admin_vpngroups_comment') }}</th>
            <td>{{ $user->comment }}</td>
        </tr>
        </tbody>
    </table>

@endsection
