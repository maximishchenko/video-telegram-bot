@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>{{ trans('messages.change_client_password') }}</h3>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.vpnusers.setpassword', $user) }}">
                            @csrf

                            <div class="form-group row">
                                <div class="offset-3 col-md-6">
                                    <input id="password_plain" placeholder="{{ trans('messages.register_password') }}" type="password" class="form-control @error('password_plain') is-invalid @enderror" name="password_plain" required autocomplete="off">

                                    @error('password_plain')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="offset-3 col-md-6">
                                    <input id="password_plain-confirm" placeholder="{{ trans('messages.register_password_confirm') }}" type="password" class="form-control" name="password_plain_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-3">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block">
                                        {{ trans('messages.admin_btn_password') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
