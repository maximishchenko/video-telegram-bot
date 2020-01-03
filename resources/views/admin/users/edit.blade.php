@extends('layouts.app')

@section('content')
    @include('admin.users._nav')

    <div class="offset-3 col-md-6">

        <form method="POST" action="{{ route('admin.users.update', $user) }}">
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
                <label for="username" class="col-form-label">{{ trans('messages.admin_users_username') }}</label>
                <input id="username" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" type="text" name="username" value="{{ $user->username }}" required>
                @if ($errors->has('username'))
                    <span class="invalid-feedback"><strong>{{ $errors->first('username') }}</strong></span>
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

            <div class="form-group">
                <label for="role" class="col-form-label">
                    {{ trans('messages.admin_users_role') }}
                </label>

                <select class="form-control{{ $errors->has('role') ? ' is-invalid' : '' }}" name="role" id="role">
                    @foreach(\App\Shared::getRolesArray() as $value => $label)
                        <option value="{{ $value }}"{{ $value === old('role', $user->role) ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <hr>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary btn-sm">
                    {{ trans('messages.btn_save') }}
                </button>

                <a href="{{ route('admin.users.index') }}" class="btn btn-primary btn-sm">
                    {{ trans('messages.breadcrumbs_admin_users') }}
                </a>
                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-primary btn-sm">
                    {{ trans('messages.to_view') }}
                </a>
            </div>
        </form>


    </div>
    <script type="text/javascript">
        window.maskphone('phone', 'phoneFreeFormat');
    </script>
@endsection