@extends('layouts.app')

@section('content')


    <div class="d-flex flex-row mb-3">
        <a href="{{ route('admin.vpnlogs.index') }}" class="btn btn-dark btn-sm mr-1">
            {{ trans('messages.admin_vpnlogs') }}
        </a>
    </div>

    <div class="row">
        @if ($log->country_name)
        <div class="col-md-6">
            @else
                <div class="col-md-12">
                    @endif


    <table class="table table table-bordered">
        <tbody>
        <tr>
            <th>{{ trans('messages.admin_vpnlogs_id') }}</th>
            <td>{{ $log->id }}</td>
        </tr>
        <tr>
            <th>{{ trans('messages.admin_vpnlogs_common_name') }}</th>
            <td>{{ $log->common_name }}</td>
        </tr>
        @if ($log->name !== 'null')
            <tr>
                <th>{{ trans('messages.admin_vpnlogs_name') }}</th>
                <td>{{ $log->name }}</td>
            </tr>
        @endif
        @if ($log->group !== 'null')
            <tr>
                <th>{{ trans('messages.admin_vpnlogs_group_id') }}</th>
                <td>{{ $log->group }}</td>
            </tr>
        @endif
        <tr>
            <th>{{ trans('messages.admin_vpnlogs_event') }}</th>
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
        </tr>
        @if ($log->remote_ip !== 'null')
        <tr>
            <th>{{ trans('messages.admin_vpnlogs_remote_ip') }}</th>
            <td>{{ $log->remote_ip }}</td>
        </tr>
        @endif
        @if ($log->request_ip !== 'null')
            <tr>
                <th>{{ trans('messages.admin_vpnlogs_request_ip') }}</th>
                <td>{{ $log->request_ip }}</td>
            </tr>
        @endif
        @if ($log->bytes_received !== 'null')
            <tr>
                <th>{{ trans('messages.admin_vpnlogs_bytes_received') }}</th>
                <td>{{ $log->bytes_received }}</td>
            </tr>
        @endif
        @if ($log->bytes_sent !== 'null')
            <tr>
                <th>{{ trans('messages.admin_vpnlogs_bytes_sent') }}</th>
                <td>{{ $log->bytes_sent }}</td>
            </tr>
        @endif
        <tr>
            <th>{{ trans('messages.admin_vpnlogs_created_at') }}</th>
            <td>{{ $log->created_at }}</td>
        </tr>
        </tbody>
    </table>

        </div>
        <div class="col-md-6">
            <table class="table table-striped table-bordered">
                @if ($log->country_name)
                <tr>
                    <th>
                        {{ trans('messages.admin_vpnlogs_country') }}
                    </th>
                    <td>
                        {{ $log->country_name }}
                    </td>
                </tr>
                @endif
                @if ($log->region_name)
                <tr>
                    <th>
                        {{ trans('messages.admin_vpnlogs_region') }}
                    </th>
                    <td>
                        {{ $log->region_name }}
                    </td>
                </tr>
                @endif
                @if ($log->city)
                <tr>
                    <th>
                        {{ trans('messages.admin_vpnlogs_city') }}
                    </th>
                    <td>
                        {{ $log->city }}
                    </td>
                </tr>
                @endif
                @if ($log->isp)
                    <tr>
                        <th>
                            {{ trans('messages.admin_vpnlogs_isp') }}
                        </th>
                        <td>
                            {{ $log->isp }}
                        </td>
                    </tr>
                @endif
            </table>

            <div id="map" style="height: 400px"></div>

        </div>
    </div>

    @if ($log->latitude and $log->longitude)
    <script>
        var map;
        function initMap() {
            var lat = {!! $log->latitude !!};
            var lng = {!! $log->longitude !!};
            var myLatLng = {lat: lat, lng: lng};

                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 8,
                    center: myLatLng
                });

                var marker = new google.maps.Marker({
                    position: myLatLng,
                    map: map,
                    title: 'Hello World!'
                });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkUHR03aHGk7zsWlNDQ8MvdCBEfc3mdfA&callback=initMap" async defer></script>
    @endif
@endsection
