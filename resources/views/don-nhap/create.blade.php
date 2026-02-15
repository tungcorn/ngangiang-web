@extends('layouts.app')

@section('title', 'Tạo Đơn nhập hàng mới')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="d-flex align-items-center mb-4">
            <div>
                <h2 class="h4 mb-0 fw-bold">Tạo Đơn nhập hàng mới</h2>
                <p class="text-muted mb-0 small">Điền thông tin bên dưới để tạo phiếu nhập kho</p>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body p-4">
                <form action="{{ route('don-nhap.store') }}" method="POST" id="donNhapForm">
                    @csrf
                    
                    <div class="row g-4 mb-4">
                    <div class="col-md-12">
                        <label class="form-label fw-bold text-uppercase small text-muted mb-3">
                            <i class="bi bi-building me-1"></i> Thông tin Nhà Cung Cấp
                        </label>
                        <select name="FK_Id_NCC" class="form-select form-select-lg @error('FK_Id_NCC') is-invalid @enderror">
                            <option value="">-- Chọn Nhà Cung Cấp --</option>
                            @foreach($dsNCC as $ncc)
                            <option value="{{ $ncc->Id_NCC }}" {{ old('FK_Id_NCC') == $ncc->Id_NCC ? 'selected' : '' }}>{{ $ncc->Ten_NCC }}</option>
                            @endforeach
                        </select>
                        @error('FK_Id_NCC') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="bg-light rounded-3 p-3 mb-3">
                            {{-- Container chứa các dòng mặt hàng, hỗ trợ thêm/xóa động bằng JS --}}
                            <div id="items-container">
                                {{-- Nếu validation fail, hiển thị lại dữ liệu cũ từ old() --}}
                                @if(old('items'))
                                    @foreach(old('items') as $index => $item)
                                    <div class="row g-3 mb-3 item-row">
                                        <div class="col-md-7">
                                            <label class="form-label small text-muted">Mặt hàng</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                                                {{-- Nhóm mặt hàng theo loại bằng optgroup để dễ tìm kiếm --}}
                                                <select name="items[{{ $index }}][FK_Id_MatHang]" class="form-select mat-hang-select @error('items.'.$index.'.FK_Id_MatHang') is-invalid @enderror">
                                                    <option value="">-- Chọn mặt hàng --</option>
                                                    @foreach($dsLoaiHang as $loai)
                                                        <optgroup label="{{ $loai->Name }}">
                                                            @foreach($loai->matHangs as $mh)
                                                            <option value="{{ $mh->Id_MatHang }}" {{ $item['FK_Id_MatHang'] == $mh->Id_MatHang ? 'selected' : '' }}>
                                                                {{ $mh->Ten_MatHang }} — ({{ number_format($mh->DonGia) }} ₫)
                                                            </option>
                                                            @endforeach
                                                        </optgroup>
                                                    @endforeach
                                                </select>
                                                @error('items.'.$index.'.FK_Id_MatHang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label small text-muted">Số lượng</label>
                                            <input type="number" name="items[{{ $index }}][Count]" class="form-control @error('items.'.$index.'.Count') is-invalid @enderror" placeholder="0" min="1" value="{{ $item['Count'] }}">
                                            @error('items.'.$index.'.Count') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label d-block text-white">&nbsp;</label>
                                            <button type="button" class="btn btn-outline-danger w-100 remove-item" {{ $index == 0 ? 'disabled' : '' }}>
                                                <i class="bi bi-trash"></i> Xóa
                                            </button>
                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                    {{-- Mặc định hiển thị 1 dòng nếu chưa có dữ liệu cũ --}}
                                    <div class="row g-3 mb-3 item-row">
                                        <div class="col-md-7">
                                            <label class="form-label small text-muted">Mặt hàng</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                                                <select name="items[0][FK_Id_MatHang]" class="form-select mat-hang-select">
                                                    <option value="">-- Chọn mặt hàng --</option>
                                                    @foreach($dsLoaiHang as $loai)
                                                        <optgroup label="{{ $loai->Name }}">
                                                            @foreach($loai->matHangs as $mh)
                                                            <option value="{{ $mh->Id_MatHang }}">
                                                                {{ $mh->Ten_MatHang }} — ({{ number_format($mh->DonGia) }} ₫)
                                                            </option>
                                                            @endforeach
                                                        </optgroup>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label small text-muted">Số lượng</label>
                                            <input type="number" name="items[0][Count]" class="form-control" placeholder="0" min="1">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label d-block text-white">&nbsp;</label>
                                            <button type="button" class="btn btn-outline-danger w-100 remove-item" disabled>
                                                <i class="bi bi-trash"></i> Xóa
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                            @if($errors->has('items'))
                                <div class="alert alert-danger mt-2 mb-0 py-2 small">
                                    {{ $errors->first('items') }}
                                </div>
                            @endif

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

