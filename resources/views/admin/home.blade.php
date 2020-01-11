@extends('layouts.app')

@section('content')

    <div class="row">

        <style>
            .card-lnk {
                margin: 0.05rem;
                text-decoration: none;
                color: #000;
            }
            a.cards-lnk:hover {
                text-decoration: none;
            }
            .blockquote {

                font-size: 14px;
            }
        </style>


        @can('admin')
        <div class="col-md-2">
            <a class="cards-lnk" href="{{ route('admin.users.index') }}">
            <div class="card mxs-auto">
                <div class="card-body card-lnk">
                    <blockquote class="blockquote mb-0 text-center">
                        <p>
                            {{ trans('messages.dashboard_manage_system_users') }}
                        </p>
                    </blockquote>
                </div>
            </div>
        </a>
        </div>
        @endcan
        @can('display_clients')
        <div class="col-md-2">
            <a class="cards-lnk" href="{{ route('admin.vpngroups.index') }}">
            <div class="card mxs-auto">
                <div class="card-body card-lnk">
                    <blockquote class="blockquote mb-0 text-center">
                        <p>
                            {{ trans('messages.dashboard_manage_vpn_groups') }}
                        </p>
                    </blockquote>
                </div>
            </div>
            </a>
        </div>
        <div class="col-md-2">
            <a class="cards-lnk" href="{{ route('admin.vpnusers.index') }}">
            <div class="card mxs-auto">
                <div class="card-body card-lnk">
                    <blockquote class="blockquote mb-0 text-center">
                        <p>
                            {{ trans('messages.dashboard_manage_vpn_users') }}
                        </p>
                    </blockquote>
                </div>
            </div>
            </a>
        </div>
        <div class="col-md-2">
            <a class="cards-lnk" href="{{ route('admin.vpnlogs.index') }}">
                <div class="card mxs-auto">
                    <div class="card-body card-lnk">
                        <blockquote class="blockquote mb-0 text-center">
                            <p>
                                {{ trans('messages.dashboard_manage_vpn_log') }}
                            </p>
                        </blockquote>
                    </div>
                </div>
            </a>
        </div>
        @endcan
        <div class="col-md-2">
            <a class="cards-lnk" href="{{ route('admin.vpnclients.index') }}">
                <div class="card mxs-auto">
                    <div class="card-body card-lnk">
                        <blockquote class="blockquote mb-0 text-center">
                            <p>
                                {{ trans('messages.dashboard_manage_vpn_config') }}
                            </p>
                        </blockquote>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-2"></div>

    </div>

    <div class="clearfix"></div>

    @can('admin')
    @if(!empty($coordinates))
    <div class="rows">

        <div>
            <br>
            <h2 class="text-center">География подключений</h2>
            <hr>
        </div>


        <div id="map" style="height: 600px"></div>
    </div>

    <script>
        var map;
        function initMap() {
            var lat = 44.0486;
            var lng = 43.0594;


            bounds  = new google.maps.LatLngBounds();


            var json = {!! json_encode($coordinates) !!};
            var myLatLng = {lat: lat, lng: lng};

            var map = new google.maps.Map(document.getElementById('map'), {
                mapTypeId: google.maps.MapTypeId.TERRAIN,
                disableDefaultUI: true,
            });


            for (var i = 0, length = json.length; i < length; i++) {

                var data = json[i],
                    latLng = new google.maps.LatLng(data.latitude, data.longitude);


                bounds.extend (latLng);

                var marker = new google.maps.Marker({
                    position: latLng,
                    map: map,
                    title: data.city
                });
            }
            map.fitBounds(bounds);
            map.panToBounds(bounds);
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('app.maps_api_key', 'MAPS_API_KEY') }}&callback=initMap" async defer></script>

    @endif
    @endcan
@endsection
