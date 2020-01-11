@extends('layouts.app')

@section('breadcrumbs')
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a class="baselink" href="{{ route('home') }}">
                {{ trans('messages.breadcrumbs_homelink') }}
            </a>
        </li>
        <li class="breadcrumb-item">
            <a class="baselink" href="{{ route('admin.users.index') }}">
                {{ trans('messages.admin_users') }}
            </a>
        </li>
        <li class="breadcrumb-item">
            <a class="baselink" href="{{ route('admin.users.show', $user) }}">
                {{ $user->name }}
            </a>
        </li>
        <li class="breadcrumb-item active">
            {{ trans('messages.admin_btn_update') }}
        </li>
    </ul>
@endsection
@section('content')

    <h4>Данные пользователя</h4>
    <div class="offsets-3 col-mds-6">


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
                <input id="phone" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" type="text" name="phone" value="{{ $user->phone }}" required>
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

            @if($user->isUser())

            <h4>
                {{ trans('messages.access_to_groups') }}
            </h4>
            <hr>

            <div class="form-group">
                @foreach($vpngroups as $groupKey => $vpngroup)
                    <div>
                        <input {{ $user->vpngroups->contains($vpngroup->id) ? 'checked' : '' }} type="checkbox" id="{{ $vpngroup->id }}" name="vpngroups[]" value="{{ $vpngroup->id }}">
                        <label for="{{ $vpngroup->id }}">{{ $vpngroup->name }}</label>
                    </div>
                @endforeach
            </div>

            @endif

            <hr>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-dark btn-sm">
                    {{ trans('messages.btn_save') }}
                </button>


                <a class="btn btn-dark btn-sm mr-1" onclick="window.backUrl()" href="javascript:void(0);">
                    {{ trans('messages.go_back') }}
                </a>
                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-dark btn-sm">
                    {{ trans('messages.to_view') }}
                </a>
            </div>
        </form>


    </div>
    <script type="text/javascript">
        window.maskphone('phone', 'phoneFreeFormat');
    </script>
@endsection
