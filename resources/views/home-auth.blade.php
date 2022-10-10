@extends('layouts.app', ['class' => 'bg-info', 'activePage' => 'dashboard', 'titlePage' => __('Inicio')])

@section('content')
    <div class="content">
        @if (session('message'))
            <div class="card bg-success">
                {{ session('message') }}
            </div>
        @endif
        <div class="container-fluid">
            <div class="row">

                <div class="card bg-info" style="width: 75%; margin-left:15%">
                    <div class="card-header text-center ">
                        <span class="text-dark font-bold h4"> Quiniela Qatar 2022.
                            @if (!$response['init'])
                                Para hacer tus pronosticos <a href="{{ route('predictions.index') }}"> haz click aqui</a>
                            @else
                                <a href="{{ route('matchups.results-live') }}"> Click aqui. Para ver las posiciones </a>
                            @endif
                        </span>
                    </div>
                </div>
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
