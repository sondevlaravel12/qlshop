@extends('app.master')
@push('stylesheets')
 <!-- Image-Uploader -->
    <!--Material Design Iconic Font-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="{{global_asset('asset/admin/stylesheets/image-uploader.min.css')}}">
@endpush
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Sản Phẩm</h4>

            <div class="page-title-right">
                <div >
                    <a href="{{route('products.index')}}" class="btn btn-info waves-effect waves-light" ><span ><i class="fas fa-arrow-left"></i> Xem danh sách sản phẩm</span></a>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <form action="{{route('products.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <label for="example-text-input" class="col-sm-2 col-form-label">Tên</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="name" value="{{old('name')}}"  >
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="example-text-input" class="col-sm-2 col-form-label">Giá bán</label>
                        <div class="col-sm-10">
                            <input class="form-control auto_formatting_input_value" type="text" name="price" value="{{old('price')}}"  >
                            @error('price')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="example-text-input" class="col-sm-2 col-form-label">Giá vốn</label>
                        <div class="col-sm-10">
                            <input class="form-control auto_formatting_input_value" type="text" name="original_price" value="{{old('original_price')}}"  >
                            @error('original_price')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" >Hình ảnh</label>
                        <div class="col-sm-10">
                            <div class="input-images-1" style="padding-top: .5rem;"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="example-text-input" class="col-sm-2 col-form-label">Đơn vị tính cơ bản</label>
                        <div class="col-sm-10">

                            <input class="form-control" type="text" value="Gói" name="sale_unit" list="cars">
                            <datalist id="cars">
                                <option>Volvo</option>
                                <option>Saab</option>
                                <option>Mercedes</option>
                                <option>Audi</option>
                            </datalist>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <a href="#collapseOne" class="text-dark collapsed" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapseOne">
                            <div class="card-header" id="headingOne">
                                <h6 class="m-0">
                                    Thêm Đơn vị tính
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
                                        </div>
                                        <div class="col-md-3">
                                            <label for="validationTooltip02" class="form-label">Giá bán</label>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="validationTooltipUsername" class="form-label">Giá vốn</label>
                                        </div>
                                        <div class="col-md-2">

                                        </div>
                                    </div>
                                    <div id="show_item">

                                    </div>
                                    <div class="row">
                                        <div class="col-md-10"></div>

                                        <div class="col-md-2 ">
                                            <div class="mb-3 ">
                                                <button type="button" class="btn btn-light waves-effect add_item_btn ">
                                                     <i class="fas fa-plus-circle"></i>&nbspThêm
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>


                    <!-- end row -->
                    <div class="button-items">
                        <button type="submit" class="btn btn-success waves-effect waves-light">
                            <i class="fas fa-save"></i> Lưu
                        </button>
                        <a href="{{ route('products.index') }}" class="btn btn-light waves-effect waves-light"><span class="fas fa-ban"></span> &nbsp;Bỏ qua</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
    function preview() {
        imagePreview.src=URL.createObjectURL(event.target.files[0]);
}
</script>
<script>
    $(document).ready(function(){
        var $saleUnitsJson = {!! json_encode($saleUnits) !!};
        // $saleUnitsJson.each(function(index, element){
        //     console.log(element);
        // })
        var sale_unit_lists = ''
        $.each($saleUnitsJson, function(index, eletment){
            sale_unit_lists += '<option>'+eletment.title+'</option>';
        })
        //console.log($saleUnitsJson);

        $('.add_item_btn').click(function(e){
            e.preventDefault();
            var $newrow = `<div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-3 position-relative">
                                                    <input type="text" class="form-control" name="su_name[]" list="saleunit_list" >
                                                    <datalist id="saleunit_list">`+
                                                        sale_unit_lists
                                                        +`
                                                    </datalist>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3 position-relative">
                                                    <input class="auto_formatting_input_value" type="text" class="form-control" name="su_price[]">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3 position-relative">
                                                    <input class="auto_formatting_input_value" type="text" class="form-control" name="su_original_price[]" >
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="mb-3 ">
                                                    <button type="button" class="btn btn-light waves-effect remove_item_btn">
                                                         <i class="fas fa-trash-alt"></i>&nbspXóa
                                                    </button>
                                                </div>
                                            </div>
                                        </div>`;
            $('#show_item').append($newrow);

        });
        $(document).on('click','.remove_item_btn',function(e){
            e.preventDefault();
            let $row = $(this).parent().parent().parent();
            $row.remove();
        });
    })
</script>

<!-- Image-Uploader -->
<script type="text/javascript" src="{{global_asset('asset/custome/js/image-uploader.min.js')}}"></script>
<script src="{{ global_asset('asset/custome/js/auto_formatting_input_value.js') }}"></script>
<Script>

$('.input-images-1').imageUploader({
    imagesInputName: 'photos',

    extensions: ['.jpg','.jpeg','.png','.gif','.svg'],
    mimes: ['image/jpeg','image/png','image/gif','image/svg+xml'],
    maxSize: 10000,
    maxFiles: 1,


});
</Script>

@endpush
