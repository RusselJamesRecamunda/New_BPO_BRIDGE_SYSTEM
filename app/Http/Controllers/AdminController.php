<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Interviews;
use App\Models\Applications;
use App\Models\Employees;
use App\Models\User;

class AdminController extends Controller
{ 
    public function index()
    {
        $scheduledInterviewsCount = Interviews::count(); // Count all scheduled interviews
        $ApplicationsCount = Applications::count(); 
        $EmployeesCount = Employees::count(); 
        $UsersCount = User::count(); 

        return view('admin.dashboard', compact('scheduledInterviewsCount', 'UsersCount', 'ApplicationsCount', 'EmployeesCount'));
    }

     /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
