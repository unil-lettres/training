<?php

namespace App\Http\Controllers\Admin;

use App\Models\Request;
use App\Models\Training;
use App\User;
use Illuminate\View\View;

class DashboardController
{
    /**
     * Show the application dashboard.
     *
     * @return View
     */
    public function dashboard()
    {
        $trainings = Training::all();
        $requests = Request::all();
        $users = User::all();

        return view('vendor.backpack.base.dashboard')
            ->with(
                [
                    'trainings' => $trainings,
                    'requests' => $requests,
                    'users' => $users
                ]
            );
    }
}
