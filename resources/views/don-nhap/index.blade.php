@extends('layouts.app')

@section('title', 'Danh sách Đơn nhập hàng')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 mb-1 fw-bold">Danh sách Đơn nhập hàng</h2>
        <p class="text-muted mb-0">Quản lý các đợt nhập hàng từ nhà cung cấp</p>
    </div>
    <a href="{{ route('don-nhap.create') }}" class="btn btn-primary d-flex align-items-center">
        <i class="bi bi-plus-lg me-2"></i> Tạo Đơn mới
    </a>
</div>

@forelse($donNhaps as $don)
<div class="card mb-4">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <div class="rounded-circle bg-light p-2 me-3 text-primary">
                <i class="bi bi-receipt fs-5"></i>
            </div>
            <div>
                <span class="d-block fw-bold">Đơn nhập #{{ $don->Id_DonNhapHang }}</span>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-4">
            <div class="col-md-4 border-end">
                <h6 class="text-uppercase text-muted small fw-bold mb-3">Nhà Cung Cấp</h6>
                <div class="d-flex">
                    <div class="me-3 mt-1">
                        <i class="bi bi-building text-secondary"></i>
                    </div>
                    <div>
                        <p class="fw-bold mb-1 text-dark">{{ $don->ncc->Ten_NCC }}</p>
                        <p class="mb-1 text-secondary small">
                            <i class="bi bi-geo-alt me-1"></i> {{ $don->ncc->DiaChi ?? 'N/A' }}
                        </p>
                        <p class="mb-0 text-secondary small">
                            <i class="bi bi-envelope me-1"></i> {{ $don->ncc->Email ?? 'N/A' }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <h6 class="text-uppercase text-muted small fw-bold mb-3">Thông tin hàng hóa</h6>
                <div class="table-responsive">
                    <table class="table table-sm table-borderless align-middle mb-0">
                        <thead class="bg-light text-secondary">
                            <tr>
                                <th class="ps-3 py-2" style="width: 50%">Mặt hàng</th>
                                <th class="text-end py-2">Đơn giá</th>
                                <th class="text-center py-2">Số lượng</th>
                                <th class="text-end pe-3 py-2">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($don->chiTiet as $ct)
                            <tr>
                                <td class="ps-3">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-box-seam text-muted me-2"></i>
                                        {{ $ct->matHang->Ten_MatHang }}
                                    </div>
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
                                <td colspan="3" class="text-end py-2 fw-bold text-uppercase small text-muted">Tổng cộng</td>
                                <td class="text-end pe-3 py-2 fw-bold text-primary fs-6">
                                    {{ number_format($don->chiTiet->sum(function($ct) { return $ct->matHang->DonGia * $ct->Count; })) }} ₫
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@empty
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
@endsection
