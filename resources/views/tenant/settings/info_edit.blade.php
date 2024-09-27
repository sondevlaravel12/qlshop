@extends('app.master')
@section('content')
<h1>Chỉnh sửa Thông tin Tenant</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form action="{{ route('tenant.settings.info.update') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- Upload Logo (Nếu cần thêm thông tin logo trong TenantInfo) -->
    <div class="form-group">
        <label for="logo">Logo</label>
        <input type="file" name="logo" class="form-control" id="logo" accept="image/*">
        @if($tenantInfo && $tenantInfo->hasMedia('logo'))
            <img src="{{ $tenantInfo->getFirstMediaUrl('logo') }}" alt="Logo" width="100" id="current-logo" class="mt-2">
        @else
            <img src="{{ asset('storage/logos/default-logo.png') }}" alt="Logo" width="100" id="current-logo" class="mt-2">
        @endif
        <!-- Hình ảnh preview sẽ được hiển thị ở đây -->
        <img id="logo-preview" src="#" alt="Logo Preview" width="100" class="mt-2" style="display: none;">
        <button type="button" id="remove-logo" class="btn btn-danger mt-2" style="display: none;">Xóa Logo</button>
    </div>

    <!-- Địa Chỉ -->
    <div class="form-group">
        <label for="address">Địa Chỉ</label>
        <input type="text" name="address" class="form-control" id="address" value="{{ old('address', $tenantInfo->address ?? '') }}">
    </div>

    <!-- Số Điện Thoại -->
    <div class="form-group">
        <label for="phone">Số Điện Thoại</label>
        <input type="text" name="phonebase" class="form-control" id="phone" value="{{ old('phonebase', $tenantInfo->phonebase ?? '') }}">
    </div>

    <!-- Facebook -->
    <div class="form-group">
        <label for="facebook">Facebook</label>
        <input type="url" name="facebook_url" class="form-control" id="facebook" value="{{ old('facebook_url', $tenantInfo->facebook_url ?? '') }}">
    </div>

    <!-- Thêm các trường thông tin khác nếu cần -->

    <button type="submit" class="btn btn-primary">Lưu Thông tin Tenant</button>
</form>
@endsection
@push('scripts')
<script>
    document.getElementById('logo').addEventListener('change', function(event) {
    const [file] = this.files;
    const logoPreview = document.getElementById('logo-preview');
    const currentLogo = document.getElementById('current-logo');
    const removeLogoButton = document.getElementById('remove-logo');

    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function(e) {
            logoPreview.src = e.target.result;
            logoPreview.style.display = 'block';
            currentLogo.style.display = 'none';
            removeLogoButton.style.display = 'inline-block';
        }
        reader.readAsDataURL(file);
    } else {
        alert('Vui lòng chọn một tệp hình ảnh hợp lệ.');
        logoPreview.style.display = 'none';
        currentLogo.style.display = 'block';
        removeLogoButton.style.display = 'none';
        this.value = '';
    }
});

document.getElementById('remove-logo').addEventListener('click', function() {
    const logoInput = document.getElementById('logo');
    const logoPreview = document.getElementById('logo-preview');
    const currentLogo = document.getElementById('current-logo');
    const removeLogoButton = document.getElementById('remove-logo');

    logoInput.value = '';
    logoPreview.src = '#';
    logoPreview.style.display = 'none';
    currentLogo.style.display = 'block';
    removeLogoButton.style.display = 'none';
});

</script>
@endpush
