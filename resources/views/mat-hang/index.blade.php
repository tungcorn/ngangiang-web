@extends('layouts.app')

@section('title', 'Quản lý Mặt hàng')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 mb-1 fw-bold">Quản lý Mặt hàng</h2>
        <p class="text-muted mb-0">Danh mục sản phẩm trong hệ thống</p>
    </div>
    <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalThem">
        <i class="bi bi-plus-lg me-1"></i> Thêm mặt hàng
    </button>
</div>

{{-- Bộ lọc --}}
<div class="card mb-4 border-0 shadow-sm">
    <div class="card-body py-3">
        <form action="{{ route('mat-hang.index') }}" method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-auto">
                    <label class="form-label small text-muted fw-semibold mb-1">Loại hàng</label>
                    <select name="loai_hang" class="form-select form-select-sm" style="width: 200px;">
                        <option value="">-- Tất cả --</option>
                        @foreach($dsLoaiHang as $lh)
                        <option value="{{ $lh->Id_LoaiHang }}" {{ request('loai_hang') == $lh->Id_LoaiHang ? 'selected' : '' }}>{{ $lh->Name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-auto">
                    <label class="form-label small text-muted fw-semibold mb-1">Đơn vị tính</label>
                    <select name="don_vi" class="form-select form-select-sm" style="width: 160px;">
                        <option value="">-- Tất cả --</option>
                        @foreach($dsDonVi as $dv)
                        <option value="{{ $dv }}" {{ request('don_vi') == $dv ? 'selected' : '' }}>{{ $dv }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary btn-sm px-3">
                        <i class="bi bi-search me-1"></i> Lọc
                    </button>
                    <a href="{{ route('mat-hang.index') }}" class="btn btn-outline-secondary btn-sm px-3">
                        <i class="bi bi-arrow-counterclockwise me-1"></i> Xóa lọc
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold"><i class="bi bi-box me-2 text-primary"></i> Mặt hàng</h6>
        <span class="badge bg-light text-primary border rounded-pill fs-6">Tổng: {{ $dsMatHang->total() }}</span>
    </div>
    <div class="card-body p-0">
        @if($dsMatHang->total() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 60px" class="text-center">#</th>
                        <th>Tên mặt hàng</th>
                        <th style="width: 150px">Loại hàng</th>
                        <th class="text-center" style="width: 100px">Đơn vị</th>
                        <th class="text-end" style="width: 130px">Đơn giá</th>
                        <th class="text-center" style="width: 150px">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dsMatHang as $index => $mh)
                    <tr>
                        <td class="text-center text-muted">{{ $dsMatHang->firstItem() + $index }}</td>
                        <td class="fw-medium">{{ $mh->Ten_MatHang }}</td>
                        <td><span class="badge bg-light text-dark border">{{ $mh->loaiHang->Name ?? '—' }}</span></td>
                        <td class="text-center text-muted">{{ $mh->DonViTinh }}</td>
                        <td class="text-end">{{ number_format($mh->DonGia) }} ₫</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalSua{{ $mh->Id_MatHang }}" title="Sửa">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <form action="{{ route('mat-hang.destroy', $mh->Id_MatHang) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Xác nhận xóa mặt hàng: {{ $mh->Ten_MatHang }}?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" title="Xóa"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>

                    {{-- Modal Sửa --}}
                    <div class="modal fade" id="modalSua{{ $mh->Id_MatHang }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <form action="{{ route('mat-hang.update', $mh->Id_MatHang) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold"><i class="bi bi-pencil me-2"></i>Sửa mặt hàng</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Tên mặt hàng</label>
                                            <input type="text" name="Ten_MatHang" class="form-control" value="{{ $mh->Ten_MatHang }}" required>
                                        </div>
                                        <div class="row g-3 mb-3">
                                            <div class="col-6">
                                                <label class="form-label fw-semibold">Đơn vị tính</label>
                                                <select name="DonViTinh" class="form-select" required>
                                                    @foreach($dsDonVi as $dv)
                                                    <option value="{{ $dv }}" {{ $mh->DonViTinh == $dv ? 'selected' : '' }}>{{ $dv }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label fw-semibold">Đơn giá (₫)</label>
                                                <input type="number" name="DonGia" class="form-control" value="{{ $mh->DonGia }}" min="0" required>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Loại hàng</label>
                                            <select name="FK_Id_LoaiHang" class="form-select" required>
                                                @foreach($dsLoaiHang as $lh)
                                                <option value="{{ $lh->Id_LoaiHang }}" {{ $mh->FK_Id_LoaiHang == $lh->Id_LoaiHang ? 'selected' : '' }}>{{ $lh->Name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                        <button type="submit" class="btn btn-primary">💾 Lưu</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-box fs-1 text-muted"></i>
            <h5 class="text-muted mt-3">Chưa có mặt hàng nào</h5>
        </div>
        @endif
    </div>
    @if($dsMatHang->hasPages())
    <div class="card-footer bg-white border-top py-3 d-flex justify-content-center">
        {{ $dsMatHang->links() }}
    </div>
    @endif
</div>

{{-- Modal Thêm --}}
<div class="modal fade" id="modalThem" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('mat-hang.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle me-2"></i>Thêm mặt hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tên mặt hàng</label>
                        <input type="text" name="Ten_MatHang" class="form-control" placeholder="VD: Laptop Dell XPS 15" required>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold">Đơn vị tính</label>
                            <select name="DonViTinh" class="form-select" required>
                                <option value="">-- Chọn đơn vị --</option>
                                @foreach($dsDonVi as $dv)
                                <option value="{{ $dv }}">{{ $dv }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">Đơn giá (₫)</label>
                            <input type="number" name="DonGia" class="form-control" placeholder="0" min="0" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Loại hàng</label>
                        <select name="FK_Id_LoaiHang" class="form-select" required>
                            <option value="">-- Chọn loại hàng --</option>
                            @foreach($dsLoaiHang as $lh)
                            <option value="{{ $lh->Id_LoaiHang }}">{{ $lh->Name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">💾 Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
