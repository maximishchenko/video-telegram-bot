@extends('layouts.app')

@section('content')
    <div class="row">

        <style>
            .card-lnk {
                margin: 5rem;
                text-decoration: none;
                color: #000;
            }
            a.cards-lnk:hover {
                text-decoration: none;
            }
        </style>

    <div class="col-md-4">
        <a class="cards-lnk" href="{{ route('admin.users.index') }}">
        <div class="card mxs-auto">
            <div class="card-body card-lnk">
                <blockquote class="blockquote mb-0 text-center">
                    <p>Управление пользователями системы</p>
                </blockquote>
            </div>
        </div>
    </a>
    </div>
    <div class="col-md-4">
        <a class="cards-lnk" href="{{ route('admin.vpngroups.index') }}">
        <div class="card mxs-auto">
            <div class="card-body card-lnk">
                <blockquote class="blockquote mb-0 text-center">
                    <p>Управление группами пользователей OpenVPN</p>
                </blockquote>
            </div>
        </div>
        </a>
    </div>
    <div class="col-md-4">
        <a class="cards-lnk" href="{{ route('admin.vpnusers.index') }}">
        <div class="card mxs-auto">
            <div class="card-body card-lnk">
                <blockquote class="blockquote mb-0 text-center">
                    <p>Управление пользователями OpenVPN</p>
                </blockquote>
            </div>
        </div>
        </a>
    </div>

    </div>

@endsection
