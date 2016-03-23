@extends('layouts.app')

@section('content')
<div class="container" ng-app="myApp">
    <div class="row" ng-controller="AppController" ng-init="initGame({{$gameID}}, {{$userID}}, {{$join}})">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Game (ID = {{$gameID}})</div>
                <div class="panel-body">
                    <div id="board">
                        <div ng-repeat="tile in game.board track by $index">
                            <img ng-src="{--urlBase--}/img/{--tile--}.png" ng-click="clickTile($index);">
                        </div>
                    </div>    
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Messages to {{$userName}}</div>
                <div class="panel-body">
                    <div ng-class="messageClass">
                        {--message--}
                    </div>

                    <hr>

    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
