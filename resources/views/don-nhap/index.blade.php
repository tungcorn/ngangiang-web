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

{{-- ==================== PHẦN 1: BẢNG NCC (LISTCHECKBOX) ==================== --}}
{{-- Hiển thị danh sách NCC dạng bảng có cột checkbox để lọc đơn hàng.
     Tick vào NCC → form tự động submit lọc server-side.
     Không tick NCC nào = hiển thị tất cả đơn hàng. --}}
<div class="card mb-4 border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold">
            <i class="bi bi-building me-2 text-primary"></i> Nhà cung cấp (NCC)
        </h6>
        <a href="{{ route('don-nhap.index') }}" class="btn btn-sm {{ empty($selectedNccIds) ? 'btn-primary' : 'btn-outline-primary' }}">
            <i class="bi bi-arrow-counterclockwise me-1"></i> Tất cả
        </a>
    </div>
    <div class="card-body p-0">
        <form action="{{ route('don-nhap.index') }}" method="GET" id="filterForm">
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
                                    onchange="this.form.submit()"
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
        </form>
    </div>
</div>

{{-- ==================== PHẦN 2: BẢNG ĐƠN NHẬP HÀNG ==================== --}}
{{-- Danh sách đơn nhập dạng bảng với nút hành động inline (Chi tiết/Sửa/Xóa).
     Click vào dòng hoặc nút "Chi tiết" → expand inline hiển thị chi tiết đơn ngay bên dưới.
     Dữ liệu chi tiết đã eager-load sẵn, lưu trong data attribute dạng JSON. --}}
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
                        <th>Mặt hàng</th>
                        <th class="text-center" style="width: 110px">Số mặt hàng</th>
                        <th class="text-end" style="width: 140px">Tổng tiền</th>
                        <th class="text-center" style="width: 200px">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dsDonNhap as $don)
                    {{-- Dòng đơn hàng chính --}}
                    @php
                        $tongTien = $don->chiTiet->sum(function($ct) {
                            return $ct->matHang->DonGia * $ct->Count;
                        });
                    @endphp
                    <tr class="don-nhap-row" style="cursor: pointer;"
                        data-don-id="{{ $don->Id_DonNhapHang }}">
                        <td class="fw-bold text-primary">#{{ $don->Id_DonNhapHang }}</td>
                        <td>{{ $don->ncc->Ten_NCC }}</td>
                        <td class="text-muted small" style="max-width: 250px;">
                            {{ $don->chiTiet->pluck('matHang.Ten_MatHang')->join(', ') }}
                        </td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark border">{{ $don->chiTiet->count() }}</span>
                        </td>
                        <td class="text-end fw-medium">{{ number_format($tongTien) }} ₫</td>
                        <td class="text-center">
                            {{-- Nút hành động inline: Chi tiết (toggle detail), Sửa, Xóa --}}
                            <button class="btn btn-sm btn-primary btn-chi-tiet" title="Xem chi tiết">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-warning btn-sua" title="Sửa" onclick="event.stopPropagation();">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="btn btn-sm btn-danger btn-xoa" title="Xóa" onclick="event.stopPropagation();">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                    {{-- Dòng chi tiết ẩn — hiện khi click vào đơn hàng --}}
                    <tr class="chi-tiet-row d-none" id="chiTiet_{{ $don->Id_DonNhapHang }}">
                        <td colspan="6" class="p-0 border-0">
                            <div class="bg-light p-3 mx-2 mb-2 rounded-3 border">
                                <h6 class="fw-bold text-muted small text-uppercase mb-2">
                                    <i class="bi bi-box-seam me-1"></i> Chi tiết đơn #{{ $don->Id_DonNhapHang }}
                                </h6>
                                <table class="table table-sm table-borderless bg-white rounded mb-0">
                                    <thead class="text-secondary small">
                                        <tr>
                                            <th class="ps-3">Mặt hàng</th>
                                            <th class="text-end">Đơn giá</th>
                                            <th class="text-center">Số lượng</th>
                                            <th class="text-end pe-3">Thành tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($don->chiTiet as $ct)
                                        <tr>
                                            <td class="ps-3">
                                                <i class="bi bi-box-seam text-muted me-1"></i>
                                                {{ $ct->matHang->Ten_MatHang }}
                                            </td>
                                            <td class="text-end text-muted">{{ number_format($ct->matHang->DonGia) }} ₫</td>
                                            <td class="text-center">
                                                <span class="badge bg-light text-dark border">{{ $ct->Count }}</span>
                                            </td>
                                            <td class="text-end pe-3 fw-medium">
                                                {{ number_format($ct->matHang->DonGia * $ct->Count) }} ₫
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="border-top">
                                        <tr>
                                            <td colspan="4" class="text-end pe-3 py-2">
                                                <span class="fw-bold small text-muted me-2">TỔNG CỘNG:</span>
                                                <span class="fw-bold text-danger">{{ number_format($tongTien) }} ₫</span>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
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
    {{-- Tổng số đơn và tổng cộng tiền (tính trên toàn bộ đơn đang lọc, không chỉ trang hiện tại) --}}
    <div class="card-footer bg-white d-flex justify-content-between align-items-center py-2">
        <span class="text-muted small fst-italic">Tổng số đơn: {{ $dsDonNhap->total() }}</span>
        <span class="fw-bold text-danger">Tổng cộng: {{ number_format($tongCong) }} ₫</span>
    </div>
    @endif
</div>

{{-- Phân trang: appends(request()->query()) giữ lại tham số lọc NCC khi chuyển trang --}}
<div class="mt-4 d-flex justify-content-center small">
    {{ $dsDonNhap->appends(request()->query())->links() }}
</div>

{{-- Script xử lý: click dòng NCC để toggle checkbox, click dòng đơn để expand/collapse chi tiết --}}
<script src="{{ asset('js/don-nhap-index.js') }}"></script>
@endsection
