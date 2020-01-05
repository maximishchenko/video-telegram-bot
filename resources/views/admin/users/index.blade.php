@extends('layouts.app')

@section('content')

    <div class="card mb-3">
        <div class="card-body">
            <form action="?" method="GET" autocomplete="off">
                <div class="row">
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="name" class="col-form-label">
                                {{ trans('messages.admin_users_name') }}
                            </label>
                            <input placeholder="Иванов И.И." id="name" name="name" value="{{ request('name') }}" class="form-control" type="text">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="username" class="col-form-label">
                                {{ trans('messages.admin_users_username') }}
                            </label>
                            <input placeholder="ivanovii" id="username" name="username" value="{{ request('username') }}" class="form-control" type="text">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="email" class="col-form-label">
                                {{ trans('messages.admin_users_email') }}
                            </label>
                            <input placeholder="info@contoso.com" id="email" name="email" value="{{ request('email') }}" class="form-control" type="email">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="phone" class="col-form-label">{{ trans('messages.admin_users_phone') }}</label>
                            <input placeholder="+7-123-456-78-90" id="phone" name="phone" value="{{ request('phone') }}" class="form-control" type="text">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="status" class="col-form-label">
                                {{ trans('messages.admin_users_status') }}
                            </label>
                            <select name="status" id="status" class="form-control">
                                <option value=""></option>
                                @foreach(\App\Shared::getStatusesArray() as $value => $label)
                                    <option value="{{ $value }}" {{ $value === request('status') ? ' selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="role" class="col-form-label">
                                {{ trans('messages.admin_users_role') }}
                            </label>
                            <select name="role" id="role" class="form-control">
                                <option value=""></option>
                                @foreach(\App\Shared::getRolesArray() as $value => $label)
                                    <option value="{{ $value }}" {{ $value === request('role') ? ' selected' : '' }}>
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

                            <a class="btn btn-primary btn-sm" href="{{ route('admin.users.index') }}">
                                {{ trans('messages.cancel_search') }}
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="d-flex flex-row mb-3">
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm mr-1">
            {{ trans('messages.admin_btn_create') }}
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
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>{{ trans('messages.admin_users_id') }}</th>
                <th>{{ trans('messages.admin_users_name') }}</th>
                <th>{{ trans('messages.admin_users_username') }}</th>
                <th>{{ trans('messages.admin_users_email') }}</th>
                <th>{{ trans('messages.admin_users_phone') }}</th>
                <th>{{ trans('messages.admin_users_role') }}</th>
                <th>{{ trans('messages.admin_users_status') }}</th>
            </tr>
        </thead>
        <tbody>

            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td><a href="{{ route('admin.users.show', $user) }}">{{ $user->name }}</a></td>
                    <td>{{ $user->username }}</td>
                    <td><a href="mailto://{{ $user->email }}">{{ $user->email }}</a></td>
                    <td><a href="callto://{{ $user->phone }}">{{ $user->phone }}</a></td>
                    <td>
                        @if ($user->isAdmin())
                            <span class="badge badge-primary">{{ trans('roles.admin') }}</span>
                        @endif
                        @if ($user->isUser())
                            <span class="badge badge-success">{{ trans('roles.user') }}</span>
                        @endif
                    </td>
                    <td>
                        @if ($user->isActive())
                            <span class="badge badge-success">{{ trans('messages.status_active') }}</span>
                        @endif
                        @if ($user->isWait())
                            <span class="badge badge-warning">{{ trans('messages.status_wait') }}</span>
                        @endif
                        @if ($user->isBlocked())
                            <span class="badge badge-danger">{{ trans('messages.status_blocked') }}</span>
                        @endif
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>

    {{ $users->links() }}

@endsection
