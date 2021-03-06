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
        <li class="breadcrumb-item active">
            {{ trans('messages.admin_vpnusers_status') }}
        </li>
    </ul>
@endsection
@section('content')

    <a class="toggleSearchBtn baselink boldlink text-right" href="javascript:void(0);" onclick="window.toggleDiv('search', 'vpnusers_status')">
        {{ trans('messages.toggle_search_text') }}
    </a>
<div class="mb-3" id="search">
    <form action="?" method="GET" autocomplete="off">
        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="name" class="col-form-label">
                        {{ trans('messages.admin_vpnusers_name') }}
                    </label>
                    <input placeholder="" id="name" name="name" value="{{ request('name') }}" class="form-control" type="text">
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="login" class="col-form-label">
                        {{ trans('messages.admin_vpnusers_login') }}
                    </label>
                    <input placeholder="" id="login" name="login" value="{{ request('login') }}" class="form-control" type="text">
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="group_id" class="col-form-label">
                        {{ trans('messages.admin_vpnusers_group_id') }}
                    </label>
                    <select name="group_id" id="group_id" class="form-control">
                        <option value=""></option>
                        @foreach($groups as $groupLabel => $groupValue)
                            <option value="{{ $groupValue }}" {{ $groupValue == request('group_id') ? ' selected' : '' }}>
                                {{ $groupLabel }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="connect_status" class="col-form-label">
                        {{ trans('messages.admin_users_status') }}
                    </label>
                    <select name="connect_status" id="connect_status" class="form-control">
                        <option value=""></option>
                        @foreach(\App\Shared::getConnectionStatusesArray() as $value => $label)
                            <option value="{{ $value }}" {{ $value === request('connect_status') ? ' selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <button type="submit" class="btn btn-dark btn-sm">
                        {{ trans('messages.btn_search') }}
                    </button>

                    <a class="btn btn-dark btn-sm" href="{{ route('admin.vpnusers.status') }}">
                        {{ trans('messages.cancel_search') }}
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="d-flex flex-row mb-3">
    <a class="btn btn-dark btn-sm mr-1" onclick="window.backUrl()" href="javascript:void(0);">
        {{ trans('messages.go_back') }}
    </a>
    <a href="{{ route('admin.vpnusers.index') }}" class="btn btn-dark btn-sm mr-1">
        {{ trans('messages.dashboard_admin_vpnusers') }}
    </a>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>{{ trans('messages.admin_vpnusers_id') }}</th>
            <th>{{ trans('messages.admin_vpnusers_name') }}</th>
            <th>{{ trans('messages.admin_vpnusers_login') }}</th>
            <th>{{ trans('messages.admin_vpnusers_group_id') }}</th>
            <th>{{ trans('messages.admin_vpnusers_connect_status') }}</th>
        </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->login }}</td>
            <td>{{ $user->group->name }}</td>
            <td>
                @if ($user->isConnected())
                    <span class="badge badge-success">
                        {{ trans('messages.status_conneted') }}
                    </span>
                @endif
                @if ($user->isDisconnected())
                    <span class="badge badge-danger">
                        {{ trans('messages.status_disconnected') }}
                    </span>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{{ $users->links() }}

    <script>
        window.checkVisibiliti('search', 'vpnusers_status');
    </script>
@endsection
