<div class="sidebar" data-color="orange" data-background-color="white"
    data-image="{{ asset('material') }}/img/sidebar-1.jpg">
    <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
    <div class="logo">
        <div class="text-center">
            <span class="h4"> {{ __('Quiniela') }} </span><br>
        </div>
        <div class="small">
            <div class="row">
                <div class="col-8">
                    <span class="small">Usuario:{{ Auth::user()->name }} </span>
                </div>
                <div class="col-4 small justify-end">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <a class="small justify-end " href="{{ route('my-logout') }}" style="display: inline"
                            onclick="this.closest('form').submit()">
                            <i class="material-icons">logout</i>
                            Salir
                        </a>
                    </form>
                    {{-- Estas 3 lineas son las originales
                    <a class="small justify-end " href="{{ route('my-logout') }}" style="display: inline">
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit()"
                        <i class="material-icons">logout</i> Salir
                    </a> --}}
                </div>
            </div>

        </div>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="nav-item{{ $activePage == 'Inicio' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="material-icons">dashboard</i>
                    <p>{{ __('Menu Principal') }}</p>
                </a>
            </li>
            <li class="nav-item{{ $activePage == 'table' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('predictions.index') }}">
                    <i class="material-icons">content_paste</i>
                    <p>{{ __('Mis Pronosticos') }}</p>
                </a>
            </li>

            @if (auth()->user()->status == 'Activo')
                <li class="nav-item{{ $activePage == 'typography' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('players.index') }}">
                        <i class="material-icons">library_books</i>
                        <p>{{ __('Participantes') }}</p>
                    </a>
                </li>
                <li class="nav-item{{ $activePage == 'typography' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('matchups.results-live') }}">
                        <i class="material-icons">library_books</i>
                        <p>{{ __('Resultados en Vivo') }}</p>
                    </a>
                </li>

                @if (auth()->user()->hasRole('Admin'))
                    <li class="nav-item{{ $activePage == 'icons' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('matchups.results') }}">
                            <i class="material-icons">bubble_chart</i>
                            <p>{{ __('Ingresar Resultados') }}</p>
                        </a>
                    </li>
                    <li class="nav-item{{ $activePage == 'map' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('players.activate') }}">
                            <i class="material-icons">location_ons</i>
                            <p>{{ __('Activar Usuario') }}</p>
                        </a>
                    </li>
                    <li class="nav-item{{ $activePage == 'map' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('matchups.close-date') }}">
                            <i class="material-icons">location_ons</i>
                            <p>{{ __('Cerrar Dia') }}</p>
                        </a>
                    </li>
                @endif
            @else
                <li> Para ver las opciones del Sistema debe realizar el Pago de Inscripcion</li>
            @endif
        </ul>
    </div>
</div>
