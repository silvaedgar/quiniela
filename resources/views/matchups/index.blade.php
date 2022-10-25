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
                                <table class="table-sm table-hover text-primary mt-2 table-striped  " id="players-table"
                                    style="width: 100%">
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
                                        {{-- <div class="ml-3 col-sm-2">
                                        <input type="button" class="btn btn-success" onclick="loadPositions(false,0,0)" value="Actualizar">
                                            </div> --}}
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
            loadPositions(false, 0, 0)
        }, 5000);

        function saveCell(row, index, content, align) {
            row.cells[index].innerHTML = content
            row.cells[index].style = align
        }

        function createRow(table, goals_player, number_row_create, team_current, team_b) {
            var other_row = table.insertRow(number_row_create);
            createCell("", other_row, 0, 'center')
            other_row.cells[0].id = "team_c_" + (number_row_create - 1);
            other_row.cells[0].value = 0;
            console.log(" TEAM ", goals_player.team_id, " ACTUAL ", team_current)
            createCell("", other_row, 1, 'center')
            createCell("", other_row, 2, 'center')
            if (team_current == team_b) {
                createCell("", other_row, 3, 'center')
                createCell(goals_player.name_player + ' ' + goals_player.minute + "'", other_row, 4, 'center')
            } else
                createCell(goals_player.name_player + ' ' + goals_player.minute + "'", other_row, 3, 'center')
        }


        function paintGoalScorer(element, table, row, item, iteration) {
            const total_rows = document.getElementById('matchups').getElementsByTagName('tr').length
            const team_b = document.getElementById("team_b_" + iteration).value
            var goals_player = (element.goals).sort((a, b) => b.team_id - a.team_id);
            console.log("GOLEADORES ", goals_player, " TEAM ", team_b, " ITERATION ", iteration)
            var team_current = goals_player[0].team_id
            var number_row_create = row.rowIndex + 1
            var index = 0
            for (; index < goals_player.length && team_current == goals_player[index].team_id; index++) {
                createRow(table, goals_player[index], number_row_create, team_current, team_b)
                number_row_create++;
            }
            console.log("SALE", index)
            if (index < goals_player.length) { // vienen los goles del otro equipo
                team_current = goals_player[index].team_id
                var total_index = index
                number_row_create = row.rowIndex + 1
                for (; index < goals_player.length; index++) {
                    console.log(" INDEX ", index, total_index)
                    if (index - total_index >= total_index) { // son mas goles de  los procesados primero crea fila
                        createRow(table, goals_player[index], number_row_create, team_current, team_b)
                    } else {
                        other_row = table.rows[number_row_create]
                        var content = goals_player[index].name_player + ' ' + goals_player[index].minute + "'"
                        console.log("CONTENT ", content, " TEAM ", team_b, " CURRENT ", team_current)
                        if (team_current == team_b)
                            createCell(content, other_row, 4, 'center')
                        else
                            other_row.cells[3].innerHTML = content
                    }
                    number_row_create++;
                }
            }
        }

        function expandRow(fila, iteration, resp) {
            var item = fila.rowIndex;
            const total_rows = document.getElementById('matchups').getElementsByTagName('tr').length
            console.log("OBJETO: ", iteration, " FILA ", fila, "FILAS TOTAL: ", total_rows, "ITEM ", item)
            const table = document.getElementById('matchups')
            const row = table.rows[item]
            let matchups = resp.matchups;
            var exist_next_team = false
            element = matchups[iteration - 1]
            var currentTeam = document.getElementById("team_a_" + (row.rowIndex)) ? document.getElementById("team_a_" + (
                iteration)).value : 0
            if (document.getElementById("team_a_" + (iteration + 1))) { // existe siguiente juego
                exist_next_team = (table.rows[item + 1].cells[0].innerHTML != '') // siguiente fila expandida o no
                console.log("SIGUIENTE", exist_next_team)
            } else {
                exist_next_team = !(table.rows[item + 1]) // siguiente fila expandida o no
                console.log("ULTIMO", item, exist_next_team)

            }
            if (exist_next_team) {
                console.log("ITEM ", item, "ITERATION ", iteration)
                paintGoalScorer(element, table, row, item, iteration)
            } else {
                let index = item + 1
                for (; table.rows[index].cells[0].innerHTML == '' && table.rows[index];)
                    table.rows[index].remove();
            }
        }

        function loadPositions(is_click, fila, iteration) {
            fetch('/quiniela/public/api/positions')
                .then(resp => {
                    return resp.json();
                })
                .then(resp => {
                    if (!is_click)
                        fillTables(resp)
                    else
                        expandRow(fila, iteration, resp)
                })
        }

        function fillTables(resp) {
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
            let item = 0
            let base_image = "{{ asset('images') }}/"
            table = document.getElementById('matchups')
            console.log("MATCHUPS: ", matchups)
            let total_rows = document.getElementById('matchups').getElementsByTagName('tr')
                .length
            for (let index = 1; index < total_rows; index++) {
                var row_current = table.rows[index]
                if (row_current.cells[0].innerHTML != '') { // esta la fila de resultados
                    row_current.className = backgroundRow(matchups[item].status)
                    cell = row_current.cells[4].innerHTML
                    length_cell = cell.length
                    init = cell.trimEnd()
                    symbol_expand_row = init.substr(length_cell - 21, 1)
                    console.log("MATCHUP: ", matchups, " item ", item, " simbolo: ", symbol_expand_row, ": cadena ")
                    message = matchups[item].goals_team_a + ' -- ' + matchups[item].goals_team_b + " " + matchups[item]
                        .team_b
                        .name
                    flag = ' <img src="' + base_image + matchups[item].team_b.url_flag +
                        '" width="20" height="20" alt="" /> '
                    flag = flag + '<input type="hidden" id="team_b_' + (item + 1) + '" value = "' + matchups[item].team_b
                        .id + '">'
                    if (symbol_expand_row == '+' || symbol_expand_row == '-')
                        flag = flag + ' &nbsp; &nbsp; <span style="font-weight: bold">' + symbol_expand_row + '</span>'
                    row_current.cells[4].innerHTML = message + flag
                    item++
                }
            }
            // deleteTable(table)
            // matchups.forEach(element => {
            //     // var row = table.insertRow();
            //     var row = table.rows[item]
            //     console.log("ROW ", row)
            //     row.id = "row" + item
            //     row.className = backgroundRow(element.status)


            //     $flag =
            //         '<img src="' + element.team_a.url_flag + '" width="20" height="20" alt="" /> '
            //     $flag = $flag + '<input type="hidden" id="team_a_' + item + '" value = "' + element
            //         .team_a.id + '">'

            //     saveCell(row,0,element.team_a.group,"text-align: center")
            //     saveCell(row,1,element.stadium.place,"text-align: center")
            //     saveCell(row,2,element.stadium.name,"text-align: center")


            //     let team_a = document.getElementById("team_a_" + item).value
            //     let team_b = document.getElementById("team_b_" + item).value
            //     console.log("EQUIPOS ", team_a, team_b, row.rowIndex)
            //     saveCell(row,3,$flag + element.team_a.name,"text-align: end")

            //     $message = element.goals_team_a + ' -- ' + element.goals_team_b + " " + element.team_b
            //         .name
            //     $flag = '<img src="' + element.team_b.url_flag + '" width="20" height="20" alt="" /> '
            //     $flag = $flag + '<input type="hidden" id="team_b_' + item + '" value = "' + element
            //         .team_b.id + '">'

            //     saveCell(row,4,$message + $flag,"text-align: start")

            //     listener()
            //     if (element.goals_team_b != 0 || element.goals_team_a != 0) {
            //         $flag = $flag + "+"
            //         row.style = "cursor: pointer"
            //         // row.addEventListener("click", function() {
            //         //     let team_a = document.getElementById("team_a_" + row.rowIndex).value
            //         //     let team_b = document.getElementById("team_b_" + row.rowIndex).value

            //         //     var nextTeam = document.getElementById("team_a_" + (row.rowIndex + 1))
            //         //         .value
            //         //     if (nextTeam != 0) {
            //         //         console.log("GOLES ", (element.goals).length);
            //         //         var goals_player = (element.goals).sort((a,b) => b.team_id - a.team_id);
            //         //         console.log("GOLEADORES ",goals_player)
            //         //         var team_current = goals_player[0].team_id
            //         //         var number_row_create =  row.rowIndex + 1
            //         //         for (let index = 0; index < goals_player.length || team_current != goals_player[0].team_id; index++) {
            //         //             var other_row = table.insertRow(number_row_create);
            //         //             number_row_create++;
            //         //             createCell("", other_row, 0, 'center')
            //         //             other_row.cells[0].id = "team_a_" + number_row_create - 1;
            //         //             other_row.cells[0].value = 0;
            //         //             createCell("", other_row, 1, 'center')
            //         //             if (team_current == team_b) {
            //         //                 createCell("", other_row, 2, 'center')
            //         //                 createCell(goals_player[index].name_player + ' ' + goals_player[index].name_player + "'", other_row, 3, 'end')
            //         //             }
            //         //             else
            //         //                 createCell(goals_player[index].name_player + ' ' + goals_player[index].name_player + "'", other_row, 2, 'end')
            //         //         }
            //         //         if (index < goals_player.length) { // vienen los goles del otro equipo
            //         //             var total_index = index
            //         //             number_row_create = row.rowIndex + 1
            //         //             for (; index < goals_player.length; index++) {
            //         //                 if (index - total_index >= total_index) { // son mas goles de  los procesados primero crea fila
            //         //                     var other_row = table.insertRow(number_row_create);
            //         //                     createCell("", other_row, 0, 'center')
            //         //                     other_row.cells[0].id = "team_a_" + number_row_create;
            //         //                     other_row.cells[0].value = 0;
            //         //                     createCell("", other_row, 1, 'center')
            //         //                     number_row_create ++;
            //         //                     if (team_current == team_b) {
            //         //                         createCell("", other_row, 2, 'center')
            //         //                         createCell(goals_player[index].name_player + ' ' + goals_player[index].name_player + "'", other_row, 3, 'end')
            //         //                     }
            //         //                     else
            //         //                         createCell(goals_player[index].name_player + ' ' + goals_player[index].name_player + "'", other_row, 2, 'end')

            //         //                 }
            //         //                 else {
            //         //                     other_row = table.rows[number_row_create]
            //         //                     var content = goals_player[index].name_player + ' ' + goals_player[index].name_player + "'"
            //         //                     if (team_current == team_b) {
            //         //                         createCell(content, other_row, 3, 'end')
            //         //                     }
            //         //                     else
            //         //                         other_row.cells[2].innerHTML = content
            //         //                 }
            //         //             }
            //         //         }
            //         //     }
            //         // })
            //     }
            //     console.log("TABLA: ", table)

            //     // $flag = '<img src="' + element.team_b.url_flag + '" width="20" height="20" alt="" /> '
            //     // createCell($message + $flag, row, 4, 'start')

            //     item++;

            // })
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
