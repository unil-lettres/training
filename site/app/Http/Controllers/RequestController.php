<?php

namespace App\Http\Controllers;

use App\Models\Request;
use App\Http\Requests\RequestRequest;
use Illuminate\Support\Facades\Date;

class RequestController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('requests.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RequestRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestRequest $request)
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

        return redirect()->route('home')->with('success', 'Demande de formation enregistrée.');
    }
}
