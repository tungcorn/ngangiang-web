@extends('layouts.app')

@section('title', 'Danh sách Đơn nhập hàng')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Danh sách Đơn nhập hàng</h1>
    <a href="{{ route('don-nhap.create') }}" class="btn btn-primary">Tạo Đơn mới</a>
</div>

@forelse($donNhaps as $don)
<div class="card shadow-sm mb-3">
    <div class="card-header bg-white d-flex justify-content-between">
        <span><strong>Đơn #{{ $don->Id_DonNhapHang }}</strong> — {{ \Carbon\Carbon::parse($don->NgayNhap)->format('d/m/Y H:i') }}</span>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <h6 class="text-muted">Thông tin Nhà Cung Cấp</h6>
                <p class="mb-1"><strong>{{ $don->ncc->Ten_NCC }}</strong></p>
                <p class="mb-1"><small>📍 {{ $don->ncc->DiaChi ?? 'Chưa có' }}</small></p>
                <p class="mb-0"><small>📧 {{ $don->ncc->Email ?? 'Chưa có' }}</small></p>
            </div>
            <div class="col-md-8">
                <h6 class="text-muted">Danh sách mặt hàng</h6>
                <table class="table table-sm table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Mặt hàng</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($don->chiTiet as $ct)
                        <tr>
                            <td>{{ $ct->matHang->Ten_MatHang }}</td>
                            <td>{{ number_format($ct->matHang->DonGia) }} VNĐ</td>
                            <td><span class="badge bg-primary">{{ $ct->Count }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@empty
<div class="alert alert-info">Chưa có đơn nhập hàng nào.</div>
@endforelse
@endsection
