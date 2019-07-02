<?php

namespace App\Http\Controllers;

use App\Models\Training;
use Illuminate\Support\Facades\Date;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trainings = Training::where('visible', '=', true)->where('end', '>=', Date::now());

        return view('pages.home')->with('trainings', $trainings->get());
    }
}
