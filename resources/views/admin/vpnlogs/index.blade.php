@extends('layouts.app')

@section('breadcrumbs')
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a class="baselink" href="{{ route('home') }}">
                {{ trans('messages.breadcrumbs_homelink') }}
            </a>
        </li>
        <li class="breadcrumb-item active">
            {{ trans('messages.admin_vpnlogs') }}
        </li>
    </ul>
@endsection

@section('content')
    <h4>
        {{ trans('messages.admin_vpnlogs_list') }}
    </h4>

    <a class="toggleSearchBtn baselink boldlink text-right" href="javascript:void(0);" onclick="window.toggleDiv('search', 'vpnlogs')">
        {{ trans('messages.toggle_search_text') }}
    </a>
    <div class="mb-3" id="search">
            <form action="?" method="GET" autocomplete="off">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="common_name" class="col-form-label">
                                {{ trans('messages.admin_vpnlogs_common_name') }}
                            </label>
                            <input placeholder="" id="common_name" name="common_name" value="{{ request('common_name') }}" class="form-control" type="text">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="event" class="col-form-label">
                                {{ trans('messages.admin_vpnlogs_event') }}
                            </label>
                            <select name="event" id="event" class="form-control">
                                <option value=""></option>
                                @foreach(\App\Shared::getEventsArray() as $value => $label)
                                    <option value="{{ $value }}" {{ $value === request('event') ? ' selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="remote_ip" class="col-form-label">
                                {{ trans('messages.admin_vpnlogs_remote_ip') }}
                            </label>
                            <input placeholder="" id="remote_ip" name="remote_ip" value="{{ request('remote_ip') }}" class="form-control" type="text">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="request_ip" class="col-form-label">
                                {{ trans('messages.admin_vpnlogs_request_ip') }}
                            </label>
                            <input placeholder="" id="request_ip" name="request_ip" value="{{ request('request_ip') }}" class="form-control" type="text">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <button type="submit" class="btn btn-dark btn-sm">
                                {{ trans('messages.btn_search') }}
                            </button>

                            <a class="btn btn-dark btn-sm" href="{{ route('admin.vpnlogs.index') }}">
                                {{ trans('messages.cancel_search') }}
                            </a>
                        </div>
                    </div>
                </div>
            </form>
    </div>

    <div class="row">
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
        <b>{{ trans('messages.count_grid', ['count' => $logs->count(), 'total' => $logs->total()]) }}</b>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>{{ trans('messages.admin_vpnlogs_id') }}</th>
            <th>{{ trans('messages.admin_vpnlogs_common_name') }}</th>
            <th>{{ trans('messages.admin_vpnlogs_name') }}</th>
            <th>{{ trans('messages.admin_vpnlogs_group_id') }}</th>
            <th>{{ trans('messages.admin_vpnlogs_event') }}</th>
            <th>{{ trans('messages.admin_vpnlogs_remote_ip') }}</th>
            <th>{{ trans('messages.admin_vpnlogs_request_ip') }}</th>
            <th>{{ trans('messages.admin_vpnlogs_created_at') }}</th>
        </tr>
        </thead>
        <tbody>

        @foreach($logs as $log)
            <tr>
                <td>
                    {{ $log->id }}
                </td>
                <td>
                    <a class="baselink" href="{{ route('admin.vpnlogs.show', $log) }}">{{ $log->common_name }}</a>
                </td>
                <td>
                    @if ($log->name !== 'null')
                        {{ $log->name }}
                    @endif
                </td>
                <td>
                    @if ($log->group !== 'null')
                        {{ $log->group }}
                    @endif
                </td>
                <td>

                    @if ($log->connected())
                        <span class="badge badge-success">{{ trans('messages.client_connected') }}</span>
                    @endif
                    @if ($log->disconnected())
                        <span class="badge badge-warning">{{ trans('messages.client_disconnected') }}</span>
                    @endif
                    @if ($log->loginIncorrect())
                            <span class="badge badge-danger">{{ trans('messages.event_client_login_not_found') }}</span>
                    @endif
                    @if ($log->loginBlocked())
                        <span class="badge badge-danger">{{ trans('messages.event_client_blocked') }}</span>
                    @endif
                    @if ($log->groupBlocked())
                        <span class="badge badge-danger">{{ trans('messages.event_client_group_blocked') }}</span>
                    @endif
                    @if ($log->passwordError())
                        <span class="badge badge-danger">{{ trans('messages.event_client_password_error') }}</span>
                    @endif
                </td>
                <td>
                    @if ($log->remote_ip !== 'null')
                        {{ $log->remote_ip }}
                    @endif
                </td>
                <td>
                    @if ($log->request_ip !== 'null')
                    {{ $log->request_ip }}
                    @endif
                </td>
                <td>{{ $log->created_at }}</td>

        @endforeach

        </tbody>
    </table>

    {{ $logs->links() }}

    <script>
        window.checkVisibiliti('search', 'vpnlogs');
    </script>

@endsection
