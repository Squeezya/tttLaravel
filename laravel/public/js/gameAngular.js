(function(){
"use strict";	
	var module = angular.module('myApp', []); 

    module.config(function($interpolateProvider) {
    	$interpolateProvider.startSymbol('{--');
    	$interpolateProvider.endSymbol('--}');
    });


	module.controller('AppController', ['$scope', '$timeout', function($scope, $timeout) {
		var promise = null;
		var protocol = location.protocol;
		var port = '8080';
		var urlBase = protocol + '//' + window.location.hostname;
		//var urlSocket = urlBase + ':' + port;
		var urlSocket = "nodettt.eastus.cloudapp.azure.com" + ':' + port; //for node server on separated VM (check if VM is on)
		$scope.gameEnded = false;

		$scope.game= {board: [0,0,0,0,0,0,0,0,0], gameStatus:0};
		$scope.urlBase = urlBase;
		console.log(urlBase);
		$scope.message = "";	
		$scope.messageClass = "smallMessage";	

		console.log('connect');



		console.log(urlSocket);

		var socket = io.connect(urlSocket, {reconnect: true});

		$scope.initGame = function(gameID, userID, join) {
			$scope.gameId = gameID;
			$scope.userID = userID;
			$scope.join = join;
			if ($scope.join == 1)
				$scope.joinGame();
			console.log('Vai pedir getGame do jogo '+$scope.gameId);
//			socket.emit("getGame", $scope.gameId);
		};

	   	$scope.joinGame = function() {
	   		console.log('joinGame');
	   		$scope.message = '';
	   		socket.emit("joinGame", $scope.gameId, $scope.userID);
		};

	   	$scope.clickTile = function(idx){
	   		if ($scope.gameEnded)
	   			return;
	   		$scope.message = '';
			var move = {
				position: idx,
				userID: $scope.userID,
			};
	   		console.log('click ', move);
			socket.emit("playMove", $scope.gameId, move);	   			   			
		};

		socket.on('refreshGame', function(data){
			console.log('RefreshGame', data);
			$scope.game = data;
			$scope.$apply();
		});

		socket.on('gameMessage', function(msg){
			console.log('gameMessage', msg);
			if (promise!= null){
				$timeout.cancel(promise);
				promise= null;
			}
			if (msg.tipo == 'endGame'){
				$scope.gameEnded = true;
				$scope.messageClass = "largeMessage";	
			}
			else{
				$scope.messageClass = "smallMessage";	
				promise = $timeout(function() {
        			$scope.message = "";
        			$scope.$apply();
			    }, 3000);

			}
			$scope.message = msg.text;
			$scope.$apply();

		});
	}]);
})();
