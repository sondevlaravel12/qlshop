@extends('backend.layouts.master')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Slider</h4>

            <div class="page-title-right">
                <div >
                    <a href="{{route('admin.posts.index')}}" class="btn btn-info waves-effect waves-light" ><span ><i class="fas fa-arrow-left"></i> Back to all posts</span></a>
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
                                    <strong>Title:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{$post->title}}
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <strong>Image:</strong>
                                </td>
                                <td><img src="{{$post->getFirstImage()}}" class="img-fluid" alt="Responsive image"></td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Category:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{$post->categories->first()? $post->categories->first()->title :''}}
                                    </span>
                                </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Content:</strong>
                            </td>
                            <td>
                                {!!$post->content!!}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Excerpt:</strong>
                            </td>
                            <td>
                                <span>
                                    {{$post->excerpt}}
                                </span>
                            </td>
                        </tr>
                            <tr>
                                <td>
                                    <strong>Created:</strong>
                                </td>
                                <td>
                                    <span>
                                    {{\Carbon\Carbon::parse($post->created_at)->diffForHumans()}}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Updated:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{\Carbon\Carbon::parse($post->update_at)->diffForHumans()}}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Actions</strong></td>
                                <td>
                                    <form action="{{route('admin.posts.destroy', $post)}}" method="POST" id="confirm_delete">
                                        @method('DELETE')
                                        @csrf
                                        <a href="{{route('admin.posts.edit',$post)}}" class="btn btn-sm btn-link"><i class="far fa-edit"></i>
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
