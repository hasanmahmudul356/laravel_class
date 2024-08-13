@extends('backend.layouts.master')
@section('header')
    <link href="https://cdn.jsdelivr.net/npm/jquery-toast-plugin@1.3.2/dist/jquery.toast.min.css" rel="stylesheet">
@endsection
@section('dashboard_content')
    <div class="container-fluid" id="viewBlock">
    <div class="row">
        <div class="col-md-6 text-left">
            <h1 class="h5 mb-2 text-gray-800">Comment List</h1>
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
                            <th>User Name</th>
                            <th>Comments</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data, index) in datList">
                                <th>@{{ index+1 }}</th>
                                <th>@{{ data.visitor.name }}</th>
                                <th v-text="data.comment"></th>
                                <th>
                                    <a @click="deleteComment(data)" class="btn btn-danger">
                                        Delete
                                    </a>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>

{{--                <form>--}}
{{--                    @{{formData.name}}--}}
{{--                    <input type="text" v-model="formData.name">--}}
{{--                </form>--}}
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('backend/js/vue/vue.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-toast-plugin@1.3.2/dist/jquery.toast.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        var app = new Vue({
            el: '#viewBlock',
            data: {
                message: 'Hello Vue!',
                datList : {},
                formData : {
                    name : '',
                    category_id : '',
                }
            },
            props : {

            },
            watch : {
                'formData.name' : function (olVal, newVal){
                   console.log(this.formData.name);
                }
            },
            mounted(){
                this.getDataList();
            },
            created(){

            },
            methods : {
                getDataList : function (){
                    const _this = this;
                    var url = `${baseUrl}/api/comments_data`;
                    httpReq(url, 'get', {}, function (retData) {
                        if(parseInt(retData.status) === 2000){
                            _this.datList = retData.result;
                        }else{
                            showToast(retData.message);
                        }
                    });
                },
                deleteComment : function (data){
                    _this = this;
                    Swal.fire({
                        title: "Are you sure to delete ??",
                        showDenyButton: true,
                        showCancelButton: true,
                        confirmButtonText: "OK",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var url = `${baseUrl}/api/comments_data/delete`;
                            httpReq(url, 'post', {}, function (retData) {
                                showToast(retData.message);
                                _this.getDataList();
                            });
                        }
                    });
                },
            },
        })
    </script>
@endsection
