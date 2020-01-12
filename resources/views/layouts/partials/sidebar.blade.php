<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
    @if (Auth::check())


        <a class="cbp-title" href="{{ route('profile') }}">
            <h3>
                {{ Auth::user()->name }}
            </h3>
{{--            {{ trans('messages.menu_link_profile') }}--}}
        </a>
    @endif

    <a class="{{ (Route::currentRouteName() == 'admin.home') ? 'active' : '' }}" href="{{ route('admin.home') }}">
        {{ trans('messages.dashboard') }}
    </a>
    @can('admin')
        <a class="{{ (request()->segment(2) == 'users') ? ' active' : '' }}" href="{{ route('admin.users.index') }}">
            {{ trans('messages.dashboard_admin_users') }}
        </a>
    @endcan
    @can('display_clients')
        <a class="{{ (request()->segment(2) == 'vpngroups') ? ' active' : '' }}" href="{{ route('admin.vpngroups.index') }}">
            {{ trans('messages.dashboard_admin_vpngroups') }}
        </a>

        <a class="{{ (request()->segment(2) == 'vpnusers') ? ' active' : '' }}" href="{{ route('admin.vpnusers.index') }}">
            {{ trans('messages.dashboard_admin_vpnusers') }}
        </a>
        <a class="{{ (request()->segment(2) == 'vpnlogs') ? ' active' : '' }}" href="{{ route('admin.vpnlogs.index') }}">
            {{ trans('messages.dashboard_admin_vpnlogs') }}
        </a>
    @endcan
    <a class="{{ (request()->segment(2) == 'vpnclients') ? ' active' : '' }}" href="{{ route('admin.vpnclients.index') }}">
        {{ trans('messages.dashboard_admin_vpnclients') }}
    </a>
    <a class="logout-sidebar" href="{{ route('logout') }}"
        onclick="event.preventDefault();
        document.getElementById('logout-form').submit();">
            {{ trans('messages.menu_link_logout') }}
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</nav>
