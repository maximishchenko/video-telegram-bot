@extends('layouts.app')

@section('content')
    @include('admin.users._nav')

    <div class="d-flex flex-row mb-3">
        <a href="{{ route('admin.users.create') }}" class="btn btn-outline-dark btn-sm mr-1">
            {{ trans('messages.admin_btn_create') }}
        </a>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <td>{{ trans('messages.admin_users_id') }}</td>
                <td>{{ trans('messages.admin_users_name') }}</td>
                <td>{{ trans('messages.admin_users_username') }}</td>
                <td>{{ trans('messages.admin_users_email') }}</td>
                <td>{{ trans('messages.admin_users_sort') }}</td>
                <td>{{ trans('messages.admin_users_status') }}</td>
            </tr>
        </thead>
        <tbody>

            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td><a href="{{ route('admin.users.show', $user) }}">{{ $user->name }}</a></td>
                    <td>{{ $user->username }}</td>
                    <td><a href="mailto://{{ $user->email }}">{{ $user->email }}</a></td>
                    <td>{{ $user->sort }}</td>
                    <td>
                        @if ($user->status == \App\Shared::STATUS_ACTIVE)
                            <span class="badge badge-success">{{ trans('messages.status_active') }}</span>
                        @endif
                        @if ($user->status == \App\Shared::STATUS_WAIT)
                            <span class="badge badge-warning">{{ trans('messages.status_wait') }}</span>
                        @endif
                        @if ($user->status == \App\Shared::STATUS_BLOCKED)
                            <span class="badge badge-danger">{{ trans('messages.status_blocked') }}</span>
                        @endif
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>

    {{ $users->links() }}

@endsection
