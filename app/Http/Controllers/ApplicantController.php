<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApplicantController extends Controller
{
    public function index()
    {
        return view('applicant.index'); // Return your applicant dashboard view
    }
}
