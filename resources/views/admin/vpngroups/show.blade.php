@extends('layouts.app')

@section('content')
    @include('admin.vpngroups._nav')


    <div class="d-flex flex-row mb-3">
        <a href="{{ route('admin.vpngroups.index') }}" class="btn btn-primary btn-sm mr-1">
            {{ trans('messages.admin_vpngroups') }}
        </a>
        <a href="{{ route('admin.vpngroups.edit', $group) }}" class="btn btn-primary btn-sm mr-1">
            {{ trans('messages.admin_btn_update') }}
        </a>


        <form method="post" action="{{ route('admin.vpngroups.changeStatus', $group) }}" class="mr-1" onSubmit="return confirm(' {{ $group->changeStatusConfirmMessage() }} ');">
            @csrf
            <button class="btn btn-primary btn-sm">
                {{ $group->changeStatusButtonText() }}
            </button>
        </form>

        <form method="post" action="{{ route('admin.vpngroups.update', $group) }}" class="mr-1" onSubmit="return confirm(' {{ trans('messages.delete_confirm') }} ');">
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
            <th>{{ trans('messages.admin_vpngroups_id') }}</th>
            <td>{{ $group->id }}</td>
        </tr>
        <tr>
            <th>{{ trans('messages.admin_vpngroups_name') }}</th>
            <td>{{ $group->name }}</td>
        </tr>
        <tr>
            <th>{{ trans('messages.admin_vpngroups_status') }}</th>
            <td>
                @if ($group->isActive())
                    <span class="badge badge-success">
                            {{ trans('messages.status_active') }}
                        </span>
                @endif
                @if ($group->isBlocked())
                    <span class="badge badge-danger">
                            {{ trans('messages.status_blocked') }}
                        </span>
                @endif
            </td>
        </tr>
        <tr>
            <th>{{ trans('messages.admin_vpngroups_comment') }}</th>
            <td>{{ $group->comment }}</td>
        </tr>
        </tbody>
    </table>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>
                    {{ trans('messages.admin_vpnusers_id') }}
                </th>
                <th>
                    {{ trans('messages.admin_vpnusers_name') }}
                </th>
                <th>
                    {{ trans('messages.admin_vpnusers_login') }}
                </th>
                <th>
                    {{ trans('messages.admin_vpnusers_comment') }}
                </th>
                <th>
                    {{ trans('messages.admin_vpnusers_status') }}
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($group->clients as $client)
                <tr>
                    <td>
                        {{ $client->id }}
                    </td>
                    <td>
                        <a href="{{ route('admin.vpnusers.show', ['id' => $client->id]) }}" target="_blank">
                            {{ $client->name }}
                        </a>
                    </td>
                    <td>
                        {{ $client->login }}
                    </td>
                    <td>
                        {{ $client->comment }}
                    </td>
                    <td>
                        @if ($client->isActive())
                            <span class="badge badge-success">{{ trans('messages.status_active') }}</span>
                        @endif
                        @if ($client->isBlocked())
                            <span class="badge badge-danger">{{ trans('messages.status_blocked') }}</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection
