<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Testing\Fluent\Concerns\Has;
use MongoDB\Driver\Session;

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
