@extends('layouts.app')

@section('content')


        <h4>
            {{ $user->name }} ({{ $user->login }})
        </h4>
        <hr>

        <div class="alert alert-info text-center">
            {{ trans('messages.edit_vpnuser_msg') }}
        </div>

        <form method="POST" action="{{ route('admin.vpnusers.update', $user) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name" class="col-form-label">{{ trans('messages.admin_vpnusers_name') }}</label>
                <input id="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" type="text" name="name" value="{{ $user->name }}" required>
                @if ($errors->has('name'))
                    <span class="invalid-feedback"><strong>{{ $errors->first('name') }}</strong></span>
                @endif
            </div>
            <div class="form-group">
                <label for="name" class="col-form-label">
                    {{ trans('messages.admin_vpngroups_comment') }}
                </label>

                <textarea id="comment" name="comment" class="form-control{{ $errors->has('comment') ? ' is-invalid' : '' }}"  cols="30" rows="5">
                {{ $user->comment }}
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

                <a href="{{ route('admin.vpnusers.index') }}" class="btn btn-dark btn-sm">
                    {{ trans('messages.vpngroups') }}
                </a>
                <a href="{{ route('admin.vpnusers.show', $user) }}" class="btn btn-dark btn-sm">
                    {{ trans('messages.to_view') }}
                </a>
            </div>
        </form>

@endsection
