@extends('layouts.app-guest', ['class' => 'bg-info', 'activePage' => 'dashboard', 'titlePage' => __('Inicio')])

@section('content')
    <div class="container mt-5" style="height: auto;">
        <div class="row align-items-center">
            <div class="col-md-9 ml-auto mr-auto mt-5 text-center">
                <h3>{{ __('Quiniela Qatar 2022. Modulo de Acceso') }} </h3>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
                <form class="form" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="card card-login card-hidden mt-5">
                        <div class="card-header card-header-primary text-center">
                            <h4 class="card-title"><strong>{{ __('Login') }}</strong></h4>
                        </div>
                        <div class="card-body">
                            <div class="bmd-form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="material-icons">email</i>
                                        </span>
                                    </div>
                                    <input type="email" name="email" class="form-control"
                                        placeholder="{{ __('Email...') }}" value="{{ old('email') }}" required>
                                </div>
                                @if ($errors->has('email'))
                                    <div id="email-error" class="error text-danger pl-3" for="email"
                                        style="display: block;">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="bmd-form-group{{ $errors->has('password') ? ' has-danger' : '' }} mt-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="material-icons">lock_outline</i>
                                        </span>
                                    </div>
                                    <input type="password" name="password" id="password" class="form-control"
                                        placeholder="{{ __('Password...') }}"
                                        value="{{ !$errors->has('password') ? '' : '' }}" required>
                                </div>
                                @if ($errors->has('password'))
                                    <div id="password-error" class="error text-danger pl-3" for="password"
                                        style="display: block;">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="form-check  mt-3">
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}">
                                        <small>{{ __('Olvido la Contraseña?') }}</small>
                                    </a>
                                @endif
                            </div>

                            {{-- <div class="form-check mr-auto ml-3 mt-3">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" name="remember"
                                        {{ old('remember') ? 'checked' : '' }}> {{ __('Remember me') }}
                                    <span class="form-check-sign">
                                        <span class="check"></span></span>
                                </label>
                            </div> --}}
                        </div>
                        <div class="card-footer mx-auto">
                            <button type="submit" class="btn btn-info btn-lg text-white">{{ __('Ingresar') }}</button>
                        </div>
                </form>
            </div>
            <div class="row">
                {{-- <div class="col-6">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-light">
                            <small>{{ __('Forgot password?') }}</small>
                        </a>
                    @endif
                </div> --}}
                {{-- <div class="col-6 text-right">
                    <a href="{{ route('register') }}" class="text-light">
                        <small>{{ __('Create new account') }}</small>
                    </a>
                </div> --}}
            </div>
        </div>
    </div>
@endsection
