@extends('layouts.app')

@section('breadcrumbs')
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a class="baselink" href="{{ route('home') }}">
                {{ trans('messages.breadcrumbs_homelink') }}
            </a>
        </li>
        <li class="breadcrumb-item">
            <a class="baselink" href="{{ route('admin.vpngroups.index') }}">
                {{ trans('messages.breadcrumbs_admin_vpngroups') }}
            </a>
        </li>
        <li class="breadcrumb-item">
            <a class="baselink" href="{{ route('admin.vpngroups.show', $group) }}">
                {{ $group->name }}
            </a>
        </li>
        <li class="breadcrumb-item active">
            {{ trans('messages.admin_btn_update') }}
        </li>
    </ul>
@endsection
@section('content')

    <h4>
        {{ trans('messages.admin_vpngroups_update', ['name' => $group->name]) }}
    </h4>
    <hr>

        <form method="POST" action="{{ route('admin.vpngroups.update', $group) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name" class="col-form-label">{{ trans('messages.admin_vpngroups_name') }}</label>
                <input id="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" type="text" name="name" value="{{ $group->name }}" required>
                @if ($errors->has('name'))
                    <span class="invalid-feedback"><strong>{{ $errors->first('name') }}</strong></span>
                @endif
            </div>
            <div class="form-group">
                <label for="name" class="col-form-label">
                    {{ trans('messages.admin_vpngroups_comment') }}
                </label>

                <textarea id="comment" name="comment" class="form-control{{ $errors->has('comment') ? ' is-invalid' : '' }}"  cols="30" rows="5">
                {{ $group->comment }}
                </textarea>
                @if ($errors->has('comment'))
                    <span class="invalid-feedback"><strong>{{ $errors->first('name') }}</strong></span>
                @endif
            </div>


            <hr>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-dark btn-sm">
                    {{ trans('messages.btn_save') }}
                </button>

                <a href="{{ route('admin.vpngroups.index') }}" class="btn btn-dark btn-sm">
                    {{ trans('messages.vpngroups') }}
                </a>
                <a href="{{ route('admin.vpngroups.show', $group) }}" class="btn btn-dark btn-sm">
                    {{ trans('messages.to_view') }}
                </a>
            </div>
        </form>


@endsection
