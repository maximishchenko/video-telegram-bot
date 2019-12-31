@extends('layouts.app')

@section('content')
    @include('admin.users._nav')

    <div class="d-flex flex-row mb-3">
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-dark btn-sm mr-1">
            {{ trans('messages.breadcrumbs_admin_users') }}
        </a>
        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline-dark btn-sm mr-1">
            {{ trans('messages.admin_btn_update') }}
        </a>


        <form method="post" action="{{ route('admin.users.changeStatus', $user) }}" class="mr-1" onSubmit="return confirm(' {{ $user->changeStatusConfirmMessage() }} ');">
            @csrf
            <button class="btn btn-outline-dark btn-sm">
                {{ trans('messages.admin_btn_change_status') }}
            </button>
        </form>

        <form method="post" action="{{ route('admin.users.update', $user) }}" class="mr-1" onSubmit="return confirm(' {{ trans('messages.delete_confirm') }} ');">
            @csrf
            @method('DELETE')
            <button class="btn btn-outline-dark btn-sm">
                {{ trans('messages.admin_btn_delete') }}
            </button>
        </form>
    </div>

    <table class="table table table-bordered">
        <tbody>
            <tr>
                <th>{{ trans('messages.admin_users_id') }}</th>
                <td>{{ $user->id }}</td>
            </tr>
            <tr>
                <th>{{ trans('messages.admin_users_name') }}</th>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <th>{{ trans('messages.admin_users_username') }}</th>
                <td>{{ $user->username }}</td>
            </tr>
            <tr>
                <th>{{ trans('messages.admin_users_email') }}</th>
                <td><a href="mailto://{{ $user->email }}">{{ $user->email }}</a></td>
            </tr>
            <tr>
                <th>{{ trans('messages.admin_users_sort') }}</th>
                <td>{{ $user->sort }}</td>
            </tr>
            <tr>
                <th>{{ trans('messages.admin_users_status') }}</th>
                <td>
                    @if ($user->isActive())
                        <span class="badge badge-success">
                            {{ trans('messages.status_active') }}
                        </span>
                    @endif
                    @if ($user->isWait())
                        <span class="badge badge-warning">
                            {{ trans('messages.status_wait') }}
                        </span>
                    @endif
                    @if ($user->isBlocked())
                        <span class="badge badge-danger">
                            {{ trans('messages.status_blocked') }}
                        </span>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>

@endsection
