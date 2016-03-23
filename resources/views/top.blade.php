@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            @if (count($topUsers) > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">Top 5</div>
                    <div class="panel-body">
                        <table class="table table-striped task-table">

                            <!-- Table Headings -->
                            <thead>
                                <th>Position</th>
                                <th>UserName</th>
                                <th>Average</th>
                            </thead>

                            <!-- Table Body -->
                            <tbody>
                                <?php $pos=0; ?>
                                @foreach ($topUsers as $user)
                                    <?php $pos++; ?>
                                    <tr>
                                        <!-- Task Name -->
                                        <td class="table-text">
                                            <div>{{ $pos }}</div>
                                        </td>
                                        <td class="table-text">
                                            <div>{{ $user->name }}</div>
                                        </td>
                                        <td class="table-text">
                                            <div>{{ $user->media }}</div>
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


