<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        return view('backend.dashboard');
    }
    public function news()
    {
        return view('backend.news');
    }
    public function contact()
    {
        return view('backend.contact');
    }
}
