@extends('layouts.app')

@section('title', 'Danh sách Nhà cung cấp')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 mb-1 fw-bold">Danh sách Nhà cung cấp</h2>
        <p class="text-muted mb-0">Quản lý toàn bộ nhà cung cấp trong hệ thống</p>
    </div>
    <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalThem">
        <i class="bi bi-plus-lg me-1"></i> Thêm NCC
    </button>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold"><i class="bi bi-building me-2 text-primary"></i> Nhà cung cấp</h6>
        <span class="badge bg-light text-primary border rounded-pill fs-6">Tổng: {{ $dsNCC->count() }} NCC</span>
    </div>
    <div class="card-body p-0">
        @if($dsNCC->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 60px" class="text-center">#</th>
                        <th>Tên nhà cung cấp</th>
                        <th>Địa chỉ</th>
                        <th style="width: 220px">Email</th>
                        <th class="text-center" style="width: 120px">Số đơn hàng</th>
                        <th class="text-center" style="width: 150px">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dsNCC as $index => $ncc)
                    <tr>
                        <td class="text-center text-muted">{{ $index + 1 }}</td>
                        <td class="fw-medium">{{ $ncc->Ten_NCC }}</td>
                        <td class="text-muted">{{ $ncc->DiaChi ?? '—' }}</td>
                        <td class="text-muted">{{ $ncc->Email ?? '—' }}</td>
                        <td class="text-center">
                            <span class="badge bg-primary rounded-pill">{{ $ncc->don_nhap_hangs_count }}</span>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalSua{{ $ncc->Id_NCC }}" title="Sửa">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <form action="{{ route('ncc.destroy', $ncc->Id_NCC) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Xác nhận xóa NCC: {{ $ncc->Ten_NCC }}?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" title="Xóa"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>

                    {{-- Modal Sửa --}}
                    <div class="modal fade" id="modalSua{{ $ncc->Id_NCC }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <form action="{{ route('ncc.update', $ncc->Id_NCC) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold"><i class="bi bi-pencil me-2"></i>Sửa nhà cung cấp</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Tên NCC</label>
                                            <input type="text" name="Ten_NCC" class="form-control" value="{{ $ncc->Ten_NCC }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Địa chỉ</label>
                                            <input type="text" name="DiaChi" class="form-control" value="{{ $ncc->DiaChi }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Email</label>
                                            <input type="email" name="Email" class="form-control" value="{{ $ncc->Email }}">
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
            <i class="bi bi-building fs-1 text-muted"></i>
            <h5 class="text-muted mt-3">Chưa có nhà cung cấp nào</h5>
        </div>
        @endif
    </div>
</div>

{{-- Modal Thêm --}}
<div class="modal fade" id="modalThem" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('ncc.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle me-2"></i>Thêm nhà cung cấp</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tên NCC</label>
                        <input type="text" name="Ten_NCC" class="form-control" placeholder="VD: Công ty ABC" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Địa chỉ</label>
                        <input type="text" name="DiaChi" class="form-control" placeholder="VD: 123 Nguyễn Huệ, Q1, HCM">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="Email" class="form-control" placeholder="VD: info@abc.com">
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
