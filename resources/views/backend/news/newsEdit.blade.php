@extends('backend.layouts.master')
@section('dashboard_content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 text-left">
                <h1 class="h5 mb-2 text-gray-800">Category Edit</h1>
            </div>
            <div class="col-md-6 text-right mb-2">
                <a href="{{route('cat.list')}}" class="btn btn-primary">Category List</a>
            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">

            </div>
            <div class="card-body">
                <form method="post" action="{{route('cat.update')}}">
                    {{csrf_field()}}

                    <span class="text-success">{{Session::has('success') ? Session::get('success') : ''}}</span>

                    <input type="hidden" name="id" value="{{$category->id}}">

                    <div class="form-group">
                        <label>Category name</label>
                        <input class="form-control" name="category_name" value="{{$category->category_name}}">
                        <span class="text-danger">{{$errors->has('category_name') ? $errors->first('category_name') : ''}}</span>
                    </div>
                    <div class="form-group">
                        <label>Details</label>
                        <textarea class="form-control" name="details">{{$category->details}}</textarea>
                        <span class="text-danger">{{$errors->has('details') ? $errors->first('details') : ''}}</span>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
