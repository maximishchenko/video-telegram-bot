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

    </div>

@endsection
