<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        table,
        th,
        td {
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <table class="table-sm text-primary table-bordered" id="players-table" style="width: 100%">
        <thead class=" text-primary">
            <tr>
                <th colspan="3" class="text-center">Quiniela Qatar 2022 </th>

            </tr>
            <tr class="bg-success">
                <th colspan="3" class="text-center">Posiciones Actualizadas al
                    {{ date('d-m-Y', strtotime($positionPlayers['current_date']->date_current)) }}
                    {{ date('G:i:s', strtotime($positionPlayers['current_time'])) }} </th>
            </tr>

            <tr class="bg-info">
                <th style="text-align: center; " width="15px">Pos.</th>
                <th style="text-align:center" width="50px">Jugador</th>
                <th style="text-align:center" width="15px">Puntos</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($positionPlayers['positions'] as $i => $player)
                <tr>
                    <td> {{ $loop->iteration }}</td>
                    <td>
                        {{ $player->name }}
                    </td>
                    <td>
                        {{ $player->points }}
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
