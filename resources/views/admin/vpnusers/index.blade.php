@extends('layouts.app')

@section('content')

    <div class="card mb-3">
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
        <a href="{{ route('admin.vpnusers.status') }}" class="btn btn-primary btn-sm mr-1">
            {{ trans('messages.admin_vpnusers_connect_status') }}
        </a>
        <div class="col-sm-2">
            <select style="height: unset" class="form-control input-sm" name="pageSize" id="pageSize" onchange="window.pager(this.name, this.value)">
                <option value="" disabled selected>
                    {{ trans('messages.pager_count_elements') }}
                </option>
                <option value=""></option>
                @foreach(\App\Shared::getPagersArray() as $value => $label)
                    <option value="{{ $value }}" {{ (isset($_GET['pageSize']) && ($_GET['pageSize'] == $value)) ? ' selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="text-right">
        <b>{{ trans('messages.count_grid', ['count' => $users->count(), 'total' => $users->total()]) }}</b>


    </div>



    <table class="table table-bordered">
        <thead>
        <tr>
            <th>{{ trans('messages.admin_vpnusers_id') }}</th>
            <th>{{ trans('messages.admin_vpnusers_name') }}</th>
            <th>{{ trans('messages.admin_vpnusers_login') }}</th>
            <th>{{ trans('messages.admin_vpnusers_group_id') }}</th>
            <th>{{ trans('messages.admin_vpnusers_comment') }}</th>
            <th>{{ trans('messages.admin_vpnusers_status') }}</th>
        </tr>
        </thead>
        <tbody>

        @foreach($users as $user)
            <tr class="{{ ($user->group->status == \App\Shared::STATUS_BLOCKED) ? 'alert alert-danger' : '' }}">
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
                    @else
                        <span class="badge badge-danger">{{ trans('messages.status_blocked') }}</span>
                    @endif
                </td>

        @endforeach

        </tbody>
    </table>

    {{ $users->links() }}

    <script>
    </script>
@endsection
