@extends('layouts.app', ['activePage' => 'sales', 'titlePage' => __('Modulo de Pronosticos')])

@section('css')
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="content" style="margin-top: 40px">
        <div class="row mt-2">
            <div class="col-sm-12">
                @if (session('message'))
                    <div class="card">
                        Regreso
                    </div>
                @endif
                <div class="card">
                    <div class="card-header card-header-primary">
                        @include('shared.header')
                    </div>
                    <div class="card-body mx-auto w-100" style="height: 75vh; overflow:scroll">
                        <form action="{{ route('predictions.store') }}" method="post">
                            @csrf
                            <table class="table-hover table-striped text-primary mt-2 " style="width: 100%; ">
                                <thead class=" text-primary">
                                    <tr class="bg-info">
                                        <th style="text-align:center; ">Fecha</th>
                                        <th style="text-align:center; ">Grupo</th>
                                        <th style="text-align:center; ">Lugar</th>
                                        <th style="text-align:center; ">Stadium</th>
                                        <th colspan="2" style="text-align:center; ">Paises</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($response['predictions'] as $i => $prediction)
                                        <tr>
                                            {{-- @include('shared.table-details-matchups') --}}
                                            <td style="text-align:center">
                                                {{ date('d-m-Y', strtotime($response['is_prediction'] ? $prediction->matchup->game_date : $prediction->game_date)) }}
                                            </td>

                                            <td style="text-align:center">
                                                {{ $response['is_prediction'] ? $prediction->matchup->teamA->group : $prediction->teamA->group }}
                                                <input type="hidden" name="matchup_id[]"
                                                    value="{{ $response['is_prediction'] ? $prediction->matchup->id : $prediction->id }}">
                                            </td>
                                            <td style="text-align:center">
                                                {{ $response['is_prediction'] ? $prediction->matchup->stadium->place : $prediction->stadium->place }}
                                            </td>

                                            <td style="text-align:center">
                                                {{ $response['is_prediction'] ? $prediction->matchup->stadium->name : $prediction->stadium->name }}
                                            </td>
                                            <td style="text-align:end">
                                                <img src="{{ asset('images') }}\{{ $response['is_prediction'] ? $prediction->matchup->teamA->url_flag : $prediction->teamA->url_flag }}"
                                                    width="20" height="20" alt="" />

                                                {{ $response['is_prediction'] ? $prediction->matchup->teamA->name : $prediction->teamA->name }}
                                                <input type="hidden" name="team_id_a[]"
                                                    value="{{ $response['is_prediction'] ? $prediction->matchup->team_id_a : $prediction->team_id_a }}">
                                            </td>
                                            <td>
                                                <input type="number" name="goals_team_a[]" style="width:40px"
                                                    value="{{ $response['is_prediction'] ? $prediction->goals_team_a : 0 }}"
                                                    {{ isset($response['init']) ? 'disabled' : '' }} required>
                                                --
                                                <input type="number" name="goals_team_b[]" style="width:40px"
                                                    value="{{ $response['is_prediction'] ? $prediction->goals_team_b : 0 }}"
                                                    {{ isset($response['init']) ? 'disabled' : '' }} required>
                                                <input type="hidden" name="team_id_b[]"
                                                    value="{{ $response['is_prediction'] ? $prediction->matchup->team_id_b : $prediction->team_id_b }}">
                                                {{ $response['is_prediction'] ? $prediction->matchup->teamB->name : $prediction->teamB->name }}
                                                <img src="{{ asset('images') }}\{{ $response['is_prediction'] ? $prediction->matchup->teamB->url_flag : $prediction->teamB->url_flag }}"
                                                    width="20" height="20" alt="" />

                                            </td>
                                        </tr>
                                        @if ($errors->has('goals_team_a.' . ($loop->iteration - 1)))
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>

                                                <td>
                                                    @if ($errors->has('goals_team_a.' . ($loop->iteration - 1)))
                                                        {{ $errors->first('goals_team_a.' . ($loop->iteration - 1)) }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="card-footer mx-auto ">
                                @if (!isset($response['init']))
                                    <button type="submit" class="btn btn-primary">{{ __('Grabar Pronosticos') }}</button>
                                @endif
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection('content')
