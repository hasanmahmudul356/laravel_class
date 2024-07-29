<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        $data['slides'] = News::with('category:category_name,id')->take(3)->skip(0)->get();
        $data['news'] = News::take(4)->skip(0)->get();
        return view('homepage', $data);
    }

    public function webCategory($cateId)
    {
        $data['news'] = News::with('author:name,id')->where('category_id', $cateId)->paginate(10);
        return view('category', $data);
    }
    public function newsDetails($newsId)
    {
        $data['news'] = News::with('author:name,id', 'category:category_name,id')->where('id', $newsId)->first();
        return view('news_details', $data);
    }
}
