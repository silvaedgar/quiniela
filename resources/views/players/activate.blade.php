@extends('layouts.app', ['activePage' => 'maintenance', 'titlePage' => __('Activar Jugadores')])

@section('css')
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="content" style="margin-top: 40px">
        <div class="row mt-2">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        @include('shared.header')
                    </div>
                    <div class="card-body mt-1">
                        <form action="{{ route('players.store') }}" method="post">
                            @csrf
                            <div class="row">
                                <table class="table-sm mx-auto table-hover table-striped text-primary mt-2" id="data-table"
                                    style="width: 80%">
                                    <thead class=" text-primary">
                                        {{-- class="table table-striped table-inverse table-responsive shadow"
                                style="width:100%; background-color: #f9f9f9"> --}}
                                        <tr class="bg-info">
                                            <th style="text-align:center">Item</th>
                                            <th style="text-align:center">Usuario</th>
                                            <th style="text-align:center">Activar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($response['players'] as $i => $player)
                                            <tr>
                                                <td style="text-align:center">
                                                    {{ $loop->iteration }}
                                                </td>

                                                <td style="text-align:center">
                                                    {{ $player->name }}
                                                </td>
                                                <td style="text-align:center">
                                                    <input type="checkbox" name="activate_id[]" value="{{ $player->id }}">
                                                </td>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="card-footer ml-auto mr-auto">
                                    <button type="submit" class="btn btn-primary">{{ __('Activar Usuario') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection('content')

@push('js')
    <script src="{{ asset('js') }}/functions.js"></script>
    <script>
        function otherTable(player) {
            let item = 0;
            let balance = 0;
            let table = document.getElementById('table-predictions-player')
            let tag = document.getElementsByTagName("th");
            tag[2].innerHTML = "Pronostico: " + player.players.name
            let predictions = player.prediction_details
            predictions.forEach(element => {
                var row = table.insertRow(item + 1);
                row.className = backgroundRow(element.matchup.status)
                flag =
                    '<img src="' + element.matchup.team_a.url_flag + '" width="20" height="20" alt="" /> '
                createCell(element.matchup.team_a.group, row, 0, 'center')
                createCell(element.matchup.stadium.place, row, 1, 'center')
                createCell(element.matchup.stadium.name, row, 2, 'center')
                createCell(flag + element.matchup.team_a.name, row, 3, 'end')
                message = element.goals_team_a + ' -- ' + element.goals_team_b + " " +
                    element.matchup.team_b.name
                flag = '<img src="' + element.matchup.team_b.url_flag + '" width="20" height="20" alt="" /> '
                createCell(message + flag, row, 4, 'start')
                createCell(element.points, row, 5, 'start')

                item++;
            })
        }
    </script>
@endpush
