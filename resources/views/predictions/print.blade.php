<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Planilla de Quiniela</title>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        th {
            border: 1px solid #dddddd;
            text-align: center;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>

</head>

<body>
    <h3>Jugador {{ auth()->user()->name }} </h3>
    <table class="table table-striped table-inverse table-responsive" style="width:90%">
        <thead class="thead-inverse">
            <tr>
                <th width="15%">Fecha</th>
                <th width="9%">Grupo</th>
                <th width="24%">Lugar</th>
                <th width="26%">Pais</th>
                <th width="15%"></th>
                <th width="26%">Pais</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($predictions as $i => $prediction)
                <tr style="font-size: 12.5px">
                    <td style="text-align:center">
                        {{ date('d-m-Y', strtotime($prediction->matchup->game_date)) }}
                    </td>
                    <td style="text-align:center">
                        {{ $prediction->matchup->teamA->group }}
                    </td>
                    <td> {{ $prediction->matchup->stadium->name }} </td>
                    <td style="text-align:end"> <img
                            src="{{ asset('images') }}/{{ $prediction->matchup->teamA->url_flag }}" width="20"
                            height="15" alt="" />
                        {{ $prediction->matchup->teamA->name }}
                    </td>
                    <td> {{ $prediction->goals_team_a }}
                        --
                        {{ $prediction->goals_team_b }} </td>
                    <td style="text-align: start; margin-left:-30px">
                        {{ $prediction->matchup->teamB->name }}
                        <img src="{{ $prediction->matchup->teamB->url_flag }}" width="20" height="15"
                            alt="" />
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <span style="font-size:10px"> {{ $uuid }} </span>
</body>

</html>
