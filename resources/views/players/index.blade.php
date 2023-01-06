@extends('layouts.app', ['activePage' => 'sales', 'titlePage' => __('Vista de Participantes')])

@section('css')
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css" rel="stylesheet">

    <style>
        th {
            position: sticky;
            top: 0px;
        }
    </style>
@endsection

@section('content')
    <div class="content" style="margin-top: 40px">
        <div class="row mt-2">
            <div class="col-sm-12">
                <div class="card" style="height: 80vh">
                    <div class="card-header card-header-primary">
                        @include('shared.header')
                    </div>
                    <div class="card-body mt-1">
                        <div class="row">

                            <div class="col-sm-10 col-md-4" style="height: 76vh; overflow: scroll; ">
                                <table class="table-hover text-primary mt-2" id="table-players"
                                    style="width: 100%; height: auto ">
                                    <thead class=" text-primary" style="position: sticky; top:0px">
                                        <tr>
                                            <th colspan="3"
                                                style="top:0px; background: red; text-align:center; text-decoration-style:solid ">
                                                <a class="text-white" href="{{ route('players.position') }}"> <i
                                                        class="fa fa-print" aria-hidden="true"></i>
                                                    Imprimir Posiciones
                                                </a>
                                            </th>
                                        </tr>
                                        <tr class="bg-info " style="top: 0px">
                                            <th style="text-align:center">Nombre Jugador</th>
                                            <th style="text-align:center">Posicion</th>
                                            <th style="text-align:center">Puntos</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $rows = count($response['players']);
                                        @endphp
                                        @foreach ($response['players'] as $i => $player)
                                            <tr id="row{{ $i }}" style="cursor:pointer"
                                                onclick="fillTable({{ $player }}, {{ $i }}, {{ $rows }})">

                                                <td style="text-align:center">
                                                    {{ $player->players->name }}
                                                </td>
                                                <td> {{ $loop->iteration }} </td>
                                                <td> {{ $player->points }} </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-12 col-md-8">
                                <div class="row mb-2">
                                    <div class="ml-3 col-sm-3 bg-danger text-white"> Finalizado</div>
                                    <div class="ml-3 col-sm-3 bg-warning"> En Proceso</div>
                                    <div class="ml-3 col-sm-3 "> Pendiente</div>
                                </div>
                                <div class="row" style="height: 65vh; overflow-y: scroll;">
                                    <table class="table-striped table-hover text-primary " id="table-predictions-player"
                                        style="width: 100%; ">
                                        <thead class="text-primary">
                                            <tr class="bg-info">
                                                <th colspan="6" id="label_prediction" style="text-align:center; ">
                                                    Pronosticos
                                                </th>
                                                <th colspan="2" style="text-align:center;">Ptos</th>

                                            </tr>
                                        </thead>
                                        <tbody>
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
        function fillTable(player, i, rows_players) {
            for (let index = 0; index < rows_players; index++) {
                let row_player = document.getElementById('row' + index)
                row_player.className = backgroundRow('Pendiente')
            }
            let row_player = document.getElementById('row' + i)
            row_player.className = backgroundRow('Proceso')

            let item = 0;
            let balance = 0;
            let table = document.getElementById('table-predictions-player')
            let tag = document.getElementsByTagName("th");
            console.log("TABKE", table, "TAGS", tag)
            table.classList.add("mt-2")
            tag[4].innerHTML = "Pronostico: " + player.players.name
            tag[4].style = "position: sticky; top: 0px; text-align:center;"
            tag[4].classList.add("bg-info")
            tag[5].innerHTML = "Ptos "
            tag[5].classList.add("bg-info")
            tag[5].style = "position: sticky; top: 0px; text-align:center;"

            let predictions = player.prediction_details
            deleteTable(table)
            predictions.forEach(element => {
                var row = table.insertRow(item + 1);
                row.className = backgroundRow(element.matchup.status)
                base_image = "{{ asset('images') }}/"

                flag =
                    '<img src="' + base_image + element.matchup.team_a.url_flag +
                    '" width="20" height="20" alt="" /> '
                date_game = element.matchup.game_date.substring(8, 10) + "-" + element.matchup.game_date.substring(
                    5, 7) + "-" + element.matchup.game_date.substring(0, 4)

                createCell(date_game, row, 0, 'center')
                createCell(element.matchup.team_a.group, row, 1, 'center')
                createCell(element.matchup.stadium.place, row, 2, 'center')
                createCell(element.matchup.stadium.name, row, 3, 'center')
                createCell(flag + element.matchup.team_a.name, row, 4, 'end')
                message = element.goals_team_a + ' -- ' + element.goals_team_b + " " +
                    element.matchup.team_b.name + " "
                console.log("BASE IMG: ", base_image)
                flag = '<img src=" ' + base_image + element.matchup.team_b.url_flag +
                    '" width="20" height="20" alt="" /> '
                result = ''
                if (element.matchup.status != 'Pendiente') {
                    result = "(" + element.matchup.goals_team_a + " -- " + element.matchup.goals_team_b + ")"
                }
                createCell(message + flag, row, 5, 'start')
                createCell(result, row, 6, 'center')

                createCell(element.points, row, 7, 'center')

                item++;
            })
        }
    </script>
@endpush
