@extends('layouts.app')

@section('content')

    <div class="offset-3 col-md-6">
        <form method="POST" action="{{ route('admin.vpngroups.store') }}" autocomplete="off">
            @csrf

            <div class="form-group">
                <label for="name" class="col-form-label">
                    {{ trans('messages.admin_vpngroups_name') }}
                </label>
                <input id="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" type="text" name="name" value="{{ old('name') }}" required>
                @if ($errors->has('name'))
                    <span class="invalid-feedback"><strong>{{ $errors->first('name') }}</strong></span>
                @endif
            </div>
            <div class="form-group">
                <label for="name" class="col-form-label">
                    {{ trans('messages.admin_vpngroups_comment') }}
                </label>

                <textarea id="comment" name="comment" value="{{ old('comment') }}" class="form-control{{ $errors->has('comment') ? ' is-invalid' : '' }}"  cols="30" rows="5">
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

                <a class="btn btn-dark btn-sm" href="{{ route('admin.vpngroups.index') }}">
                    {{ trans('messages.breadcrumbs_admin_vpngroups') }}
                </a>
            </div>
        </form>

    </div>

@endsection
