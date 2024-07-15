<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['news'] = News::join('users', 'news.created_by', '=', 'users.id')->select('news.*','users.name as user_name')->get();
        return view('backend.news.newsList', $data);
    }

    public function create()
    {
        $data['categories'] = Category::where('status', 1)->get();
        return view('backend.news.newsCreate', $data);
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'category_id' => 'required',
            'details' => 'required',
        ]);

        $input = $request->except('_token');

        $news = new News();
        $news->fill($input);
        $news->date = date('Y-m-d');
        $news->created_by = auth()->user()->id;
        $news->save();


        Session::flash('success', 'Successfully Inserted');

        return redirect()->back();
    }


    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
