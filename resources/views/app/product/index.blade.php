@extends('app.master')
@push('stylesheets')
   <!-- Lightbox css -->
   {{-- <link href="{{asset('backend/assets/libs/magnific-popup/magnific-popup.css')}}" rel="stylesheet" type="text/css" /> --}}


@endpush
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Sản phẩm</h4>

            <div class="page-title-right">
                <div >
                    <a href="{{route('products.create')}}" class="btn btn-primary waves-effect waves-light" ><span ><i class="fas fa-plus"></i> Thêm sản phẩm</span></a>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Sản phẩm</h4>
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
                                <img src="{{$product->getFirstImage()  }}" class="img-thumbnail" alt="200x200" width="200" data-holder-rendered="true">
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
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    {{-- <a href="{{ route('products.show', $product) }}" class="popup-youtube btn btn-link mb-2"><i class="fas fa-eye"></i></a> --}}
                                    <button  class="popup-youtube btn btn-show-product mb-2"><i class="fas fa-eye"></i></button>
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
{{-- modal  --}}
{{-- modal show product  --}}
<div id="modal_insert_product" class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <form enctype="multipart/form-data" id="productForm">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sản phẩm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">SKU</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" name="SKU" value=""  >

                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Giá bán</label>
                                    <div class="col-sm-10">
                                        <input class="form-control auto_formatting_input_value" type="text" name="price" value=""  >

                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Giá vốn</label>
                                    <div class="col-sm-10">
                                        <input class="form-control auto_formatting_input_value" type="text" name="original_price" value=""  >

                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label" >Hình ảnh</label>
                                    <div class="col-sm-10">
                                        <img id="imagePreview" class="img-thumbnail" alt="no image is selected" width="150" src="{{ global_asset('asset/noimage.jpeg') }}" data-holder-rendered="true">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Ngày tạo</label>
                                    <div class="col-sm-10">
                                        <input class="form-control auto_formatting_input_value" type="text" name="created_at" value=""  >

                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Đơn vị tính cơ bản</label>
                                    <div class="col-sm-10">

                                        <input class="form-control" type="text" value="Gói" name="sale_unit" list="cars">

                                    </div>
                                </div>
                                <div id="sale_unit_holder">
                                    <div class="row mb-3">
                                        <a href="#collapseOne" class="text-dark collapsed" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapseOne">
                                            <div class="card-header" id="headingOne">
                                                <h6 class="m-0">
                                                    Đơn vị tính
                                                    <i class="float-end fas fa-angle-down"></i>
                                                </h6>
                                            </div>
                                        </a>

                                    </div>

                                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-bs-parent="#accordion" style="">
                                        <div class="row ">
                                            <div class="col-lg-12">
                                                <div class="card card-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="validationTooltip01" class="form-label">Tên đơn vị</label>
                                                            <input type="hidden" value="" id="sale_unit_lists">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="validationTooltip02" class="form-label">Giá bán</label>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="validationTooltipUsername" class="form-label">Giá vốn</label>
                                                        </div>
                                                        <div class="col-md-2">

                                                        </div>
                                                    </div>
                                                    <div id="show_item">

                                                    </div>


                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </form>
</div><!-- /.modal -->
{{-- end modal  --}}
@endsection
@push('scripts')

<script>
$('.btn-show-product').on('click', function(e){
    e.preventDefault();
    // get product id
    var $productId = $(this).siblings("input[name='product_id']").val();
    // call ajax to load data and show modal
    getProductInfo($productId).done(function(data){
    // console.log($productId);
    $modal_show_product = $('#modal_insert_product');
    $modal_show_product.find("#sale_unit_holder").hide();

    // fill in modal data
    $modal_show_product.find(".modal-title").html(data.name);
    $modal_show_product.find("input[name='price']").val(data.price);
    $modal_show_product.find("input[name='original_price']").val(data.original_price);
    $modal_show_product.find("input[name='sale_unit']").val(data.sale_unit);
    $modal_show_product.find("input[name='created_at']").val(data.created_at);
    $modal_show_product.find("input[name='SKU']").val(data.SKU);
    if(data.media.length>0){
        $modal_show_product.find("#imagePreview").attr('src',data.media[0].original_url);
    }
    if(data.children.length>0){

        $item = "";
        $.each(data.children,function(key,child){
            $item += `<div class="row">
                        <div class="col-md-4">
                            <div class="mb-3 position-relative">
                                <input value="`+ child.sale_unit +`" type="text" class="form-control auto_formatting_input_value" name="name">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3 position-relative">
                                <input value="`+child.price +`" type="text" class="form-control auto_formatting_input_value" name="su_price[]">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3 position-relative">
                                <input value="`+ child.original_price +`" type="text" class="form-control auto_formatting_input_value" name="su_original_price[]" >
                            </div>
                        </div>

                    </div>`;
        });
        $modal_show_product.find("#show_item").html($item);
        $modal_show_product.find("#sale_unit_holder").show();
    }
    // $modal_show_product.find("#sale_unit_holder").hide();

    // $modal_show_product.find("#imagePreview").attr('scr','hihi');

    // disabled input field
    $modal_show_product.find('input').attr('disabled','disabled');

    $modal_show_product.modal('show');
    })


})
function getProductInfo(product){
    return $.ajax({
            type: "get",
            url: '/products/' + product,
            data: {product:product},
            dataType: "json",
        });
}
//  $.ajax({
//         type: "get",
//         url: "/test/ajax",
//         data: {data:'datane'},
//         dataType: "json",
//         success: function (response) {

//         }
//     });
// $(document).ready( function () {
//     $('#datatable').DataTable({

//         });
// } );

</script>

@endpush

