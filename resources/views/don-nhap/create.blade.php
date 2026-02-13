@extends('layouts.app')

@section('title', 'Tạo Đơn nhập hàng mới')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h3 class="mb-0">Tạo Đơn nhập hàng mới</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('don-nhap.store') }}" method="POST" id="donNhapForm">
            @csrf
            <div class="mb-4">
                <label class="form-label fw-bold">Nhà Cung Cấp</label>
                <select name="FK_Id_NCC" class="form-select @error('FK_Id_NCC') is-invalid @enderror" required>
                    <option value="">-- Chọn Nhà Cung Cấp --</option>
                    @foreach($nccs as $ncc)
                    <option value="{{ $ncc->Id_NCC }}">{{ $ncc->Ten_NCC }}</option>
                    @endforeach
                </select>
                @error('FK_Id_NCC') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <hr>

            <h5 class="mb-3">Danh sách mặt hàng</h5>

            {{-- Bộ lọc theo Loại hàng (tùy chọn) --}}
            <div class="mb-3">
                <label class="form-label text-muted">Lọc theo Loại hàng (tùy chọn)</label>
                <select id="loai-hang-filter" class="form-select">
                    <option value="">-- Tất cả loại hàng --</option>
                    @foreach($loaiHangs as $lh)
                    <option value="{{ $lh->Id_LoaiHang }}">{{ $lh->Name }}</option>
                    @endforeach
                </select>
            </div>

            <div id="items-container">
                <div class="row g-3 mb-3 item-row">
                    <div class="col-md-6">
                        <select name="items[0][FK_Id_MatHang]" class="form-select mat-hang-select" required>
                            <option value="">-- Chọn Mặt Hàng --</option>
                            @foreach($matHangs as $mh)
                            <option value="{{ $mh->Id_MatHang }}" data-loai="{{ $mh->FK_Id_LoaiHang }}">{{ $mh->Ten_MatHang }} — [{{ $mh->loaiHang->Name }}] ({{ number_format($mh->DonGia) }} VNĐ)</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="items[0][Count]" class="form-control" placeholder="Số lượng" min="1" required>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-outline-danger w-100 remove-item" disabled>Xóa</button>
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-outline-success mb-4" id="add-item">
                + Thêm Mặt Hàng
            </button>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="{{ route('don-nhap.index') }}" class="btn btn-light me-md-2">Hủy bỏ</a>
                <button type="submit" class="btn btn-primary btn-lg px-5">Hoàn tất & Lưu đơn</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let itemCount = 1;
    const container = document.getElementById('items-container');
    const addButton = document.getElementById('add-item');
    const loaiHangFilter = document.getElementById('loai-hang-filter');

    // Lọc mặt hàng theo loại hàng
    loaiHangFilter.addEventListener('change', function() {
        const selectedLoai = this.value;
        document.querySelectorAll('.mat-hang-select').forEach(select => {
            const currentValue = select.value;
            select.querySelectorAll('option').forEach(option => {
                if (!option.value) return; // Bỏ qua option placeholder
                if (!selectedLoai || option.dataset.loai === selectedLoai) {
                    option.style.display = '';
                } else {
                    option.style.display = 'none';
                }
            });
            // Reset nếu mặt hàng đang chọn không thuộc loại mới
            if (selectedLoai && select.querySelector(`option[value="${currentValue}"]`)?.dataset.loai !== selectedLoai) {
                select.value = '';
            }
        });
    });

    // Thêm dòng mặt hàng mới
    addButton.addEventListener('click', () => {
        const firstRow = document.querySelector('.item-row');
        const newRow = firstRow.cloneNode(true);

        const select = newRow.querySelector('select');
        const input = newRow.querySelector('input');
        const removeBtn = newRow.querySelector('.remove-item');

        select.name = `items[${itemCount}][FK_Id_MatHang]`;
        select.value = "";
        input.name = `items[${itemCount}][Count]`;
        input.value = "";
        removeBtn.disabled = false;

        removeBtn.addEventListener('click', function() {
            newRow.remove();
        });

        container.appendChild(newRow);
        itemCount++;

        // Áp dụng bộ lọc cho dòng mới
        loaiHangFilter.dispatchEvent(new Event('change'));
    });
</script>
@endsection
