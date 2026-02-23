@extends('layouts.app')

@section('title', 'Danh sách Đơn nhập hàng')

@section('content')
{{-- Header: Tiêu đề + nút tạo đơn --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 mb-1 fw-bold">Quản lý Đơn nhập hàng</h2>
        <p class="text-muted mb-0">Quản lý các đợt nhập hàng từ nhà cung cấp</p>
    </div>
    <a href="{{ route('don-nhap.create') }}" class="btn btn-primary d-flex align-items-center shadow-sm">
        <i class="bi bi-plus-lg me-2"></i> Tạo Đơn mới
    </a>
</div>

{{-- ==================== PHẦN 1: BỘ LỌC (NCC + KHOẢNG NGÀY) ==================== --}}
{{-- Form lọc chung: gửi ncc_ids[], tu_ngay, den_ngay qua GET --}}
<div class="card mb-4 border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold">
            <i class="bi bi-funnel me-2 text-primary"></i> Bộ lọc
        </h6>
        <a href="{{ route('don-nhap.index') }}" class="btn btn-sm {{ empty($selectedNccIds) && !$tuNgay && !$denNgay ? 'btn-primary' : 'btn-outline-primary' }}">
            <i class="bi bi-arrow-counterclockwise me-1"></i> Xóa bộ lọc
        </a>
    </div>
    <div class="card-body p-0">
        <form action="{{ route('don-nhap.index') }}" method="GET" id="filterForm">

            {{-- Bảng NCC checkbox --}}
            <div class="table-responsive">
                <table class="table table-hover table-sm align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 45px" class="text-center">✔</th>
                            <th>Tên nhà cung cấp</th>
                            <th>Địa chỉ</th>
                            <th style="width: 200px">Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dsNCC as $ncc)
                        <tr class="ncc-row" style="cursor: pointer;">
                            <td class="text-center">
                                <input class="form-check-input ncc-checkbox" type="checkbox" name="ncc_ids[]"
                                    value="{{ $ncc->Id_NCC }}" id="ncc_{{ $ncc->Id_NCC }}"
                                    {{ in_array($ncc->Id_NCC, $selectedNccIds) ? 'checked' : '' }}>
                            </td>
                            <td class="fw-medium">{{ $ncc->Ten_NCC }}</td>
                            <td class="text-muted small">{{ $ncc->DiaChi ?? '—' }}</td>
                            <td class="text-muted small">{{ $ncc->Email ?? '—' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="border-top px-4 py-3">
                <div class="row g-3 align-items-end">
                    <div class="col-auto">
                        <label class="form-label small text-muted fw-semibold mb-1">
                            <i class="bi bi-calendar-event me-1"></i> Từ ngày
                        </label>
                        <input type="date" name="tu_ngay" class="form-control form-control-sm"
                               value="{{ $tuNgay }}" style="width: 170px;">
                    </div>
                    <div class="col-auto">
                        <label class="form-label small text-muted fw-semibold mb-1">
                            <i class="bi bi-calendar-event me-1"></i> Đến ngày
                        </label>
                        <input type="date" name="den_ngay" class="form-control form-control-sm"
                               value="{{ $denNgay }}" style="width: 170px;">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary btn-sm px-3">
                            <i class="bi bi-search me-1"></i> Lọc
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- ==================== PHẦN 2: BẢNG ĐƠN NHẬP HÀNG ==================== --}}
{{-- Danh sách đơn nhập dạng bảng gọn, mỗi đơn 1 dòng. Nút hành động bên phải.
     Click nút "Chi tiết" (👁) → mở Modal hiển thị chi tiết mặt hàng.
     Dữ liệu chi tiết đã eager-load sẵn, lưu trong div ẩn, JS inject vào modal. --}}
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold">
            <i class="bi bi-receipt me-2 text-primary"></i> Đơn nhập hàng
        </h6>
        <span class="badge bg-light text-primary border rounded-pill fs-6">
            Tổng: {{ $dsDonNhap->total() }} đơn
        </span>
    </div>
    <div class="card-body p-0">
        @if($dsDonNhap->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="tblDonNhap">
                <thead class="table-light">
                    <tr>
                        <th style="width: 80px">Mã đơn</th>
                        <th>Nhà cung cấp</th>
                        <th style="width: 120px" class="text-center">Ngày nhập</th>
                        <th>Mặt hàng</th>
                        <th class="text-center" style="width: 110px">Số mặt hàng</th>
                        <th class="text-end" style="width: 140px">Tổng tiền</th>
                        <th class="text-center" style="width: 150px">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dsDonNhap as $don)
                    @php
                        $tongTien = $don->chiTiet->sum(function($ct) {
                            return $ct->matHang->DonGia * $ct->Count;
                        });
                    @endphp
                    <tr>
                        <td class="fw-bold text-primary">#{{ $don->Id_DonNhapHang }}</td>
                        <td>{{ $don->ncc->Ten_NCC }}</td>
                        <td class="text-center">{{ $don->NgayNhap->format('d/m/Y') }}</td>
                        <td class="text-muted small" style="max-width: 250px;">
                            {{ $don->chiTiet->pluck('matHang.Ten_MatHang')->join(', ') }}
                        </td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark border">{{ $don->chiTiet->count() }}</span>
                        </td>
                        <td class="text-end fw-medium">{{ number_format($tongTien) }} ₫</td>
                        <td class="text-center">
                            {{-- Nút hành động: Xem chi tiết (Modal), Sửa, Xóa --}}
                            <button class="btn btn-sm btn-primary btn-chi-tiet"
                                    data-don-id="{{ $don->Id_DonNhapHang }}" title="Xem chi tiết">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-warning" title="Sửa">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" title="Xóa">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        {{-- Trạng thái rỗng: không có đơn hàng nào --}}
        <div class="text-center py-5">
            <div class="bg-light rounded-circle p-4 d-inline-block mb-3">
                <i class="bi bi-inbox fs-1 text-muted"></i>
            </div>
            <h5 class="text-muted">Chưa có đơn nhập hàng nào</h5>
            <p class="text-muted mb-4">Bắt đầu bằng cách tạo đơn nhập hàng mới.</p>
            <a href="{{ route('don-nhap.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-2"></i> Tạo Đơn ngay
            </a>
        </div>
        @endif
    </div>
    @if($dsDonNhap->count() > 0)
    {{-- Tổng số đơn và tổng cộng tiền --}}
    <div class="card-footer bg-white d-flex justify-content-between align-items-center py-2">
        <span class="text-muted small fst-italic">Tổng số đơn: {{ $dsDonNhap->total() }}</span>
        <span class="fw-bold text-danger">Tổng cộng: {{ number_format($tongCong) }} ₫</span>
    </div>
    @endif
</div>

{{-- Phân trang --}}
<div class="mt-4 d-flex justify-content-center small">
    {{ $dsDonNhap->appends(request()->query())->links() }}
</div>

{{-- ==================== MODAL XEM CHI TIẾT ĐƠN ==================== --}}
{{-- Modal Bootstrap duy nhất — nội dung được JS populate từ div ẩn khi click nút 👁. --}}
<div class="modal fade" id="modalChiTiet" tabindex="-1" aria-labelledby="modalChiTietLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header py-3" style="background: linear-gradient(135deg, #4361ee, #3a53d4);">
                <h6 class="modal-title fw-bold text-white" id="modalChiTietLabel">
                    <i class="bi bi-receipt me-2"></i> Chi tiết đơn nhập hàng
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>
            <div class="modal-body p-0" id="modalChiTietBody">
                {{-- Nội dung được JS inject từ div ẩn --}}
            </div>
        </div>
    </div>
</div>

{{-- Dữ liệu chi tiết pre-rendered — ẩn, JS lấy innerHTML inject vào modal body --}}
@foreach($dsDonNhap as $don)
@php
    $tongTienModal = $don->chiTiet->sum(function($ct) {
        return $ct->matHang->DonGia * $ct->Count;
    });
@endphp
<div class="d-none" id="detailContent_{{ $don->Id_DonNhapHang }}">
    {{-- Thông tin đơn --}}
    <div class="px-4 py-3 bg-light border-bottom">
        <div class="row">
            <div class="col-sm-3">
                <small class="text-muted text-uppercase fw-semibold">Mã đơn</small>
                <div class="fw-bold text-primary fs-5">#{{ $don->Id_DonNhapHang }}</div>
            </div>
            <div class="col-sm-3">
                <small class="text-muted text-uppercase fw-semibold">Nhà cung cấp</small>
                <div class="fw-bold">{{ $don->ncc->Ten_NCC }}</div>
            </div>
            <div class="col-sm-3">
                <small class="text-muted text-uppercase fw-semibold">Ngày nhập</small>
                <div class="fw-bold">{{ $don->NgayNhap->format('d/m/Y') }}</div>
            </div>
            <div class="col-sm-3">
                <small class="text-muted text-uppercase fw-semibold">Số mặt hàng</small>
                <div class="fw-bold">{{ $don->chiTiet->count() }}</div>
            </div>
        </div>
    </div>
    {{-- Bảng chi tiết mặt hàng --}}
    <div class="px-4 py-3">
        <table class="table table-sm table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 40px">#</th>
                    <th>Mặt hàng</th>
                    <th class="text-center">Đơn vị</th>
                    <th class="text-end">Đơn giá</th>
                    <th class="text-center">SL</th>
                    <th class="text-end">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach($don->chiTiet as $index => $ct)
                <tr>
                    <td class="text-muted">{{ $index + 1 }}</td>
                    <td class="fw-medium">{{ $ct->matHang->Ten_MatHang }}</td>
                    <td class="text-center text-muted">{{ $ct->matHang->DonViTinh }}</td>
                    <td class="text-end text-muted">{{ number_format($ct->matHang->DonGia) }} ₫</td>
                    <td class="text-center fw-bold">{{ $ct->Count }}</td>
                    <td class="text-end fw-semibold">{{ number_format($ct->matHang->DonGia * $ct->Count) }} ₫</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- Tổng cộng --}}
    <div class="px-4 py-3 bg-light border-top d-flex justify-content-end align-items-center">
        <span class="text-muted text-uppercase small me-3 fw-semibold">Tổng cộng:</span>
        <span class="fw-bold text-danger fs-5">{{ number_format($tongTienModal) }} ₫</span>
    </div>
</div>
@endforeach

{{-- Script xử lý tương tác --}}
<script src="{{ asset('js/don-nhap-index.js') }}"></script>
@endsection
