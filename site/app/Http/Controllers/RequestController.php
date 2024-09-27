<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestRequest;
use App\Mail\RequestCreated;
use App\Models\Request;
use App\Services\Users;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Date;
use Illuminate\View\View;

class RequestController extends Controller
{
    /**
     * Index requests.
     */
    public function index(): View
    {
        $requests = auth()->user()->requests()
            ->orderBy('created_at', 'desc')
            ->get();

        return view('requests.index')->with('requests', $requests);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('requests.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RequestRequest $request, Users $usersService): RedirectResponse
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
                'action_type' => $request->get('action_type'),
            ],
            'filling_date' => Date::now(),
            'user_id' => auth()->user()->id,
        ]);
        $requestObj->save();

        $usersService
            ->mailUsersWithRole('notification', new RequestCreated($requestObj));
        $usersService
            ->notifyUsersWithRole('notification', 'Nouvelle demande reçue', 'Libellé: ' . $requestObj->name);

        return redirect()
            ->route('home')
            ->with('success', 'Demande de formation enregistrée.');
    }
}
