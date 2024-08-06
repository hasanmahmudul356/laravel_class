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
        $data['news'] = News::join('users', 'news.created_by', '=', 'users.id')->select('news.*','users.name as user_name')->orderBy('id', 'DESC')->get();
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
            'thumbnail'=>'required',
        ]);

        $imageName = '';
        if ($image = $request->file('thumbnail')){
            $imageName = time().'-'.uniqid().'.'.$image->getClientOriginalExtension();
            $image->move(storage_path('uploads'), $imageName);
        }

        $input = $request->except('_token');

        $news = new News();
        $news->fill($input);
        $news->date = date('Y-m-d');
        $news->created_by = auth()->user()->id;
        $news->thumbnail = $imageName;
        $news->save();


        Session::flash('success', 'Successfully Inserted');

        return redirect()->back();
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data['news'] = News::where('id', $id)->first();
        $data['categories'] = Category::where('status', 1)->get();

        return view('backend.news.newsCreate', $data);
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
        $this->validate($request, [
            'title' => 'required',
            'category_id' => 'required',
            'details' => 'required',
        ]);

        $input = $request->except('_token');

        $news = News::where('id', $request->input('id'))->first();
        if ($news){
            $imageName = null;
            if ($image = $request->file('thumbnail')){
                $imageName = time().'-'.uniqid().'.'.$image->getClientOriginalExtension();
                $image->move(storage_path('uploads'), $imageName);
            }

            $news->fill($input);
            $news->thumbnail = $imageName ?? $news->thumbnail;
            $news->save();

            Session::flash('success', 'Successfully Updated');
            return redirect()->back();
        }

        Session::flash('success', 'Not Updated');
        return redirect()->back();



    }

    public function destroy($id)
    {
        $news = News::where('id', $id)->first();

        if ($news){
            $news->delete();

            return response()->json(['status'=>2000, 'message' => 'Successfully Deleted'], 200);
        }
        return response()->json(['status'=>5000, 'message' => 'Not Deleted'], 200);
    }
}
