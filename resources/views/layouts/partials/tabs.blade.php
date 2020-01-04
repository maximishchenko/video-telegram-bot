
<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link {{ (Route::currentRouteName() == 'admin.home') ? ' active' : '' }}" href="{{ route('admin.home') }}">
            {{ trans('messages.dashboard') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ (request()->segment(2) == 'users') ? ' active' : '' }}" href="{{ route('admin.users.index') }}">
            {{ trans('messages.dashboard_admin_users') }}
        </a>
    </li>
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
</ul>

