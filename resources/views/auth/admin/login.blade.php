@extends('layouts.admin')
@section('content')
@php $website = \App\Models\Website::find(1); @endphp
<div class="vertical-align-wrap">
    <div class="vertical-align-middle">
        <div class="auth-box ">
                <div class="content">
                    <div class="header">
                        <div class="logo-login text-center"><img src="{{asset('storage/website/login-logo.png')}}" alt="{{$website->title}}"></div>
                    </div>
                    <form method="POST" action="{{ route('admin.loginSubmit') }}" class="form-auth-small">
                        @csrf
                        <div class="form-group">
                            <label for="username" class="control-label sr-only">{{ __('Username') }}</label>
                            <input id="username" type="text" class="form-control {{ $errors->has('username') || $errors->has('email') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') ?: old('email') }}" placeholder="Username" autofocus>
                            @if ($errors->has('username') || $errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('username') ?: $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label sr-only">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password">
                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg btn-block">{{ __('LOGIN') }}</button>
                        <div class="bottom">
                            <span class="text-danger">
                            @if (session('status'))
                                {{ session('status') }}
                            @endif
                            </span>
                        </div>
                    </form>
                </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
@endsection