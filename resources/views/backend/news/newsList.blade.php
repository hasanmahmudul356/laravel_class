@extends('backend.layouts.master')
@section('dashboard_content')
    <div class="container-fluid">
    <div class="row">
        <div class="col-md-6 text-left">
            <h1 class="h5 mb-2 text-gray-800">News List</h1>
        </div>
        <div class="col-md-6 text-right mb-2">
            <a href="{{route('news.create')}}" class="btn btn-primary">Add New</a>
        </div>
    </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Image</th>
                            <th>Tile</th>
                            <th>Date</th>
                            <th>Author</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($news as $key => $value)
                            <tr>
                                <th>{{$key+1}}</th>
                                <th><img style="width: 50px" src="{{env('STORAGE_PATH')}}/{{$value->thumbnail}}"></th>
                                <th>{{$value->title}}</th>
                                <th>{{$value->date}}</th>
                                <th>{{$value->user_name}}</th>
                                <th>
                                    <a href="{{route('news.edit', $value->id)}}" class="btn btn-warning">Edit</a>
                                    <a  href="{{route('news.destroy', $value->id)}}" class="btn btn-danger deleteButton">Delete</a>
                                </th>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script>
    $('.deleteButton').on('click', function (e){
        e.preventDefault();
        let confir = confirm('Are you sure to delete?');
        if(confir){
            let url = $(this).attr('href');
            // let title = $('#title').val();
            $.ajax({
                type: "DELETE",
                url: url,
                data: {
                    _token : '{{csrf_token()}}',
                    // title : title,
                },
                success: function(res){
                    if(parseInt(res.status) === 2000){
                        alert(res.message);
                        // $(this).parent().parent().remove();
                    }else{
                        alert(res.message);
                    }
                },
                error : function (dsdsd){
                    console.log(dsdsd);
                }
            });
        }
    })
</script>
@endsection
