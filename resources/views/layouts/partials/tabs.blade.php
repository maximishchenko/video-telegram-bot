
@guest
@else
<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link {{ (Route::currentRouteName() == 'admin.home') ? ' active' : '' }}" href="{{ route('admin.home') }}">
            {{ trans('messages.dashboard') }}
        </a>
    </li>
    @can('admin')
    <li class="nav-item">
        <a class="nav-link {{ (request()->segment(2) == 'users') ? ' active' : '' }}" href="{{ route('admin.users.index') }}">
            {{ trans('messages.dashboard_admin_users') }}
        </a>
    </li>
    @endcan
    @can('display_clients')
    <li class="nav-item">
        <a class="nav-link {{ (request()->segment(2) == 'vpngroups') ? ' active' : '' }}" href="{{ route('admin.vpngroups.index') }}">
            {{ trans('messages.dashboard_admin_vpngroups') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ (request()->segment(2) == 'vpnusers') ? ' active' : '' }}" href="{{ route('admin.vpnusers.index') }}">
            {{ trans('messages.dashboard_admin_vpnusers') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ (request()->segment(2) == 'vpnlogs') ? ' active' : '' }}" href="{{ route('admin.vpnlogs.index') }}">
            {{ trans('messages.dashboard_admin_vpnlogs') }}
        </a>
    </li>
    @endcan
    <li class="nav-item">
        <a class="nav-link {{ (request()->segment(2) == 'vpnclients') ? ' active' : '' }}" href="{{ route('admin.vpnclients.index') }}">
            {{ trans('messages.dashboard_admin_vpnclients') }}
        </a>
    </li>
</ul>

@endguest
