<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Game;
use App\User;
use Config;

class GameController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');  
        $this->middleware('auth', ['except' => 'endGame']);
    }

    public function lobby()
    {
        if (Config::get('app.simulateBottleneck')){
            $timeToWait = Config::get('app.simulateBottleneck_lobby');
            $percentage = Config::get('app.simulateBottleneckProbability_lobby');
            if (rand(0,100)<=$percentage)
                usleep($timeToWait * 1000);
        }

    	$games = Game::where('estado', 'P')
               ->orderBy('id', 'desc')
               ->get();
    	return view('lobby')->with('games',$games);
    }

    public function createGame()
    {
    	$g = new Game();
    	$g->ownerUserID = \Auth::user()->id;
    	$g->save();
    	return redirect()->route('game.lobby');
    }

    public function deleteGame(Request $request)
    {
        $id =  $request->input('gameID');
        $game = Game::destroy($id);
        return redirect()->route('game.lobby');
    }

	//Não verifica se user já está no jogo ou não
    public function joinGame($id)
    {
    	$game = Game::findOrFail($id);
    	$game->totalPlayers = $game->totalPlayers+1;
    	$game->save();
        return redirect()->route('game.show',[$id, 1]);
    }

    public function showGame($id, $joining = 0)
    {
    	return view('game')->with('gameID', $id)
    					   ->with('userID',\Auth::user()->id)
                           ->with('userName',\Auth::user()->name)
    					   ->with('join', $joining)
    					   ->with('includeAngularBoard', true);
    }

    public function startGame($id)
    {
    	try 
    	{
	    	$game = Game::findOrFail($id);
	    	$game->estado = 'A';
	    	$game->save();
    	}
    	catch (Exception $e)
    	{
    		return response()->json(false);
    	}
    	finally
    	{
    		return response()->json(true);
    	}
    }

    public function endGame()
    {
        try
    	{
    		$id = request()->input('gameId');
    		$estado = request()->input('gameStatus');
    		$user1 = request()->input('user1');
    		$user2 = request()->input('user2');
    		//Empate
    		$pontos1 = 2;
    		$pontos2 = 2;    		     		
    		if ($estado == 11) { // Vence User1
    			$pontos1 = 5;
	    		$pontos2 = 1;    		 
    		} else
	    		if ($estado == 12) { // Vence User2
	    			$pontos2 = 5;
		    		$pontos1 = 1;    		 
	    		}
	    	$game = Game::findOrFail($id);
	    	$game->estado = 'F';
	    	$game->save();
	    	if ($user1 >= 0) {
		    	$u = User::findOrFail($user1);
		    	$u->jogos = $u->jogos +1;
		    	$u->pontos = $u->pontos + $pontos1; 
		    	$u->save();
			}
			if ($user2 >= 0) {
		    	$u = User::findOrFail($user2);
		    	$u->jogos = $u->jogos +1;
		    	$u->pontos = $u->pontos +$pontos2; 
		    	$u->save();
		    }
            return response()->json(true);
    	}
    	catch (Exception $e)
    	{
    		return response()->json(false);
    	}
    }

}
