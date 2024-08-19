<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;

class CategoryApiController extends Controller
{
    public function index(){
        $date = Category::get();
        return response()->json(['result'=>$date, 'status'=>2000]);
    }

    public function store(Request $request)
    {

        try {
            $validate = Validator::make($request->all(),[
                'category_name'=>'required',
                'details'=>'required'
            ]);
            if ($validate->fails()) {
                return response()->json(['result'=>$validate->errors(), 'status'=>3000]);
            }

            $category = new Category();
            $category->category_name =  $request->input('category_name');
            $category->details = $request->input('details');
            $category->save();

            return response()->json(['result'=>null,'message'=>'Successfully Inserted', 'status'=>2000]);

        }catch (Exception $exception){
            return response()->json(['result'=>null,'message'=>$exception->getMessage(), 'status'=>5000]);
        }

    }

    public function update(Request $request, $id){
        try {
            $validate = Validator::make($request->all(),[
                'category_name'=>'required',
                'details'=>'required',
                'id'=>'required',
            ]);
            if ($validate->fails()) {
                return response()->json(['result'=>$validate->errors(), 'status'=>3000]);
            }

            $category = Category::where('id', $id)->first();

            if ($category){
                $category->category_name =  $request->input('category_name');
                $category->details = $request->input('details');
                $category->update();

                return response()->json(['result'=>null,'message'=>'Successfully Updated', 'status'=>2000]);
            }

            return response()->json(['result'=>null,'message'=>'Not Updated', 'status'=>5000]);
        }catch (Exception $exception){
            return response()->json(['result'=>null,'message'=>$exception->getMessage(), 'status'=>5000]);
        }
    }

    public function destroy($id){
        try {
            $category = Category::where('id', $id)->first();

            if ($category){
                $category->delete();

                return response()->json(['result'=>null,'message'=>'Successfully', 'status'=>2000]);
            }

            return response()->json(['result'=>null,'message'=>'Not Deleted', 'status'=>5000]);
        }catch (Exception $exception){
            return response()->json(['result'=>null,'message'=>$exception->getMessage(), 'status'=>5000]);
        }
    }
}
