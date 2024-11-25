<?php

namespace App\Http\Controllers;

use App\Models\Training;
use Illuminate\Support\Facades\Date;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return View
     */
    public function index()
    {
        $trainings = Training::where('visible', '=', true)
            ->where('end', '>=', Date::now())->get();

        return view('home')->with('trainings', $trainings);
    }
}
