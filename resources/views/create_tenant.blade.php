@extends('master')
@section('content')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Coupon</h4>

            <div class="page-title-right">
                <div >
                    {{-- <a href="{{route('admin.coupons.index')}}" class="btn btn-outline-info waves-effect waves-light" ><span ><i class="fas fa-arrow-left"></i> Quay lại danh sách coupon</span></a> --}}
                </div>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

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
                    <div class="button-items">
                        <button type="submit" class="btn btn-success waves-effect waves-light float-end">
                            <i class="fas fa-save"></i> Lưu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
