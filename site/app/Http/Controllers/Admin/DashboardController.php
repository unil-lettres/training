<?php

namespace App\Http\Controllers\Admin;

use App\Models\Request;
use App\Models\Training;

class DashboardController
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $trainings = Training::all();
        $requests = Request::all();

        return view('vendor.backpack.base.dashboard')->with(['trainings' => $trainings, 'requests' => $requests]);
    }
}
