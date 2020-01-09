@extends('layouts.app')

@section('content')

    <div class="offset-3 col-md-6">
{{--        --}}
        <form method="POST" action="{{ route('admin.vpnclients.store') }}" enctype="multipart/form-data" autocomplete="off">
            @csrf

            <div class="form-group">
                <label for="name" class="col-form-label">
                    {{ trans('messages.admin_vpnclients_name') }}
                </label>
                <input id="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" type="text" name="name" value="{{ old('name') }}" required>
                @if ($errors->has('name'))
                    <span class="invalid-feedback"><strong>{{ $errors->first('name') }}</strong></span>
                @endif
            </div>

            <div class="form-group">
                <label for="protocol" class="col-form-label">
                    {{ trans('messages.admin_vpnclients_protocol') }}
                </label>

                <select class="form-control{{ $errors->has('protocol') ? ' is-invalid' : '' }}" name="protocol" id="protocol">
                    <option value=""></option>
                    @foreach(\App\Shared::getProtocolsArray() as $value => $label)
                        <option value="{{ $value }}" {{ $value === old('protocol') ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="name" class="col-form-label">
                    {{ trans('messages.admin_vpnclients_host') }}
                </label>
                <input id="name" class="form-control{{ $errors->has('host') ? ' is-invalid' : '' }}" type="text" name="host" value="{{ old('host') }}" required>
                @if ($errors->has('host'))
                    <span class="invalid-feedback"><strong>{{ $errors->first('host') }}</strong></span>
                @endif
            </div>
            <div class="form-group">
                <label for="name" class="col-form-label">
                    {{ trans('messages.admin_vpnclients_port') }}
                </label>
                <input id="name" class="form-control{{ $errors->has('port') ? ' is-invalid' : '' }}" type="number" name="port" value="{{ old('port') }}" required>
                @if ($errors->has('port'))
                    <span class="invalid-feedback"><strong>{{ $errors->first('port') }}</strong></span>
                @endif
            </div>





            <div class="form-group">
                <div class="custom-file mb-3">
                    <input type="file" class="custom-file-input{{ $errors->has('ca_file') ? ' is-invalid' : '' }}" id="ca_file" name="ca_file" value="{{ old('ca_file') }}">
                    <label class="custom-file-label ca-file-label" for="ca_file">
                        {{ trans('messages.admin_vpnclients_ca_file') }}
                    </label>
                    @if ($errors->has('ca_file'))
                        <span class="invalid-feedback"><strong>{{ $errors->first('ca_file') }}</strong></span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="custom-file mb-3">
                    <input type="file" class="custom-file-input{{ $errors->has('cert_file') ? ' is-invalid' : '' }}" id="cert_file" name="cert_file" value="{{ old('cert_file') }}">
                    <label class="custom-file-label" for="cert_file">
                        {{ trans('messages.admin_vpnclients_cert_file') }}
                    </label>
                </div>
                @if ($errors->has('cert_file'))
                    <span class="invalid-feedback"><strong>{{ $errors->first('cert_file') }}</strong></span>
                @endif
            </div>
            <div class="form-group">
                <div class="custom-file mb-3">
                    <input type="file" class="custom-file-input{{ $errors->has('key_file') ? ' is-invalid' : '' }}" id="key_file" name="key_file" value="{{ old('key_file') }}">
                    <label class="custom-file-label" for="key_file">
                        {{ trans('messages.admin_vpnclients_key_file') }}
                    </label>
                </div>
                @if ($errors->has('key_file'))
                    <span class="invalid-feedback"><strong>{{ $errors->first('key_file') }}</strong></span>
                @endif
            </div>




            <div class="form-group">
                <label for="name" class="col-form-label">
                    {{ trans('messages.admin_vpnclients_comment') }}
                </label>

                <textarea id="comment" name="comment" class="form-control{{ $errors->has('comment') ? ' is-invalid' : '' }}" cols="30" rows="5">
                    {{ old('comment') }}
                </textarea>
                @if ($errors->has('comment'))
                    <span class="invalid-feedback"><strong>{{ $errors->first('comment') }}</strong></span>
                @endif
            </div>


            <hr>

            <div class="form-group text-center">
                <button type="submit" class="btn btn-dark btn-sm">
                    {{ trans('messages.btn_save') }}
                </button>

                <a class="btn btn-dark btn-sm" href="{{ route('admin.vpnusers.index') }}">
                    {{ trans('messages.admin_vpnusers') }}
                </a>
            </div>
        </form>

    </div>
    <script>
        window.fileInputGetName("ca_file");
        window.fileInputGetName("cert_file");
        window.fileInputGetName("key_file");
    </script>
@endsection
