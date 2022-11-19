@extends('layouts.app', ['class' => 'bg-info', 'activePage' => 'dashboard', 'titlePage' => __('Inicio')])

@section('content')
    <div class="content">
        @if (session('message'))
            <div class="card bg-success">
                {{ session('message') }}
            </div>
        @endif
        <div class="container-fluid">
            <div class="row text-center">
                <div class="card bg-info" style="width: 75%; margin-left:15%; margin-top: -10px">
                    <div class="card-header text-center ">
                        <img src="{{ asset('images') }}/logo-mundial.png" height="100"> <br />

                        <span class="text-dark font-bolder h4"> Quiniela Qatar 2022. </span>
                    </div>
                    <div style="text-align:center">
                        <table class="table table-striped table-responsive" style="margin: 0 auto;">
                            <thead>
                                <tr>
                                    <th style="text-align: center"> <a href="#" data-toggle="collapse"
                                            data-target="#demo">Como Participas?</a>
                                    </th>
                                    <th style="text-align: center"> <a href="#" data-toggle="collapse"
                                            data-target="#demo1">Como se Puntua?</a>
                                    </th>
                                    <th style="text-align: center">
                                        @if (!$response['init'])
                                            <a href="{{ route('predictions.index') }}"> Para hacer tus pronosticos haz click
                                                aqui</a>
                                        @else
                                            <a href="{{ route('matchups.results-live') }}"> Click aqui. Para ver las
                                                posiciones
                                            </a>
                                        @endif
                                    </th>
                                    <th> <a href="#" data-toggle="collapse" data-target="#groups">Ver Grupos?</a></th>
                                </tr>
                            </thead>
                            <tbody class="bg-info ">
                                <tr class="bg-info text-black" style="color:black">
                                    <td colspan="4" class="text-center">
                                        <div id="demo" class="collapse text-black">
                                            1. Tienes que registrarte e ingresar al Sistema. <br />
                                            2. Haz tus Pronosticos de los juegos. Genera tu planilla como soporte. <br />
                                            3. Haz el Pago de tu participación e informa al administrador. <br />
                                            4. El Administrador te activara como Participante de la Quiniela. <br />
                                            5. Al ser participante puedes ver los pronosticos de los otros participantes y
                                            los resultados en Vivo. Con posiciones actualizadas. <br />
                                            6. El ganador de la Justa se lleva el 65% del pote, el 25% para el segundo lugar
                                            y 10% para el tercero.
                                        </div>
                                        <div id="demo1" class="collapse">
                                            1. Se otorga un punto al acertar los goles de un equipo.(No importa el resultado
                                            del Juego) <br />
                                            2. Si aciertas el resultado se otorgan 3 puntos. <br />
                                            3. Por encuentro puedes no acumular puntos o sumar 1,3, 4 o 5 puntos(nunca 2)
                                        </div>
                                        <div id="demo2" class="collapse">
                                            1. El monto de la Participació <br />
                                            2. Si aciertas el resultado se otorgan 3 puntos. <br />
                                            3. Por encuentro puedes no acumular puntos o sumar 1,3, 4 o 5 puntos(nunca 2)
                                        </div>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table
                    class="table table-striped collapse
                        table-hover
                        table-borderless
                        table-primary
                        align-middle"
                    id="groups">
                    <thead>
                        <tr>
                            <th style="width: 13%; text-align:center">Grupo A</th>
                            <th style="width: 13%; text-align:center">Grupo B</th>
                            <th style="width: 13%; text-align:center">Grupo C</th>
                            <th style="width: 12%; text-align:center">Grupo D</th>
                            <th style="width: 12%; text-align:center">Grupo E</th>
                            <th style="width: 12%; text-align:center">Grupo F</th>
                            <th style="width: 14%; text-align:center">Grupo G</th>
                            <th style="width: 13%; text-align:center">Grupo H</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $group = '';
                        @endphp
                        <tr class="table-primary">
                            @foreach ($response['teams'] as $team)
                                @if ($group != $team->group)
                                    @if ($group != '')
                                        </dl>
                                        </td>
                                    @endif
                                    <td style="text-align:start">
                                        <dl>
                                            @php
                                                $group = $team->group;
                                            @endphp
                                @endif
                                <dt> <img src="{{ asset('images') }}/{{ $team->url_flag }}" width="20" height="20">
                                    <span style="font-size: 12px"> {{ $team->name }}</span>
                                </dt>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <h6> NOTA IMPORTANTE: Esta pagina esta diseñada como una pagina WEB, si esta usando su Movil se sugiere
                    habilitar la vista de escritorio para una mejor vista</h6>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            // Javascript method's body can be found in assets/js/demos.js
            md.initDashboardPageCharts();
        });
    </script>
@endpush
