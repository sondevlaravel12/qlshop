@extends('app.master')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Danh sách user</h4>

            <div class="page-title-right">
                <div >
                    {{-- <a href="{{route('tenants.create')}}" class="btn btn-outline-info waves-effect waves-light" ><span ><i class="fas fa-plus"></i> Thêm user</span></a> --}}
                    <a id="add-new-user" class="btn btn-outline-info waves-effect waves-light" ><span ><i class="fas fa-plus"></i> Thêm user</span></a>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                {{-- <h4 class="card-title">Danh sách user</h4> --}}

                <div class="table-responsive">

                    <table id="datatable" class="table table-bordered dt-responsive nowrap dataTable no-footer dtr-inline">

                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                {{-- <th>Domain link</th> --}}
                                <th>Ngày tạo</th>
                                <th>Ngày chỉnh sửa</th>
                                <th>Role</th>
                                <th>Tình trạng</th>
                                {{-- <th>Sửa / Xóa</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>

                                <td>{{ $user->created_at }}</td>
                                <td>{{ $user->updated_at }}</td>
                                <td>
                                    @foreach ($user->roles as $role)
                                        {{ $role->name }}
                                    @endforeach
                                </td>

                                {{-- <td>{{ $user->expiry }}</td> --}}
                                <td>
                                    <div class="square-switch" style="padding: .47rem .75rem">
                                        <input type="checkbox" id="{{ $user->id }}" switch="none" {{ $user->status=='on'?'checked':'' }} name="status">
                                        <label for="{{ $user->id }}" data-on-label="On" data-off-label="Off"></label>
                                    </div>
                                </td>
                                {{-- <td>
                                    <input class="user-id" type="hidden" id="{{ $user->id }}" value="{{ $user->id }}">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-sm btn-link js-edit-user"  ><i class="far fa-edit"></i> Sửa</button>

                                    <button  class="btn btn-sm js-remove-user"><i class="far fa-trash-alt"></i> Xóa</button>
                                    <!-- end Button trigger modal -->

                                </td> --}}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- modal add new  --}}
<div id="addnewtenantmodal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-body">
                <input type="hidden" class="tag-id-in-modal">
                <form action="{{route('users.store')}}" method="POST" >
                    @csrf
                    <div class="row mb-3">
                        <label for="example-text-input" class="col-sm-2 col-form-label">User Name</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="name" value="{{old('name')}}"  >
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="example-text-input" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="email" value="{{old('email')}}"  >
                            @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="example-text-input" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="email" value="{{old('email')}}"  >
                            @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3 ">
                        <label for="example-text-input" class="col-sm-2 col-form-label">trang thai</label>
                        <div class="col-sm-10 ">
                            <div class="square-switch" style="padding: .47rem .75rem">
                                <input type="checkbox" id="square-switch1" switch="none" checked="" name="status">
                                <label for="square-switch1" data-on-label="On" data-off-label="Off"></label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 ">
                        <label class="form-label">Multiple Select</label>

                        <select class="selectpicker" multiple name="regions" id="regions">
                            <option value="99">All regions</option>
                            <option value="AC">AC</option>
                            <option value="AL">AL</option>
                            <option value="AP">AP</option>
                        </select>

                    </div>


                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light waves-effect " data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary waves-effect waves-light btn-save-addnew-user">Save</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection
@push('scripts')
    {{-- https://www.jqueryscript.net/table/crud-bstable.html  --}}
    <script src="{{ asset('backend/assets/libs/crud-bstable/bstable.js') }}"></script>
    {{-- some global variable  --}}

    <script>
        $addnewtenantmodal = $('#addnewtenantmodal');

    </script>

    {{-- end some global variable  --}}
    {{-- normal event --}}
    <script>

    </script>
    {{-- end normal event --}}


    {{-- for list tenants page  --}}
        {{-- using event binding with jQuery   --}}
        {{-- This is nice because now all the JS code is in one place and can be updated (in my opinion) more easily --}}
        <script>
            // need to use delegated events.
            $table.on('change','input:checkbox', function (){
                $status = 'off';
                if(this.checked){
                    $status = 'on'
                }
                $tenantId = $(this).attr('id');
                changeTenantStatus($tenantId, $status).done(function(data){
                    // // show notification
                    displayNotification(data['message'],'success');
                }).fail(function(data){
                    displayNotification("cập nhật tag thất bại",'error');
                });
            });



            $table.on('click','.js-remove-user', function(){
                if(confirm('bạn có chắc muốn xóa user này không?')){
                    // get user id
                    $tenantId = $(this).siblings('input.user-id').val();
                    // get row
                    $row = $(this).closest('tr');
                    // call ajax to remove user in database
                    removeTenant($tenantId).done(function(data){
                        // if remove successfully in db then remove this tag in view and show notification
                        $row.remove();
                        displayNotification(data['message']);
                    }).fail(function(data){
                        displayNotification("xóa tag thất bại","error");
                    });
                }else{

                }

            });


            function removeTenant(tenantId){
                // return the ajax promise
                return $.ajax({
                    type: "get",
                    url: "/api/tenants/remove",
                    data: {id:tenantId},
                    dataType: "json",
                });
            }
            function changeTenantStatus($tenantId, $status){
                // return the ajax promise
                return $.ajax({
                    type: "get",
                    url: "/api/tenants/change-status",
                    data: {id:$tenantId, status:$status},
                    dataType: "json",
                });
            }
        </script>
        {{-- end using event binding with jQuery   --}}

        {{-- for add new tenenat  --}}
        <script>
            $('a#add-new-user').click(function(){
                // show modal
                $addnewtenantModal = $('#addnewtenantmodal');
                $addnewtenantModal.modal('show');

            });
            // submit the form inordor to call route add new like normal addnew, no need to call ajax
            $('.modal .btn-save-addnew-user').click(function(){
                // submit the form
                $('form').submit();
            })

        </script>
    {{-- end for list tags page  --}}


     {{-- other function  --}}

     {{-- end other function  --}}

@endpush
