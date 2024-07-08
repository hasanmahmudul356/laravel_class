<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        return view('backend.dashboard');
    }

    public function newsList(){
        return view('backend.newslist');
    }

    public function newsAddForm()
    {
        return view('backend.newsAdd');
    }
}
