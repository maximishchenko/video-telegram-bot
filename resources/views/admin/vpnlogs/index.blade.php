@extends('layouts.app')

@section('content')

    <div class="card mb-3">
        <div class="card-header">
            Filter
        </div>
        <div class="card-body">
            <form action="?" method="GET" autocomplete="off">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="id" class="col-form-label">
                                {{ trans('messages.admin_vpnlogs_id') }}
                            </label>
                            <input placeholder="" id="id" name="id" value="{{ request('id') }}" class="form-control" type="text">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="common_name" class="col-form-label">
                                {{ trans('messages.admin_vpnlogs_common_name') }}
                            </label>
                            <input placeholder="" id="common_name" name="common_name" value="{{ request('common_name') }}" class="form-control" type="text">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="event" class="col-form-label">
                                {{ trans('messages.admin_vpnlogs_event') }}
                            </label>
                            <select name="event" id="event" class="form-control">
                                <option value=""></option>
                                @foreach(\App\Shared::getEventsArray() as $value => $label)
                                    <option value="{{ $value }}" {{ $value === request('event') ? ' event' : '' }}>
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

                            <a class="btn btn-primary btn-sm" href="{{ route('admin.vpnlogs.index') }}">
                                {{ trans('messages.cancel_search') }}
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>{{ trans('messages.admin_vpnlogs_id') }}</th>
            <th>{{ trans('messages.admin_vpnlogs_common_name') }}</th>
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
                    {{ $log->vpngroup->name }} ({{ $log->common_name }})
                </td>
                <td>

                    @if ($log->connected())
                        <span class="badge badge-success">{{ trans('messages.client_connected') }}</span>
                    @endif
                    @if ($log->disconnected())
                        <span class="badge badge-danger">{{ trans('messages.client_disconnected') }}</span>
                    @endif
                </td>
                <td>{{ $log->remote_ip }}</td>
                <td>{{ $log->request_ip }}</td>
                <td>{{ $log->created_at }}</td>

        @endforeach

        </tbody>
    </table>

    {{ $logs->links() }}

@endsection
