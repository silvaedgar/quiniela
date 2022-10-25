@extends('layouts.app', ['activePage' => 'sales', 'titlePage' => __('Modulo de Resultados')])

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
                        <div class="row mt-3">
                            <div class="col-sm-12">
                                <table class="table table-striped table-responsive" style="width:90%" id="matchups">
                                    <thead class="text-primary"">
                                        <tr class="bg-info">
                                            <th>Grupo</th>
                                            <th>Ciudad</th>
                                            <th>Stadium</th>
                                            <th colspan="2" class="text-center">Paises</th>
                                            <th colspan="2" class="text-center">Opciones</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($response['matchups'] as $i => $prediction)
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
@endsection('content')

@push('js')
    <script src="{{ asset('js') }}/functions.js"></script>
    <script>
        function generateCheck(item, cells, id, disabled) {

            clase = (disabled == '' ? 'class = "text-dark" style="font-weight: bold" ' : 'class="text-muted" ') + '>'
            contenido = '<input type = "checkbox" onclick = "processOption(' + item + ','
            contenido = contenido + "'process'," + id +
                ",'" + "')" + '" ' + disabled + '> <span ' + clase + ' Procesar Gol</span>'
            cells[5].innerHTML = contenido
            contenido = '<input type="checkbox" onclick ="processOption(' + item + ','
            contenido = contenido + "'endgame'," + id +
                ',"")" > <span class = "text-dark" style="font-weight: bold">Finalizar</span>'
            cells[6].innerHTML = contenido
        }

        function initMatchup(matchup_id, goals_team_a, goals_team_b, option, player, team, minute) {
            try {
                fetch('/quiniela/public/api/process-goal', {
                        method: 'POST',
                        headers: {
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify({
                            matchup_id: matchup_id,
                            goals_team_a: goals_team_a,
                            goals_team_b: goals_team_b,
                            name_player: player,
                            team_id: team,
                            minute: minute,
                            status: option ? 'Finalizado' : 'Proceso'
                        })
                    })
                    .then(resp => {
                        console.log("RESP: ", resp)
                        return resp.json();
                    })

            } catch (error) {
                alert("Error ", error);
            }

        }

        function processOption(item, option, matchup_id, team) {
            console.log("OPTION ", option)
            let table = document.getElementById('matchups')
            let rows = table.rows;
            let cells = rows[item].cells;
            let goals_team_a = document.getElementById("goals_team_a" + item).value
            let goals_team_b = document.getElementById("goals_team_b" + item).value

            // let goals = cells[4].innerHTML;
            let contenido = ''
            option.trim()
            switch (option) {
                case "process": // clickeo  procesar goal
                    var player = document.getElementById('player').value
                    var minute = document.getElementById('minute').value
                    initMatchup(matchup_id, goals_team_a, goals_team_b, false, player, team, minute)
                    generateCheck(item, cells, matchup_id, 'disabled')
                    break;
                case 'button': // presiono iniciar
                    initMatchup(matchup_id, 0, 0, false, '', 0, 0)
                    generateCheck(item, cells, matchup_id, 'disabled')
                    document.getElementById("goals_team_a" + item).disabled = false
                    document.getElementById("goals_team_b" + item).disabled = false
                    rows[item].className = backgroundRow('Proceso');
                    break;
                case "endgame": //clickeo finalizar
                    initMatchup(matchup_id, goals_team_a, goals_team_b, true, '', 0, 0)
                    cells[5].innerHTML = '<span> Encuentro Finalizado</span>'
                    cells[6].innerHTML = ''

                    document.getElementById("goals_team_a" + item).disabled = true
                    document.getElementById("goals_team_b" + item).disabled = true
                    rows[item].className = backgroundRow('Finalizado');
                    break;
                default:
                    var inputs = "<td colspan='2'> <input type='text' id = 'player' width='25%' />"
                    inputs = inputs + "<input type='number' id = 'minute' width='10%' /></td>"
                    cells[5].innerHTML = inputs
                    var cell = rows[item].insertCell(7);

                    // generateCheck(item, cells, matchup_id, '')

                    contenido = '<input type = "checkbox" onclick = "processOption(' + item + ','
                    contenido = contenido + "'process'," + matchup_id +
                        ", " + team + ')" > <span class="text-dark" style="font-weight: bold "> Procesar Gol </span>'
                    console.log("CONTENIDO: ", contenido)
                    cells[6].innerHTML = contenido

                    // contenido = '<input type = "checkbox" onclick = "processOption(' + item + ','
                    // contenido = contenido + "'process', " + matchup_id +
                    //     ')" > <span class="text-dark" style="font-weight: bold"> Procesar Gol </span>'
                    // cells[5].innerHTML = contenido
            }

        }
    </script>
@endpush
