<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\Support;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    use Support;
    public function index()
    {
        $data['url'] = \request()->input('url');
        return view('auth.visitor_login', $data);
    }
    public function create()
    {
        $data['url'] = \request()->input('url');
        return view('auth.visitor_registration', $data);
    }
    public function store(Request $request)
    {
        $comment = new Comment();
        $comment->visitor_id = auth()->guard('visitor')->user()->id;
        $comment->title = $request->input('title');
        $comment->comment = $request->input('message');
        $comment->save();

        return response()->json(['message' => 'Successfully created comment!', 'status' => 2000] , 200);
    }

    public function commentList()
    {
        return view('backend.commentList');
    }
    public function getComments()
    {
        try {
            $data = Comment::with('visitor:id,name')->get();
//            return retData($data);
            return $this->retData($data);
        }catch (\Exception $exception){
            return retData($exception->getMessage(), 'Something Wrong', 5000);
        }
    }

    public function commentDelete()
    {

        try {
            $id = \request()->input('id');
            $comment = Comment::where('id', $id)->first();
            if ($comment){
                $comment->delete();
                return retData(null, 'Successfully deleted comment!');
            }
        }catch (\Exception $exception){
            return retData($exception->getMessage(), 'Something Wrong', 5000);
        }



    }
}
