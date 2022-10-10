<div class="row">
    <div class="col-sm-3 col-md-5 col-xl-6">
        <h4 class="card-title "> {{ $response['header'] }} </h4>
    </div>
    <div class="col-sm-8 col-md-6 col-xl-6 justify-content-end ">
        @if ($response['is_prediction'])
            <a href="{{ route('predictions.print', $response['player_id']) }}">
                <button class="btn btn-info"> Imprimir Planilla
                </button> </a>
        @endif

    </div>
</div>
