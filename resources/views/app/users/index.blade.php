@extends('master')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Danh sách tenant</h4>

            <div class="page-title-right">
                <div >
                    {{-- <a href="{{route('tenants.create')}}" class="btn btn-outline-info waves-effect waves-light" ><span ><i class="fas fa-plus"></i> Thêm tenant</span></a> --}}
                    <a id="add-new-tenant" class="btn btn-outline-info waves-effect waves-light" ><span ><i class="fas fa-plus"></i> Thêm tenant</span></a>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                {{-- <h4 class="card-title">Danh sách tenant</h4> --}}

                <div class="table-responsive">

                    <table id="datatable" class="table table-bordered dt-responsive nowrap dataTable no-footer dtr-inline">

                        <thead>
                            <tr>
                                {{-- <th>#</th> --}}
                                <th>Tenant uid</th>
                                <th>Domain link</th>
                                <th>Ngày tạo</th>
                                {{-- <th>Ngày chỉnh sửa</th> --}}
                                <th>Hạn sử dụng</th>
                                <th>Tình trạng</th>
                                {{-- <th>Sửa / Xóa</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tenants as $tenant)
                            <tr>
                                {{-- <th scope="row">1</th> --}}
                                <td>{{ $tenant->id }}</td>
                                <td>
                                @if ($tenant->domains->count()>0)
                                    {{-- <a href="{{ $tenant->domains->first()->domain . '/' . tenant('id') }}">{{ $tenant->domains->first()->domain }}</a> --}}
                                    <a href="{{route('gototenant', $tenant)}}">{{ $tenant->domains->first()->domain }}</a>
                                @endif
                                </td>
                                <td>{{ $tenant->created_at }}</td>
                                <td>{{ $tenant->expiry }}</td>
                                <td>
                                    <div class="square-switch" style="padding: .47rem .75rem">
                                        <input type="checkbox" id="{{ $tenant->id }}" switch="none" {{ $tenant->status=='on'?'checked':'' }} name="status">
                                        <label for="{{ $tenant->id }}" data-on-label="On" data-off-label="Off"></label>
                                    </div>
                                </td>
                                {{-- <td>
                                    <input class="tenant-id" type="hidden" id="{{ $tenant->id }}" value="{{ $tenant->id }}">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-sm btn-link js-edit-tenant"  ><i class="far fa-edit"></i> Sửa</button>

                                    <button  class="btn btn-sm js-remove-tenant"><i class="far fa-trash-alt"></i> Xóa</button>
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
                {{-- <div class="card">
                    <div class="card-body"> --}}
                        <form action="{{route('tenants.store')}}" method="POST" >
                            @csrf
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Tenant Id</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="id" value="{{old('id')}}"  >
                                    @error('id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Domain</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="domain" value="{{old('domain')}}"  >
                                    @error('domain')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Hạn sử dụng</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="datetime-local" name="expiry" value="{{old('expiry')}}" min="{{ Carbon\Carbon::now()->format('Y-m-d H:i') }}" >
                                    @error('expiry')
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
                            {{-- <div class="square-switch">
                                <input type="checkbox" id="72" data-product-id="72" switch="none">
                                <label for="72" data-on-label="On" data-off-label="Off"></label>
                            </div> --}}

                            <!-- end row -->

                        </form>
                    {{-- </div>
                </div> --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light waves-effect " data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary waves-effect waves-light btn-save-addnew-tenant">Save</button>
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



            $table.on('click','.js-remove-tenant', function(){
                if(confirm('bạn có chắc muốn xóa tenant này không?')){
                    // get tenant id
                    $tenantId = $(this).siblings('input.tenant-id').val();
                    // get row
                    $row = $(this).closest('tr');
                    // call ajax to remove tenant in database
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
            $('a#add-new-tenant').click(function(){
                // show modal
                $addnewtenantModal = $('#addnewtenantmodal');
                $addnewtenantModal.modal('show');

            });
            // submit the form inordor to call route add new like normal addnew, no need to call ajax
            $('.modal .btn-save-addnew-tenant').click(function(){
                // submit the form
                $('form').submit();
            })

        </script>
    {{-- end for list tags page  --}}


     {{-- other function  --}}

     {{-- end other function  --}}

@endpush
