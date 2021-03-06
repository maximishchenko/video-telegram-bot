@extends('layouts.app')

@section('breadcrumbs')
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a class="baselink" href="{{ route('home') }}">
                {{ trans('messages.breadcrumbs_homelink') }}
            </a>
        </li>
        <li class="breadcrumb-item">
            <a class="baselink" href="{{ route('admin.vpnclients.index') }}">
                {{ trans('messages.admin_vpnclients') }}
            </a>
        </li>
        <li class="breadcrumb-item active">
            {{ $client->name }}
        </li>
    </ul>
@endsection
@section('content')

    <h4>
        {{ trans('messages.admin_vpnclients_show', ['name' => $client->name]) }}
    </h4>

    <hr>

    <div class="d-flex flex-row mb-3">
        <a class="btn btn-dark btn-sm mr-1" onclick="window.backUrl()" href="javascript:void(0);">
            {{ trans('messages.go_back') }}
        </a>
        <a href="{{ route('admin.vpnclients.index') }}" class="btn btn-dark btn-sm mr-1">
            {{ trans('messages.admin_vpnclients') }}
        </a>
        @can('admin')
        <a href="{{ route('admin.vpnclients.edit', $client) }}" class="btn btn-dark btn-sm mr-1">
            {{ trans('messages.admin_btn_update') }}
        </a>
        @endcan
        <a href="{{ route('admin.vpnclients.config', $client) }}" class="btn btn-dark btn-sm mr-1">
            {{ trans('messages.admin_btn_getconfig') }}
        </a>


        @can('admin')
        <form method="post" action="{{ route('admin.vpnclients.changeStatus', $client) }}" class="mr-1" onSubmit="return confirm(' {{ $client->changeStatusConfirmMessage() }} ');">
            @csrf
            <button class="btn btn-dark btn-sm">
                {{ $client->changeStatusButtonText() }}
            </button>
        </form>
        @endcan

        @can('admin')
            <form method="post" action="{{ route('admin.vpnclients.destroy', $client) }}" class="mr-1" onSubmit="return confirm(' {{ trans('messages.delete_confirm') }} ');">
                @csrf
                @method('DELETE')
                <button class="btn btn-dark btn-sm">
                    {{ trans('messages.admin_btn_delete') }}
                </button>
            </form>
        @endcan
    </div>

    <table class="table table table-bordered">
        <tbody>
        <tr>
            <th>{{ trans('messages.admin_vpnclients_id') }}</th>
            <td>{{ $client->id }}</td>
        </tr>
        <tr>
            <th>{{ trans('messages.admin_vpnclients_name') }}</th>
            <td>{{ $client->name }}</td>
        </tr>
        <tr>
            <th>{{ trans('messages.admin_vpnclients_server') }}</th>
            <td>{{ $client->getServerUri() }}</td>
        </tr>
        <tr>
            <th>{{ trans('messages.admin_vpnclients_ca_file') }}</th>
            <td>
                <a class="baselink" href="{{ $client->getCAUrl() }}">
                    {{ $client->ca_file }}
                </a>
            </td>
        </tr>
        <tr>
            <th>{{ trans('messages.admin_vpnclients_cert_file') }}</th>
            <td>
                <a class="baselink" href="{{ $client->getCertUrl() }}">
                    {{ $client->cert_file }}
                </a>
            </td>
        </tr>
        <tr>
            <th>{{ trans('messages.admin_vpnclients_key_file') }}</th>
            <td>
                <a class="baselink" href="{{ $client->getKeyUrl() }}">
                    {{ $client->key_file }}
                </a>
            </td>
        </tr>
        <tr>
            <th>{{ trans('messages.admin_vpnclients_status') }}</th>
            <td>
                @if ($client->isActive())
                    <span class="badge badge-success">
                            {{ trans('messages.status_active') }}
                        </span>
                @endif
                @if ($client->isBlocked())
                    <span class="badge badge-danger">
                            {{ trans('messages.status_blocked') }}
                        </span>
                @endif
            </td>
        </tr>
        <tr>
            <th>{{ trans('messages.admin_vpnclients_comment') }}</th>
            <td>{{ $client->comment }}</td>
        </tr>
        </tbody>
    </table>


@endsection
