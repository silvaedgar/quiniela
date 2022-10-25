@extends('layouts.app', ['activePage' => 'users', 'titlePage' => __('Modulo de Usuarios'), 'enableNavBar' => 'true'])
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('css') }}/styles.css" rel="stylesheet">
@endsection
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="post" action="{{ route('user.update', $user) }}" autocomplete="off"
                        class="form-horizontal">
                        @csrf
                        @method('put')
                        <div class="card ">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">{{ __('Editar Usuario') }}</h4>
                                <p class="card-category">{{ __('Detalle del Usuario') }}</p>
                            </div>
                            <div class="card-body ">
                                @include('users.form')
                            </div>
                            <div class="card-footer ml-auto mr-auto">
                                <button type="submit" class="btn btn-primary">{{ __('Grabar Usuario') }}</button>
                            </div>
                            <a href="{{ route('user.index') }}"> {{ __('Volver al listado') }} </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
