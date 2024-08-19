@extends('backend.layouts.master')
@section('dashboard_content')
    <div class="container-fluid" id="viewBlock">
    <div class="row">
        <div class="col-md-6 text-left">
            <h1 class="h5 mb-2 text-gray-800">{{__('app.cat_list')}}</h1>
        </div>
        <div class="col-md-6 text-right mb-2">
            <a @click="modalHideShow('addModal', 'show')" class="btn btn-primary">{{__('app.add_new')}}</a>
        </div>
    </div>
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Details</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(data, index) in datList">
                            <th>@{{index+1}}</th>
                            <th>@{{data.category_name}}</th>
                            <th>@{{data.details}}</th>
                            <th>
                                <a @click="openEditModal(data)" class="btn btn-warning">EDIT</a>
                                <a @click="deleteData(data)" class="btn btn-danger">DELETE</a>
                            </th>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal" id="addModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Category</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form method="post">
                            <div class="form-group">
                                <label>Category name</label>
                                <input v-model="addFormData.category_name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Details</label>
                                <textarea class="form-control" v-model="addFormData.details"></textarea>
                            </div>
                            <div class="form-group">
                                <a @click="submitAddForm(1)" class="btn btn-success">Submit and close</a>
                                <a  @click="submitAddForm(2)" class="btn btn-success">Submit and next</a>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" @click="modalHideShow('addModal', 'hide')">Close</button>
                    </div>

                </div>
            </div>
        </div>
        <div class="modal" id="updateModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Category Update</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form method="post" @submit.prevent="submitUpdateForm()">
                            <div class="form-group">
                                <label>Category name</label>
                                <input v-model="editFormData.category_name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Details</label>
                                <textarea class="form-control" v-model="editFormData.details"></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" @click="modalHideShow('updateModal', 'hide')">Close</button>
                    </div>
                </div>
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
                datList: {},
                addFormData : {},
                editFormData : {}
            },
            methods: {
                modalHideShow : function (modalId, status, callback = false){
                    const _this = this;
                    _this.editFormData = {};
                    _this.addFormData = {};
                    $(`#${modalId}`).modal(status);

                    if(typeof callback === 'function'){
                        callback(true);
                    }
                },
                getDataList: function () {
                    const _this = this;
                    var url = `${baseUrl}/api/category_api`;
                    httpReq(url, 'get', {}, function (retData) {
                        if (parseInt(retData.status) === 2000) {
                            _this.datList = retData.result;
                        } else {
                            showToast(retData.message);
                        }
                    });
                },
                deleteComment: function (data) {
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
                openEditModal : function (data){
                    const _this = this;
                    this.modalHideShow('updateModal', 'show', function (retData){
                        _this.editFormData = data;
                    });
                },
                submitUpdateForm : function (){
                    const _this = this;
                    axios({
                        method: "PUT",
                        url: `${baseUrl}/api/category_api/${this.editFormData.id}`,
                        data: this.editFormData
                    }).then(function (response) {
                        if(parseInt(response.data.status) === 2000){
                            showToast(response.data.message);
                            _this.modalHideShow('updateModal', 'hide');
                        }else if(parseInt(response.data.status) === 3000){
                            console.log(response.data);
                        }else{
                            console.log(response.data);
                        }
                    }).catch(function (error) {
                        console.log(error);
                    });
                },
                submitAddForm : function (submitType){
                    const _this = this;
                    axios({
                        method: "POST",
                        url: `${baseUrl}/api/category_api`,
                        data: this.addFormData
                    }).then(function (response) {
                        if(parseInt(response.data.status) === 2000){
                            showToast(response.data.message);
                            if(submitType === 1){
                                _this.modalHideShow('addModal', 'hide', function (retData){
                                    _this.getDataList();
                                });
                            }else{
                                _this.addFormData = {};
                            }
                        }else if(parseInt(response.data.status) === 3000){
                            console.log(response.data);
                        }else{
                            console.log(response.data);
                        }
                    }).catch(function (error) {
                        console.log(error);
                    });
                },

                deleteData : function (data){
                    _this = this;
                    Swal.fire({
                        title: "Are you sure to delete ??",
                        showDenyButton: true,
                        showCancelButton: true,
                        confirmButtonText: "OK",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var url = `${baseUrl}/api/category_api/${data.id}`;
                            httpReq(url, 'DELETE', {}, function (retData) {
                                showToast(retData.message);
                                _this.getDataList();
                            });
                        }
                    });
                },
            },
            mounted() {
                this.getDataList();
            },
        })
    </script>
@endsection
