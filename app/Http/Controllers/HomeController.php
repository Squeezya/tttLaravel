<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Config;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Config::get('app.simulateBottleneck')){
            $timeToWait = Config::get('app.simulateBottleneck_dashboard');
            $percentage = Config::get('app.simulateBottleneckProbability_dashboard');
            if (rand(0,100)<=$percentage)
                usleep($timeToWait * 1000);
        }        
        return view('home');
    }
}
