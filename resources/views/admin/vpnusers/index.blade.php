@extends('layouts.app')

@section('content')
    @include('admin.vpnusers._nav')

    <div class="card mb-3">
        <div class="card-header">
            Filter
        </div>
        <div class="card-body">
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
                            <label for="status" class="col-form-label">
                                {{ trans('messages.admin_users_status') }}
                            </label>
                            <select name="status" id="status" class="form-control">
                                <option value=""></option>
                                @foreach(\App\Shared::getShortStatusesArray() as $value => $label)
                                    <option value="{{ $value }}" {{ $value === request('status') ? ' selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-sm">
                                {{ trans('messages.btn_search') }}
                            </button>

                            <a class="btn btn-primary btn-sm" href="{{ route('admin.vpnusers.index') }}">
                                {{ trans('messages.cancel_search') }}
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="d-flex flex-row mb-3">
        <a href="{{ route('admin.vpnusers.create') }}" class="btn btn-primary btn-sm mr-1">
            {{ trans('messages.admin_btn_create') }}
        </a>
    </div>
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <td>{{ trans('messages.admin_vpnusers_id') }}</td>
            <td>{{ trans('messages.admin_vpnusers_name') }}</td>
            <td>{{ trans('messages.admin_vpnusers_login') }}</td>
            <td>{{ trans('messages.admin_vpnusers_group_id') }}</td>
            <td>{{ trans('messages.admin_vpnusers_comment') }}</td>
            <td>{{ trans('messages.admin_vpnusers_status') }}</td>
        </tr>
        </thead>
        <tbody>

        @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>
                    <a href="{{ route('admin.vpnusers.show', $user) }}">{{ $user->name }}</a>
                </td>
                <td>{{ $user->login }}</td>
                <td>{{ $user->group->name }}</td>
                <td>{{ $user->comment }}</td>
                <td>

                    @if ($user->isActive())
                        <span class="badge badge-success">{{ trans('messages.status_active') }}</span>
                    @endif
                    @if ($user->isBlocked())
                        <span class="badge badge-danger">{{ trans('messages.status_blocked') }}</span>
                    @endif
                </td>

        @endforeach

        </tbody>
    </table>

    {{ $users->links() }}

@endsection
