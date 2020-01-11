@extends('layouts.app')

@section('content')

    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

    <h4>Dashboard</h4>

    <div class="row">
        <div class="col">
            <canvas id="trafficSummary"></canvas>
        </div>
        <div class="col">
            <canvas id="trafficClient"></canvas>
        </div>
    </div>
    <div class="row">

    </div>

    @if(!empty($coordinates))
        <div id="map" style="height: 400px"></div>
    @endif

    <script>
        var map;
        function initMap() {
            bounds  = new google.maps.LatLngBounds();


            var json = {!! json_encode($coordinates) !!};

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



        $.ajax({
            url:"/api/traffic/client",
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
                            backgroundColor: "rgba(153,255,51,0.6)"
                        }, {
                            label: "передано, байт",
                            data: window.getColumn(data, 'bytes_sent'),
                            backgroundColor: "rgba(255,153,0,0.6)"
                        }]
                    },
                    options: {
                        title: {
                            display: true,
                            text: "Объем трафика клиентов (последние 30 дней)"
                        }
                    }
                });
            }
        });



        $.ajax({
            url:"/api/traffic/summary",
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
                    options: {
                        title: {
                            display: true,
                            text: "Объем трафика (последние 30 дней)"
                        }
                    }
                });
            }
        });
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('app.maps_api_key', 'MAPS_API_KEY') }}&callback=initMap" async defer></script>

@endsection
