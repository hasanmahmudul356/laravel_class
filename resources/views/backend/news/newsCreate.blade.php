@extends('backend.layouts.master')
@section('header')
    <link href="{{asset('backend/plugin/select2/dist/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('dashboard_content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 text-left">
                <h1 class="h5 mb-2 text-gray-800">News Add</h1>
            </div>
            <div class="col-md-6 text-right mb-2">
                <a href="{{route('news.index')}}" class="btn btn-primary">News List</a>
            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">

            </div>
            <div class="card-body">
                <form method="post" enctype="multipart/form-data" action="{{isset($news) ? route('news.update', $news->id) : route('news.store')}}">
                    {{csrf_field()}}

                    @if(isset($news))
                        {{method_field('PUT')}}
                        <input type="hidden" name="id" value="{{$news->id}}">
                    @endif

                    <span class="text-success">{{Session::has('success') ? Session::get('success') : ''}}</span>

                    <div class="form-group">
                        <label>Category</label>
                        <select  class="form-control category_select" name="category_id">
                            <option value="">Select</option>
                            @foreach($categories as $category)
                                <option {{isset($news) && $category->id == $news->category_id ? 'selected' : '' }} value="{{$category->id}}">{{$category->category_name}}</option>
                            @endforeach
                        </select>
                        <span class="text-danger">{{$errors->has('category_id') ? $errors->first('category_id') : ''}}</span>
                    </div>
                    <div class="form-group">
                        <label>Title</label>
                        <input class="form-control" name="title" value="{{isset($news)?$news->title : ''}}">
                        <span class="text-danger">{{$errors->has('title') ? $errors->first('title') : ''}}</span>
                    </div>
                    <div class="form-group">
                        <label>Details</label>
                        <textarea rows="5" id="mytextarea" class="form-control" name="details">{{isset($news)?$news->details : ''}}</textarea>
                        <span class="text-danger">{{$errors->has('details') ? $errors->first('details') : ''}}</span>
                    </div>
                    <div class="form-group">
                        <label>Thumbnail</label>
                        <input type="file" name="thumbnail">
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
@section('script')
    <script src="{{asset('backend/plugin/tinymce/tinymce.min.js')}}"></script>
    <script src="{{asset('backend/plugin/select2/dist/js/select2.min.js')}}"></script>
    <script>
        tinymce.init({
            selector: '#mytextarea',
            menubar:false,
            statusbar: false,
            plugins: "powerpaste advcode searchreplace autolink directionality code visualblocks visualchars image link media mediaembed codesample table charmap pagebreak nonbreaking anchor tableofcontents insertdatetime advlist lists checklist wordcount tinymcespellchecker editimage help formatpainter permanentpen charmap linkchecker emoticons advtable export autosave",
            toolbar: "undo redo print spellcheckdialog formatpainter | blocks fontfamily fontsize | bold italic underline forecolor backcolor | link image | alignleft aligncenter alignright alignjustify lineheight | checklist bullist numlist indent outdent | removeformat | code",
            height: "700px",
        });
    </script>
    <script>
        $('.category_select').select2();
    </script>
@endsection
