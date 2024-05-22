@extends('app.master')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Slider</h4>

            <div class="page-title-right">
                <div >
                    <a href="{{route('products.index')}}" class="btn btn-info waves-effect waves-light" ><span ><i class="fas fa-arrow-left"></i> Back to all posts</span></a>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <tbody>
                            <tr>
                                <td>
                                    <strong>Tên sản phẩm:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{$product->name}}
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <strong>Hình ảnh:</strong>
                                </td>
                                <td><img src="{{$product->getFirstImage('products')}}" class="img-fluid" alt="Responsive image"></td>
                            </tr>
                            {{-- <tr>
                                <td>
                                    <strong>Category:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{$product->categories->first()? $product->categories->first()->title :''}}
                                    </span>
                                </td>
                        </tr> --}}
                        <tr>
                            <td>
                                <strong>Giá bán:</strong>
                            </td>
                            <td>
                                {{$product->price}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Excerpt:</strong>
                            </td>
                            <td>
                                <span>
                                    {{$product->excerpt}}
                                </span>
                            </td>
                        </tr>
                            <tr>
                                <td>
                                    <strong>Created:</strong>
                                </td>
                                <td>
                                    <span>
                                    {{\Carbon\Carbon::parse($product->created_at)->diffForHumans()}}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Updated:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{\Carbon\Carbon::parse($product->update_at)->diffForHumans()}}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Actions</strong></td>
                                <td>
                                    <form action="{{route('products.destroy', $product)}}" method="PRODUCT" id="confirm_delete">
                                        @method('DELETE')
                                        @csrf
                                        <a href="{{route('products.edit',$product)}}" class="btn btn-sm btn-link"><i class="far fa-edit"></i>
                                            Edit</a>
                                        <button type="submit" class="btn btn-sm btn-link" ><i class="far fa-trash-alt"></i> Delete</button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
