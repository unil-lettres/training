<?php

namespace App\Http\Controllers;

use App\Models\Request;
use App\Http\Requests\RequestRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Date;
use App\Mail\RequestCreated;
use App\Services\Users;
use Illuminate\View\View;

class RequestController extends Controller
{
    /**
     * Index requests
     *
     * @return View
     */
    public function index()
    {
        $requests = backpack_auth()->user()->requests()->get();

        return view('requests.index')->with('requests', $requests);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('requests.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RequestRequest $request
     * @param  Users $usersService
     *
     * @return RedirectResponse
     */
    public function store(RequestRequest $request, Users $usersService)
    {
        $requestObj = new Request([
            'name' => $request->get('name'),
            'theme' => $request->get('theme'),
            'description' => $request->get('description'),
            'deadline' => $request->get('deadline'),
            'level' => $request->get('level'),
            'applicants' => $request->get('applicants'),
            'contact' => $request->get('contact'),
            'comments' => $request->get('comments'),
            'extras' => [
                'doctoral_school' => $request->get('doctoral_school'),
                'fns' => $request->get('fns'),
                'doctoral_status' => $request->get('doctoral_status'),
                'doctoral_level' => $request->get('doctoral_level'),
                'tested_products' => $request->get('tested_products'),
                'teachers_nbr' => $request->get('teachers_nbr'),
                'students_nbr' => $request->get('students_nbr'),
                'action_type' => $request->get('action_type')
            ],
            'filling_date' => Date::now(),
            'user_id' => backpack_auth()->user()->id
        ]);
        $requestObj->save();

        // Send request created notification to all the users with the Notification role
        $usersService->mailUsersWithRole('Notification', new RequestCreated($requestObj));

        return redirect()->route('home')->with('success', 'Demande de formation enregistrée.');
    }
}
