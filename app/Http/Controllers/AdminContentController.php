<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class AdminContentController extends Controller
{
    /**
     * Show different content based on the type.
     *
     * @param string $type
     * @return \Illuminate\View\View|\Illuminate\Http\Response
     */
    public function showContent($type)
    {
        switch ($type) {
            case 'applicant-tracker':
                return view('admin.tracker'); // View file: resources/views/admin/tracker.blade.php
            case 'applicant-result':
                return view('admin.applicant_results'); // View file: resources/views/admin/applicant_results.blade.php
            case 'notes':
                return view('admin.notes'); // View file: resources/views/admin/notes.blade.php
            case 'employees':
                return view('admin.employees'); // View file: resources/views/admin/employees.blade.php
            case 'departments':
                return view('admin.departments');
            case 'jobs':
                return view('admin.jobs'); // View file: resources/views/admin/jobs.blade.php
            case 'job-posting':
                return view('admin.job-posting');
            case 'applications':
                return view('admin.applications');
            case 'users':
                return view('admin.users'); // View file: resources/views/admin/users.blade.php
            case 'interviews':
                return view('admin.interviews'); // View file: resources/views/admin/interviews.blade.php
            default:
                return abort(404); // Return 404 for any unknown content types
        }
    }
}
