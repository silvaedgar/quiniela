{{-- Campo response['method'] --}}
<tr id="row{{ $loop->iteration }}"
    @if ($response['method'] == 'inLive' || $response['method'] == 'results') @switch($prediction->status)
        @case('Proceso')
            class = 'bg-warning'
            @break
        @case('Finalizado')
            class = 'bg-danger text-white'
            @break
        @default
            ''
        @endswitch @endif
    @if ($response['method'] != 'results' && ($prediction->goals_team_b != 0 || $prediction->goals_team_a != 0)) style="cursor: pointer"
        onclick="loadPositions(true,this,{{ $loop->iteration }})" @endif>
    {{-- la linea anterior es el fin del TR --}}
    @if ($response['method'] != 'inLive' && $response['method'] != 'results')
        <td style="text-align:center">
            {{ date('d-m-Y', strtotime($response['is_prediction'] ? $prediction->matchup->game_date : $prediction->game_date)) }}
        </td>
    @endif
    {{-- Grupo y ID de partido --}}
    <td style="text-align:center">
        {{ $response['is_prediction'] ? $prediction->matchup->teamA->group : $prediction->teamA->group }}
        <input type="hidden" name="matchup_id"
            value="{{ $response['is_prediction'] ? $prediction->matchup->id : $prediction->id }}">
    </td>
    {{-- Lugar o Ciudad --}}
    <td style="text-align:center">
        {{ $response['is_prediction'] ? $prediction->matchup->stadium->place : $prediction->stadium->place }}
    </td>
    {{-- Nombre del Estadio --}}
    <td style="text-align:center">
        {{ $response['is_prediction'] ? $prediction->matchup->stadium->name : $prediction->stadium->name }}
    </td>
    {{-- Bandera y nombre del 1er Pais --}}
    <td style="text-align:end">
        <img src="{{ asset('images') }}/{{ $response['is_prediction'] ? $prediction->matchup->teamA->url_flag : $prediction->teamA->url_flag }}"
            width="20" height="20" alt="" />
        <input type="hidden" id="team_a_{{ $loop->iteration }}" value="{{ $prediction->teamA->id }}" />
        {{ $response['is_prediction'] ? $prediction->matchup->teamA->name : $prediction->teamA->name }}
    </td>
    {{-- Goles Bandera y nombre del 2do Pais --}}
    <td>
        @if ($response['method'] != 'inLive')
            <input type="number" id="goals_team_a{{ $loop->iteration }}" style="width:40px"
                onchange="processOption({{ $loop->iteration }},'goals',{{ $prediction->id }}, {{ $prediction->teamA->id }} )"
                value="{{ $prediction->goals_team_a }}" required {{ isset($response['init']) ? 'disabled' : '' }}
                {{ $prediction->status == 'Finalizado' || $prediction->status == 'Pendiente' ? 'disabled' : '' }}>
        @else
            {{ $response['is_prediction'] ? $prediction->matchup->goals_team_a : $prediction->goals_team_a }}
        @endif
        --
        @if ($response['method'] != 'inLive')
            <input type="number" id="goals_team_b{{ $loop->iteration }}" style="width:40px"
                onchange="processOption({{ $loop->iteration }},'goals',{{ $prediction->id }},{{ $prediction->teamB->id }})"
                value="{{ $prediction->goals_team_b }}" required {{ isset($response['init']) ? 'disabled' : '' }}
                {{ $prediction->status == 'Finalizado' || $prediction->status == 'Pendiente' ? 'disabled' : '' }}>
        @else
            <input type="hidden" id="team_b_{{ $loop->iteration }}" value="{{ $prediction->teamB->id }}" />
            {{ $response['is_prediction'] ? $prediction->matchup->goals_team_b : $prediction->goals_team_b }}
        @endif
        {{ $response['is_prediction'] ? $prediction->matchup->teamB->name : $prediction->teamB->name }}
        <img src="{{ asset('images') }}/{{ $response['is_prediction'] ? $prediction->matchup->teamB->url_flag : $prediction->teamB->url_flag }}"
            width="20" height="20" alt="" />
        {{-- @if ($response['method'] != 'results' && ($prediction->goals_team_b != 0 || $prediction->goals_team_a != 0)) --}}
        <span style="font-weight: bold" id="expand{{ $loop->iteration }}">
            {{ $response['method'] != 'results' && ($prediction->goals_team_b != 0 || $prediction->goals_team_a != 0) ? '+' : '' }}</span>

    </td>
    @if ($response['method'] == 'results')
        {{-- va a registrar resultados de un juego --}}
        <td style="text-align:center">
            <div class="card-footer mx-auto">
                @switch($prediction->status)
                    @case('Pendiente')
                        <button onclick="processOption({{ $loop->iteration }}, 'button',{{ $prediction->id }}, 0)"
                            class="btn btn-primary">{{ __('Iniciar') }}</button>
                    @break

                    @case('Proceso')
                        <input type="checkbox"
                            onclick="processOption({{ $loop->iteration }},'process', {{ $prediction->id }}, 0)" disabled />
                        <span class="text-muted">Procesar Gol</span>
                    @break

                    @default
                        <span class="text-red"> Encuentro Finalizado</span>
                @endswitch
            </div>
        </td>
        <td style="text-align:center">
            @if ($prediction->status == 'Proceso')
                <input type="checkbox"
                    onclick="processOption({{ $loop->iteration }},'endgame', {{ $prediction->id }}, 0)"><span
                    class="font-weight-bold">Finalizar</span>
            @endif
        </td>

    @endif
</tr>
