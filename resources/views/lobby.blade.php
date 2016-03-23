@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Create New Game</div>
                <div class="panel-body">
                    <!-- New Task Form -->
                    <form action="{{ url('createGame') }}" method="POST" class="form-horizontal">
                        {!! csrf_field() !!}

                        <!-- Add Task Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-plus"></i> Add Game
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @if (count($games) > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">Jogos no Lobby</div>
                    <div class="panel-body">
                        <table class="table table-striped task-table">

                            <!-- Table Headings -->
                            <thead>
                                <th>ID</th>
                                <th>Owner</th>
                                <th>Total Players</th>
                                <th>&nbsp;</th>
                            </thead>

                            <!-- Table Body -->
                            <tbody>
                                @foreach ($games as $game)
                                    <tr>
                                        <!-- Task Name -->
                                        <td class="table-text">
                                            <div>{{ $game->id }}</div>
                                        </td>
                                        <td class="table-text">
                                            <div>{{ $game->ownerName }}</div>
                                        </td>
                                        <td class="table-text">
                                            <div>{{ $game->totalPlayers }}</div>
                                        </td>

                                        <td>
                                            <form action="{{ url('joinGame/'.$game->id) }}" method="POST">
                                                {!! csrf_field() !!}
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fa fa-play"></i> Join
                                                </button>
                                            </form>
                                        </td>

                                        <td>
                                            <form action="{{ url('deleteGame') }}" method="POST">
                                                {!! csrf_field() !!}
                                                <input name="_method" type="hidden" value="DELETE">
                                                <input name="gameID"  type="hidden" value="{{ $game->id }}"> 
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="fa fa-remove"></i> Remove
                                                    </button>
                                            </form>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection


