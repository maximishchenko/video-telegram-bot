@extends('layouts.app')

@section('content')

    <div class="offset-3 col-md-6">

        <form method="POST" action="{{ route('profile.update', ['id' => $user]) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name" class="col-form-label">{{ trans('messages.admin_users_name') }}</label>
                <input id="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" type="text" name="name" value="{{ $user->name }}" required>
                @if ($errors->has('name'))
                    <span class="invalid-feedback"><strong>{{ $errors->first('name') }}</strong></span>
                @endif
            </div>
            <div class="form-group">
                <label for="phone" class="col-form-label">{{ trans('messages.admin_users_phone') }}</label>
                <input id="phone" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" type="text" name="phone" value="{{ $user->phone }}" required>
                @if ($errors->has('phone'))
                    <span class="invalid-feedback"><strong>{{ $errors->first('phone') }}</strong></span>
                @endif
            </div>
            <div class="form-group row">
                <div class="offsets-3 col-md-6">
                    <input type="checkbox" id="phoneFreeFormat"
                           onchange="maskphone('phone', 'phoneFreeFormat')"
                    >
                    <label for="phoneFreeFormat">Ввести в свободном формате</label>
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="col-form-label">{{ trans('messages.admin_users_email') }}</label>
                <input id="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" type="email" name="email" value="{{ $user->email }}" required>
                @if ($errors->has('email'))
                    <span class="invalid-feedback"><strong>{{ $errors->first('email') }}</strong></span>
                @endif
            </div>

            <hr>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary btn-sm">
                    {{ trans('messages.btn_save') }}
                </button>
                <a href="{{ route('profile') }}" class="btn btn-primary btn-sm">
                    {{ trans('messages.to_profile') }}
                </a>
            </div>
        </form>


    </div>
    <script type="text/javascript">
        window.maskphone('phone', 'phoneFreeFormat');
    </script>
@endsection
