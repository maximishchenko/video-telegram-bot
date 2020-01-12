@extends('layouts.app')

@section('content')


    <link href='fullcalendar/packages/core/main.css' rel='stylesheet' />
    <link href='fullcalendar/packages/daygrid/main.css' rel='stylesheet' />
    <link href='fullcalendar/packages/bootstrap/main.css' rel='stylesheet' />

    <script src='chartjs/chart.js@2.8.0'></script>
    <script src='fullcalendar/packages/core/main.js'></script>
    <script src='fullcalendar/packages/core/locales/ru.js'></script>
    <script src='fullcalendar/packages/daygrid/main.js'></script>
    <script src='fullcalendar/packages/bootstrap/main.js'></script>

    <h4>
        {{ trans('messages.dashboard') }}
    </h4>
    <hr>

    <div class="row">
        <div class="col">
            <h5>
                {{ trans('messages.traffic_summary') }}
            </h5>
            <canvas id="trafficSummary"></canvas>
        </div>
        <div class="col">
            <h5>
                {{ trans('messages.traffic_summary_client') }}
            </h5>
            <canvas id="trafficClient"></canvas>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-6">
            <h5>
                {{ trans('messages.connections_src') }}
            </h5>
            <div id="map"></div>
        </div>
        <div class="col-6">
            <div class="container">
                <h5>
                    {{ trans('messages.log_events') }}
                </h5>

                <script>

                    document.addEventListener('DOMContentLoaded', function() {
                        var calendarEl = document.getElementById('calendar');

                        var calendar = new FullCalendar.Calendar(calendarEl, {
                            plugins: [ 'dayGrid', 'bootstrap' ],
                            themeSystem: 'dayGrid',
                            height: 500,
                            theme: 'dayGrid',
                            locale: 'ru',
                            events: {
                                url: '/api/v1/traffic/calendar'
                            },
                            eventLimit: 3,
                            eventClick: function(info) {
                                info.jsEvent.preventDefault(); // don't let the browser navigate

                                if (info.event.id) {
                                    window.open('/admin/vpnlogs/' + info.event.id);
                                }
                            },
                            eventRender: function(info) {
                                console.log(info);
                                if (-1 != info.event.extendedProps.event.indexOf("{{ \App\Shared::CLIENT_DISCONNECT }}")) {
                                    info.el.style.backgroundColor  = "#f0ad4e";
                                    info.el.style.border  = "#f0ad4e";
                                }
                                if(-1 != info.event.extendedProps.event.indexOf("{{ \App\Shared::CLIENT_CONNECT }}")) {
                                    info.el.style.backgroundColor = "#4db24d";
                                    info.el.style.border = "#4db24d";
                                }
                                if(-1 != info.event.extendedProps.event.indexOf("{{ \App\Shared::CLIENT_LOGIN_NOT_FOUND }}")) {
                                    info.el.style.backgroundColor = "#d9534f";
                                    info.el.style.border = "#d9534f";
                                }
                                if(-1 != info.event.extendedProps.event.indexOf("{{ \App\Shared::CLIENT_BLOCKED }}")) {
                                    info.el.style.backgroundColor = "#d9534f";
                                    info.el.style.border = "#d9534f";
                                }
                                if(-1 != info.event.extendedProps.event.indexOf("{{ \App\Shared::CLIENT_GROUP_BLOCKED }}")) {
                                    info.el.style.backgroundColor = "#d9534f";
                                    info.el.style.border = "#d9534f";
                                }
                                if(-1 != info.event.extendedProps.event.indexOf("{{ \App\Shared::CLIENT_PASSWORD_ERROR }}")) {
                                    info.el.style.backgroundColor = "#d9534f";
                                    info.el.style.border = "#d9534f";
                                }

                                    // info.el.style.backgroundColor = "#d9534f";
                                    // info.el.style.border = "#d9534f";
                            },
                        });

                        calendar.render();
                    });
                </script>

                <div id="calendar"></div>
            </div>
        </div>
    </div>

    <script>
        var map;
        function initMap(data) {
            bounds  = new google.maps.LatLngBounds();

            var map = new google.maps.Map(document.getElementById('map'), {
                mapTypeId: google.maps.MapTypeId.TERRAIN,
                disableDefaultUI: true,
            });

            var json = data;
            if (data) {
                for (var i = 0, length = json.length; i < length; i++) {

                    var data = json[i],
                        latLng = new google.maps.LatLng(data.latitude, data.longitude);


                    bounds.extend (latLng);

                    var marker = new google.maps.Marker({
                        position: latLng,
                        map: map,
                        title: data.latitude
                    });
                }
            }
            map.fitBounds(bounds);
            map.panToBounds(bounds);
        }

        $.ajax({
            url:"/api/v1/traffic/sourcemap",
            dataType: "json",
            success:function(data){
                initMap(data);
            },
            error:function(data) {
                console.log('something went wrong');
            }
        });


        $.ajax({
            url:"/api/v1/traffic/client",
            dataType: "json",
            success:function(data){
                var ctx = document.getElementById('trafficClient').getContext('2d');
                var trafficClientChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: window.getColumn(data, 'common_name'),
                        datasets: [{
                            label: "получено, байт",
                            data: window.getColumn(data, 'bytes_received'),
                            backgroundColor: "#3e95cd"
                        }, {
                            label: "передано, байт",
                            data: window.getColumn(data, 'bytes_sent'),
                            backgroundColor: "#c45850"
                        }]
                    },
                });
            }
        });

        $.ajax({
            url:"/api/v1/traffic/summary",
            dataType: "json",
            success:function(data){
                var ctx = document.getElementById('trafficSummary').getContext('2d');
                var trafficSummaryChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: window.getColumn(data, 'date'),
                        datasets: [{
                            label: "получено, байт",
                            data: window.getColumn(data, 'bytes_received'),
                            backgroundColor: "rgba(153,255,51,0.6)"
                        }, {
                            label: "передано, байт",
                            data: window.getColumn(data, 'bytes_sent'),
                            backgroundColor: "rgba(255,153,0,0.6)"
                        }]
                    },
                });
            }
        });
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('app.maps_api_key', 'MAPS_API_KEY') }}&callback=initMap" async defer></script>

@endsection
