@extends('layouts.app')

@section('content')

    <div class="card mb-3">
        <div class="card-body" id="vpngroups-search">
            <form action="?" method="GET" autocomplete="off">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="id" class="col-form-label">
                                {{ trans('messages.admin_vpnclients_id') }}
                            </label>
                            <input placeholder="" id="id" name="id" value="{{ request('id') }}" class="form-control" type="text">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="name" class="col-form-label">
                                {{ trans('messages.admin_vpnclients_name') }}
                            </label>
                            <input placeholder="" id="name" name="name" value="{{ request('name') }}" class="form-control" type="text">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="protocol" class="col-form-label">
                                {{ trans('messages.admin_vpnclients_protocol') }}
                            </label>

                            <select class="form-control" name="protocol" id="protocol">
                                <option value=""></option>
                                @foreach(\App\Shared::getProtocolsArray() as $value => $label)
                                    <option value="{{ $value }}" {{ $value === request('protocol')  ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="host" class="col-form-label">
                                {{ trans('messages.admin_vpnclients_host') }}
                            </label>
                            <input placeholder="" id="host" name="host" value="{{ request('host') }}" class="form-control" type="text">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="port" class="col-form-label">
                                {{ trans('messages.admin_vpnclients_port') }}
                            </label>
                            <input placeholder="" id="port" name="port" value="{{ request('port') }}" class="form-control" type="number">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="status" class="col-form-label">
                                {{ trans('messages.admin_vpnclients_status') }}
                            </label>
                            <select name="status" id="status" class="form-control">
                                <option value=""></option>
                                @foreach(\App\Shared::getShortStatusesArray() as $value => $label)
                                    <option value="{{ $value }}" {{ $value === request('status') ? ' selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-sm">
                                {{ trans('messages.btn_search') }}
                            </button>

                            <a class="btn btn-primary btn-sm" href="{{ route('admin.vpnclients.index') }}">
                                {{ trans('messages.cancel_search') }}
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="d-flex flex-row mb-3">
        @can('admin')
        <a href="{{ route('admin.vpnclients.create') }}" class="btn btn-primary btn-sm mr-1">
            {{ trans('messages.admin_btn_create') }}
        </a>
        @endcan
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
        <b>{{ trans('messages.count_grid', ['count' => $clients->count(), 'total' => $clients->total()]) }}</b>


    </div>



    <table class="table table-bordered">
        <thead>
        <tr>
            <th>{{ trans('messages.admin_vpnclients_id') }}</th>
            <th>{{ trans('messages.admin_vpnclients_name') }}</th>
            <th>{{ trans('messages.admin_vpnclients_server') }}</th>
            <th>{{ trans('messages.admin_vpnclients_comment') }}</th>
            <th>{{ trans('messages.admin_vpnclients_status') }}</th>
        </tr>
        </thead>
        <tbody>

        @foreach($clients as $client)
            <tr>
                <td>{{ $client->id }}</td>
                <td>
                    <a href="{{ route('admin.vpnclients.show', $client) }}">{{ $client->name }}</a>
                </td>
                <td>{{ $client->getServerUri() }}</td>
                <td>{{ $client->comment }}</td>
                <td>

                    @if ($client->isActive())
                        <span class="badge badge-success">{{ trans('messages.status_active') }}</span>
                    @else
                        <span class="badge badge-danger">{{ trans('messages.status_blocked') }}</span>
                    @endif
                </td>

        @endforeach

        </tbody>
    </table>

    {{ $clients->links() }}

    <script>
    </script>
@endsection
