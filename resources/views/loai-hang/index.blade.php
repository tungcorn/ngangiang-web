@extends('layouts.app')

@section('title', 'Quản lý Loại hàng')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 mb-1 fw-bold">Quản lý Loại hàng</h2>
        <p class="text-muted mb-0">Phân loại mặt hàng theo nhóm</p>
    </div>
    <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalThem">
        <i class="bi bi-plus-lg me-1"></i> Thêm loại hàng
    </button>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold"><i class="bi bi-tags me-2 text-primary"></i> Loại hàng</h6>
        <span class="badge bg-light text-primary border rounded-pill fs-6">Tổng: {{ $dsLoaiHang->count() }}</span>
    </div>
    <div class="card-body p-0">
        @if($dsLoaiHang->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 60px" class="text-center">#</th>
                        <th>Tên loại hàng</th>
                        <th class="text-center" style="width: 130px">Số mặt hàng</th>
                        <th class="text-center" style="width: 150px">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dsLoaiHang as $index => $lh)
                    <tr>
                        <td class="text-center text-muted">{{ $index + 1 }}</td>
                        <td class="fw-medium">{{ $lh->Name }}</td>
                        <td class="text-center"><span class="badge bg-primary rounded-pill">{{ $lh->mat_hangs_count }}</span></td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalSua{{ $lh->Id_LoaiHang }}" title="Sửa">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <form action="{{ route('loai-hang.destroy', $lh->Id_LoaiHang) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Xác nhận xóa loại hàng: {{ $lh->Name }}?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" title="Xóa"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>

                    {{-- Modal Sửa --}}
                    <div class="modal fade" id="modalSua{{ $lh->Id_LoaiHang }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <form action="{{ route('loai-hang.update', $lh->Id_LoaiHang) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold"><i class="bi bi-pencil me-2"></i>Sửa loại hàng</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <label class="form-label fw-semibold">Tên loại hàng</label>
                                        <input type="text" name="Name" class="form-control" value="{{ $lh->Name }}" required>
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
            <i class="bi bi-tags fs-1 text-muted"></i>
            <h5 class="text-muted mt-3">Chưa có loại hàng nào</h5>
        </div>
        @endif
    </div>
</div>

{{-- Modal Thêm --}}
<div class="modal fade" id="modalThem" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('loai-hang.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle me-2"></i>Thêm loại hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label fw-semibold">Tên loại hàng</label>
                    <input type="text" name="Name" class="form-control" placeholder="VD: Điện tử, Văn phòng phẩm..." required>
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
