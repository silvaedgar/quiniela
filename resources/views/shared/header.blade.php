<div class="row">
    @if ($response['is_prediction'])
        <div class="col-sm-8">
            <h4 class="card-title "> {{ $response['header'] }} </h4>
        </div>
        <div class="col-sm-4 justify-content-end ">
            <a href="{{ route('predictions.print', $response['player_id']) }}">
                <button class="btn btn-info"> Imprimir Planilla
                </button> </a>
        </div>
        <div class="col-sm-10">
            <h6>Ingrese los Resultados y Pulse Grabar Pronosticos. Se generara su planilla de pronosticos
            </h6>
        </div>
    @else
        <div class="col-sm-3 col-md-5 col-xl-8">
            <h4 class="card-title "> {{ $response['header'] }}
                @if ($response['method'] == 'players')
                    <a href="{{ route('players.printPredictions') }}" title="Generar Planillas de Jugadores">
                        <i class="fa fa-print " aria-hidden="true"></i>
                    </a>
                @endif
            </h4>
        </div>
    @endif
</div>
