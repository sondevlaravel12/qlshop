@extends('master')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Danh sách tenant off</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                {{-- <h4 class="card-title">Danh sách tenant</h4> --}}

                <div>

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
                                <th>Sửa / Xóa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($offTenants as $tenant)
                            <tr>
                                {{-- <th scope="row">1</th> --}}
                                <td>{{ $tenant->id }}</td>
                                <td>{{ $tenant->domains->count()>0?$tenant->domains->first()->domain:'' }}</td>
                                <td>{{ $tenant->created_at }}</td>
                                {{-- <td>{{ $tenant->updated_at }}</td> --}}
                                {{-- <td>{{ $tenant->discount }}&nbsp%</td> --}}
                                <td>{{ $tenant->expiry }}</td>
                                <td>{{ $tenant->status}}</td>
                                <td>
                                    <input class="tenant-id" type="hidden" id="{{ $tenant->id }}" value="{{ $tenant->id }}">
                                    <button  class="btn btn-sm js-remove-permanently-tenant"><i class="far fa-permanently-alt"></i>delete permanently</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
    {{-- https://www.jqueryscript.net/table/crud-bstable.html  --}}
    <script src="{{ asset('backend/assets/libs/crud-bstable/bstable.js') }}"></script>
    {{-- some global variable  --}}

    {{-- end some global variable  --}}

    {{-- for list tenants page  --}}
        {{-- using event binding with jQuery   --}}
        {{-- This is nice because now all the JS code is in one place and can be updated (in my opinion) more easily --}}
        <script>
            // need to use delegated events.
            $table.on('click','.js-remove-permanently-tenant', function(){
                if(confirm('bạn có chắc muốn xóa hoàn toàn tenant này không?xóa bao gồm cả database gắn kèm với nó')){
                    // get tenant id
                    $tenantId = $(this).siblings('input.tenant-id').val();
                    // get row
                    $row = $(this).closest('tr');
                    // call ajax to remove tenant in database
                    removePermanentlyTenant($tenantId).done(function(data){
                        // if remove successfully in db then remove this tag in view and show notification
                        $row.remove();
                        displayNotification(data['message']);
                    }).fail(function(data){
                        displayNotification("xóa Tenant thất bại","error");
                    });
                }else{

                }

            });


            function removePermanentlyTenant(tenantId){
                // return the ajax promise
                return $.ajax({
                    type: "get",
                    url: "/api/tenants/remove-permanently",
                    data: {id:tenantId},
                    dataType: "json",
                });
            }

        </script>
        {{-- end using event binding with jQuery   --}}

     {{-- other function  --}}

     {{-- end other function  --}}

@endpush
