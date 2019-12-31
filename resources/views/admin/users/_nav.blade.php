
<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.home') }}">
            {{ trans('messages.dashboard') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="{{ route('admin.users.index') }}">
            {{ trans('messages.dashboard_admin_users') }}
        </a>
    </li>
</ul>

