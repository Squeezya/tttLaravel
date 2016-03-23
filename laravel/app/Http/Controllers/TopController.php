<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use Config;

class TopController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Config::get('app.simulateBottleneck')){
            $timeToWait = Config::get('app.simulateBottleneck_top');
            $percentage = Config::get('app.simulateBottleneckProbability_top');
            if (rand(0,100)<=$percentage)
                usleep($timeToWait * 1000);
        }

        $topUsers = DB::select( DB::raw('SELECT id, name, (pontos / jogos) as media from app8.users where jogos > 0 '.
                            'order by media desc limit 0,5'));
        return view('top')->with('topUsers',$topUsers);;
    }    
}
