@extends('layouts.app', ['activePage' => 'sales', 'titlePage' => __('Resultados en Vivo')])

@section('css')
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css" rel="stylesheet">
@endsection

{{-- HTML que muestra los juegos de resultados en vivo solo muestra los juegos del dia y
    las posiciones actualizadas del momento, metodo resultsLive de Matchup --}}

@section('content')
    <div class="content" style="margin-top: 40px">
        <div class="row mt-2">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        @include('shared.header')
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-sm-3">
                                <table
                                    class="table-sm table-hover text-primary mt-2
                                        table-bordered table-striped  "
                                    id="players-table" style="width: 100%">
                                    <thead class=" text-primary">
                                        <tr class="bg-success">
                                            <th colspan="3" class="text-center">Posiciones Actualizadas</th>
                                        </tr>
                                        <tr class="bg-info">
                                            <th style="text-align: center">Pos.</th>
                                            <th style="text-align:center">Jugador</th>
                                            <th style="text-align:center">Puntos</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($response['positions'] as $i => $player)
                                            <tr>
                                                <td> {{ $loop->iteration }}</td>
                                                <td style="text-align:center">
                                                    {{ $player->name }}
                                                </td>
                                                <td style="text-align:center">
                                                    {{ $player->points }}
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-1"></div>
                            <div class="col-sm-8">
                                <div class="cardBody">
                                    <div class="row">
                                        <div class="ml-3 col-sm-2 bg-danger text-white"> Finalizado</div>
                                        <div class="ml-3 col-sm-2 bg-warning"> En Proceso</div>
                                        <div class="ml-3 col-sm-2"> Pendiente</div>
                                    </div>
                                    <table class="table-sm table-hover text-primary mt-2" id="matchups"
                                        style="width: 100%">
                                        <thead class=" text-primary">
                                            <tr class="bg-info text-center">
                                                <th> Grupo </th>
                                                <th> Ciudad </th>
                                                <th> Estadio </th>
                                                <th colspan="2" class="text-center"> Paises </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($response['matchups'] as $prediction)
                                                @include('shared.table-details-matchups')
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection('content')

@push('js')
    <script src="{{ asset('js') }}/functions.js"></script>
    <script>
        // document.addEventListener('DOMContentLoaded', documentLoad, false);

        setInterval(() => {
            fillTables()
        }, 5000);

        function fillTables() {
            fetch('/quiniela/public/api/positions')
                .then(resp => {
                    return resp.json();
                })
                .then(resp => {
                    console.log("POSITION ", resp)
                    let positions = resp.positions;
                    let table = document.getElementById('players-table')
                    deleteTable(table)
                    var row = table.insertRow();
                    row.className = 'bg-info'
                    createCell('Pos.', row, 0, 'center')
                    createCell('Jugador', row, 1, 'center')
                    createCell('Puntos', row, 2, 'center')
                    let index = 0;
                    positions.forEach(element => {
                        var row = table.insertRow();
                        createCell(index + 1, row, 0, 'center')
                        createCell(element.name, row, 1, 'center')
                        createCell(element.points, row, 2, 'center')
                        index++
                    });
                    let matchups = resp.matchups;

                    table = document.getElementById('matchups')
                    console.log("TABLA: ", matchups)
                    deleteTable(table)
                    matchups.forEach(element => {
                        var row = table.insertRow();
                        row.className = backgroundRow(element.status)
                        $flag =
                            '<img src="' + element.team_a.url_flag + '" width="20" height="20" alt="" /> '
                        createCell(element.team_a.group, row, 0, 'center')
                        createCell(element.stadium.place, row, 1, 'center')
                        createCell(element.stadium.name, row, 2, 'center')
                        createCell($flag + element.team_a.name, row, 3, 'end')
                        $message = element.goals_team_a + ' -- ' + element.goals_team_b + " " + element.team_b
                            .name
                        $flag = '<img src="' + element.team_b.url_flag + '" width="20" height="20" alt="" /> '
                        createCell($message + $flag, row, 4, 'start')
                    })
                })
        }

        function gamesDate(games) {
            let date = document.getElementById('date').value
            let table = document.getElementById('games')
            deleteTable(table)
            let dateGames = games.prediction_details;
            //             [{name:"js"},{name:"nodejs"},{name:"gql"},{name:"python"}]
            dateGames = dateGames.filter(item => item.matchup.game_date === date);
            console.log(dateGames)
            let item = 1
            dateGames.forEach(element => {
                var row = table.insertRow();
                createCell(element.matchup.stadium.name, row, 0, 'center')
                createCell(element.matchup.team_a.name, row, 1, 'center')
                createCell(element.matchup.goals_team_a + "--" + element.matchup.goals_team_b, row, 2, 'end')
                createCell(element.matchup.team_b.name, row, 3, 'center')
                createCell(element.matchup.status, row, 4, 'center')
                item++;
            });

        }
    </script>
@endpush
