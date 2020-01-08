@extends('layouts.app')

@section('content')

    <div class="offset-3 col-md-6">

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


    </div>
@endsection
