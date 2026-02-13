@extends('layouts.app')

@section('title', 'Tạo Đơn nhập hàng mới')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('don-nhap.index') }}" class="btn btn-outline-secondary me-3">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h2 class="h4 mb-0 fw-bold">Tạo Đơn nhập hàng mới</h2>
                <p class="text-muted mb-0 small">Điền thông tin bên dưới để tạo phiếu nhập kho</p>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body p-4">
                <form action="{{ route('don-nhap.store') }}" method="POST" id="donNhapForm">
                    @csrf
                    
                    <!-- Section: Nhà Cung Cấp -->
                    <div class="mb-4 pb-4 border-bottom">
                        <label class="form-label fw-bold text-uppercase small text-muted mb-3">
                            <i class="bi bi-building me-1"></i> Thông tin Nhà Cung Cấp
                        </label>
                        <select name="FK_Id_NCC" class="form-select form-select-lg @error('FK_Id_NCC') is-invalid @enderror" required>
                            <option value="">-- Chọn Nhà Cung Cấp --</option>
                            @foreach($nccs as $ncc)
                            <option value="{{ $ncc->Id_NCC }}">{{ $ncc->Ten_NCC }}</option>
                            @endforeach
                        </select>
                        @error('FK_Id_NCC') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="form-text mt-2"><i class="bi bi-info-circle"></i> Chọn nhà cung cấp từ danh sách đối tác đã đăng ký.</div>
                    </div>

                    <!-- Section: Hàng Hóa -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <label class="form-label fw-bold text-uppercase small text-muted mb-0">
                                <i class="bi bi-box-seam me-1"></i> Chi tiết Hàng hóa
                            </label>
                            
                            {{-- Filter Control --}}
                            <div class="d-flex align-items-center">
                                <label for="loai-hang-filter" class="me-2 small text-muted">Lọc nhanh:</label>
                                <select id="loai-hang-filter" class="form-select form-select-sm" style="width: 200px;">
                                    <option value="">-- Tất cả loại hàng --</option>
                                    @foreach($loaiHangs as $lh)
                                    <option value="{{ $lh->Id_LoaiHang }}">{{ $lh->Name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="bg-light rounded-3 p-3 mb-3">
                            <div id="items-container">
                                <div class="row g-3 mb-3 item-row align-items-end">
                                    <div class="col-md-7">
                                        <label class="form-label small text-muted">Mặt hàng</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                                            <select name="items[0][FK_Id_MatHang]" class="form-select mat-hang-select" required>
                                                <option value="">-- Chọn mặt hàng --</option>
                                                @foreach($matHangs as $mh)
                                                <option value="{{ $mh->Id_MatHang }}" data-loai="{{ $mh->FK_Id_LoaiHang }}">
                                                    {{ $mh->Ten_MatHang }} — ({{ number_format($mh->DonGia) }} ₫)
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label small text-muted">Số lượng</label>
                                        <input type="number" name="items[0][Count]" class="form-control" placeholder="0" min="1" required>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-outline-danger w-100 remove-item" disabled>
                                            <i class="bi bi-trash"></i> Xóa
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-center mt-3 pt-3 border-top border-white">
                                <button type="button" class="btn btn-light border text-primary fw-medium" id="add-item">
                                    <i class="bi bi-plus-circle-fill me-1"></i> Thêm dòng mặt hàng
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-5 pt-3 border-top">
                        <a href="{{ route('don-nhap.index') }}" class="btn btn-light me-md-2 px-4">Hủy bỏ</a>
                        <button type="submit" class="btn btn-primary px-5 fw-bold shadow-sm">
                            <i class="bi bi-save me-2"></i> Hoàn tất Đơn nhập
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/don-nhap-create.js') }}"></script>
@endsection

