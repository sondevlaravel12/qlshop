@extends('app.master')
@section('content')
    <h1>Chỉnh sửa Cài đặt</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('tenant.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="shipping_fee">Phí Giao Hàng</label>
            <input type="number" name="shipping_fee" class="form-control" id="shipping_fee" value="{{ $settings['shipping_fee']->value ?? '' }}">
        </div>

        <div>
            <label for="show_logo">Hiện Logo</label>
            <input type="checkbox" name="show_logo" id="show_logo" {{ $settings['show_logo']->value === 'true' ? 'checked' : '' }}>
        </div>

        <div>
            <label for="show_phone">Hiện Số Điện Thoại</label>
            <input type="checkbox" name="show_phone" id="show_phone" {{ $settings['show_phone']->value === 'true' ? 'checked' : '' }}>
        </div>

        <div>
            <label for="show_address">Hiện Địa Chỉ</label>
            <input type="checkbox" name="show_address" id="show_address" {{ $settings['show_address']->value === 'true' ? 'checked' : '' }}>
        </div>

        <div>
            <label for="show_website">Hiện Website</label>
            <input type="checkbox" name="show_website" id="show_website" {{ $settings['show_website']->value === 'true' ? 'checked' : '' }}>
        </div>

        <button type="submit" class="btn btn-primary">Lưu Cài Đặt</button>
    </form>
@endsection
