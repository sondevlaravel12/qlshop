@extends('app.master')
@push('stylesheets')
   <!-- Lightbox css -->
   {{-- <link href="{{asset('backend/assets/libs/magnific-popup/magnific-popup.css')}}" rel="stylesheet" type="text/css" /> --}}


@endpush
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Inventory Product</h4>

            <div class="page-title-right">
                <div >
                    <a href="{{route('products.create')}}" class="btn btn-primary waves-effect waves-light" ><span ><i class="fas fa-plus"></i> Add inventory product</span></a>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">All Inventory Products</h4>
                {{-- <a href="{{ route('products.create') }}">create</a> --}}

                <table id="datatable-default" class="table table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                    <tr>


                        <th>Mã Hàng</th>
                        <th>Tên</th>
                        <th>Hình ảnh</th>
                        <th>DVT</th>
                        <th>Giá Bán</th>
                        <th>Giá Nhập</th>
                        <th>Action</th>
                        {{-- <th>Ngày Tạo</th> --}}
                        {{-- <th>Ngày Cập Nhật</th> --}}


                    </tr>
                    </thead>


                    <tbody>
                        @foreach ($products as $product)

                        <tr>
                            <td>{{$product->SKU}}</td>
                            <td>
                                {{$product->name}}

                            </td>
                            <td>
                                <img src="http://ccls3.test/media/800/conversions/trong_ca_rot_1-medium.jpg" class="img-thumbnail" alt="200x200" width="200" data-holder-rendered="true">
                            </td>
                            <td>

                                @foreach ($product->children as $child)

                                <span class="badge bg-info">{{ $child->sale_unit }} : {{ $child->price }}</span><br>

                                @endforeach

                            </td>
                            <td>{{$product->price}}</td>
                            <td>{{$product->original_price}}</td>
                            <td>
                                <form action="{{route('products.destroy', $product)}}" method="POST" id="confirm_delete">
                                    @method('DELETE')
                                    <a href="{{ route('products.show', $product) }}" class="popup-youtube btn btn-link mb-2"><i class="fas fa-eye"></i></a>
                                    <a href="{{route('products.edit',  $product)}}" class="btn btn-sm btn-link"><i class="far fa-edit"></i></a>
                                    <button type="submit" class="btn btn-sm btn-link" ><i class="far fa-trash-alt"></i></button>
                                    @csrf
                                </form>
                            </td>

                            {{-- <td>{{$product->created_at ? \Carbon\Carbon::parse($product->created_at)->diffForHumans() : ''}}</td> --}}
                            {{-- <td>{{$product->updated_at ? \Carbon\Carbon::parse($product->updated_at)->diffForHumans() : ''}}</td> --}}


                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->

@endsection
@push('scripts')

<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
 $.ajax({
        type: "get",
        url: "/test/ajax",
        data: {data:'datane'},
        dataType: "json",
        success: function (response) {

        }
    });
// $(document).ready( function () {
//     $('#datatable').DataTable({

//         });
// } );

</script>

@endpush

