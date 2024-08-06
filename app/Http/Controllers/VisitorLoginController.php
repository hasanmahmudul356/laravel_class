<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Testing\Fluent\Concerns\Has;

class VisitorLoginController extends Controller
{
    public function store(Request $request){
        $visitor = new Visitor();
        $visitor->fill($request->all());
        $visitor->password = Hash::make($request->password);
        $visitor->save();

        $data['url'] = \request()->input('back_url');
        return redirect()->route('comment.index', $data);
    }

    public function visitor_do_login(Request $request){
        $credantial = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        $login = Auth::guard('visitor')->attempt($credantial);

        if ($login){
            $backUrl = $request->input('back_url');
            return redirect()->to("$backUrl#commentSection");
        }else{
            Session::flash('failed', 'Login Failed');
            return redirect()->back();
        }
    }
}
