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

{{-- ==================== PHẦN 2: DANH SÁCH ĐƠN NHẬP HÀNG (DẠNG CARD) ==================== --}}
{{-- Mỗi đơn hàng hiển thị dạng card: header chứa mã đơn + NCC + tổng tiền,
     body chứa bảng chi tiết mặt hàng, footer chứa nút hành động.
     Dữ liệu chi tiết đã eager-load sẵn, render trực tiếp không cần click. --}}
<div class="d-flex justify-content-between align-items-center mb-3">
    <h6 class="mb-0 fw-bold">
        <i class="bi bi-receipt me-2 text-primary"></i> Đơn nhập hàng
    </h6>
    <span class="badge bg-light text-primary border rounded-pill fs-6">
        Tổng: {{ $dsDonNhap->total() }} đơn
    </span>
</div>

@forelse($dsDonNhap as $don)
@php
    $tongTien = $don->chiTiet->sum(function($ct) {
        return $ct->matHang->DonGia * $ct->Count;
    });
@endphp
<div class="card mb-3 border-0 shadow-sm" style="border-left: 4px solid #4361ee !important; transition: box-shadow 0.2s ease;"
     onmouseenter="this.style.boxShadow='0 4px 15px rgba(67,97,238,0.15)'"
     onmouseleave="this.style.boxShadow='0 .125rem .25rem rgba(0,0,0,.075)'">

    {{-- Card Header: Badge mã đơn + NCC (trái) | Nút hành động (phải) --}}
    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
            <span class="badge bg-primary rounded-pill px-3 py-2 fs-6">#{{ $don->Id_DonNhapHang }}</span>
            <div>
                <div class="fw-bold text-dark">{{ $don->ncc->Ten_NCC }}</div>
                <small class="text-muted">{{ $don->chiTiet->count() }} mặt hàng</small>
            </div>
        </div>
        {{-- Nút hành động: Xem chi tiết, Sửa, Xóa — nằm bên phải header --}}
        <div class="d-flex gap-2">
            <button class="btn btn-sm btn-primary" title="Xem chi tiết">
                <i class="bi bi-eye"></i>
            </button>
            <button class="btn btn-sm btn-warning" title="Sửa">
                <i class="bi bi-pencil-square"></i>
            </button>
            <button class="btn btn-sm btn-danger" title="Xóa">
                <i class="bi bi-trash"></i>
            </button>
        </div>
    </div>

    {{-- Card Body: Bảng chi tiết mặt hàng — borderless, compact --}}
    <div class="card-body pt-0 pb-2 px-4">
        <table class="table table-borderless table-sm align-middle mb-0" style="font-size: 0.875rem;">
            <thead>
                <tr style="border-bottom: 2px solid #e9ecef;">
                    <th class="text-muted fw-semibold py-2" style="width: 45%">Mặt hàng</th>
                    <th class="text-muted fw-semibold text-center py-2">Đơn vị</th>
                    <th class="text-muted fw-semibold text-end py-2">Đơn giá</th>
                    <th class="text-muted fw-semibold text-center py-2">SL</th>
                    <th class="text-muted fw-semibold text-end py-2">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach($don->chiTiet as $ct)
                <tr style="border-bottom: 1px solid #f5f5f5;">
                    <td class="py-2 fw-medium text-dark">{{ $ct->matHang->Ten_MatHang }}</td>
                    <td class="py-2 text-center text-muted">{{ $ct->matHang->DonViTinh }}</td>
                    <td class="py-2 text-end text-muted">{{ number_format($ct->matHang->DonGia) }} ₫</td>
                    <td class="py-2 text-center">
                        <span class="fw-bold">{{ $ct->Count }}</span>
                    </td>
                    <td class="py-2 text-end fw-semibold text-dark">
                        {{ number_format($ct->matHang->DonGia * $ct->Count) }} ₫
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Card Footer: Chỉ hiển thị Tổng cộng --}}
    <div class="card-footer bg-white border-top py-2 px-4 d-flex justify-content-end align-items-center">
        <small class="text-muted text-uppercase me-2">Tổng cộng:</small>
        <span class="fw-bold text-danger fs-6">{{ number_format($tongTien) }} ₫</span>
    </div>
</div>
@empty
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
@endforelse

{{-- Tổng cộng toàn bộ --}}
@if($dsDonNhap->count() > 0)
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body d-flex justify-content-between align-items-center py-2">
        <span class="text-muted small fst-italic">Tổng số đơn: {{ $dsDonNhap->total() }}</span>
        <span class="fw-bold text-danger fs-5">Tổng cộng: {{ number_format($tongCong) }} ₫</span>
    </div>
</div>
@endif

{{-- Phân trang: appends(request()->query()) giữ lại tham số lọc NCC khi chuyển trang --}}
<div class="mt-4 d-flex justify-content-center small">
    {{ $dsDonNhap->appends(request()->query())->links() }}
</div>

{{-- Script xử lý: click dòng NCC để toggle checkbox --}}
<script src="{{ asset('js/don-nhap-index.js') }}"></script>
@endsection
