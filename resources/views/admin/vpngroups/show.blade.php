@extends('layouts.app')

@section('breadcrumbs')
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a class="baselink" href="{{ route('home') }}">
                {{ trans('messages.breadcrumbs_homelink') }}
            </a>
        </li>
        <li class="breadcrumb-item">
            <a class="baselink" href="{{ route('admin.vpngroups.index') }}">
                {{ trans('messages.breadcrumbs_admin_vpngroups') }}
            </a>
        </li>
        <li class="breadcrumb-item active">
            {{ trans('messages.admin_vpngroups_show', ['name' => $group->name]) }}
        </li>
    </ul>
@endsection
@section('content')

    <h4>
        {{ trans('messages.admin_vpngroups_info', ['name' => $group->name]) }}
    </h4>
    <hr>

    <div class="d-flex flex-row mb-3">

        <a class="btn btn-dark btn-sm mr-1" onclick="window.backUrl()" href="javascript:void(0);">
            {{ trans('messages.go_back') }}
        </a>
        <a href="{{ route('admin.vpngroups.index') }}" class="btn btn-dark btn-sm mr-1">
            {{ trans('messages.admin_vpngroups') }}
        </a>
        <a href="{{ route('admin.vpngroups.edit', $group) }}" class="btn btn-dark btn-sm mr-1">
            {{ trans('messages.admin_btn_update') }}
        </a>


        <form method="post" action="{{ route('admin.vpngroups.changeStatus', $group) }}" class="mr-1" onSubmit="return confirm(' {{ $group->changeStatusConfirmMessage() }} ');">
            @csrf
            <button class="btn btn-dark btn-sm">
                {{ $group->changeStatusButtonText() }}
            </button>
        </form>

        @can('admin')
        <form method="post" action="{{ route('admin.vpngroups.update', $group) }}" class="mr-1" onSubmit="return confirm(' {{ trans('messages.admin_btn_delete_cascade_vpnusers') }} ');">
            @csrf
            @method('DELETE')
            <button class="btn btn-dark btn-sm">
                {{ trans('messages.admin_btn_delete') }}
            </button>
        </form>
        @endcan
    </div>

    <div class="row">
        <div class="col">

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

        </div>
        <div class="col">

            <h5>
                {{ trans('messages.users_in_current_group') }}
            </h5>
            @if ($group->users()->exists())
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
                                    <a class="baselink" href="{{ route('admin.vpnusers.show', ['id' => $client->id]) }}" target="_blank">
                                        {{ $client->name }}
                                    </a>
                                </td>
                                <td>
                                    {{ $client->login }}
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
            @else
                <div class="alert alert-info">
                    {{ trans('messages.no_users_in_this_group') }}
                </div>
            @endif

        </div>
    </div>

@endsection
