<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->return_array['sidebar'] = 'Dashboard';
    }

    public function index()
    {
        return view('dashboard-admin.index')->with($this->return_array);
    }
}
