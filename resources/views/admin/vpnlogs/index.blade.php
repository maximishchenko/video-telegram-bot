@extends('layouts.app')

@section('content')


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
                    {{ $log->common_name }}
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
