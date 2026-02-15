<?php

use App\Http\Controllers\DonNhapHangController;

// Trang chủ redirect về danh sách đơn nhập hàng
Route::get('/', function () {
    return redirect()->route('don-nhap.index');
});

// Resource route: tự động tạo các route CRUD cho đơn nhập hàng
// (index, create, store, show, edit, update, destroy)
Route::resource('don-nhap', DonNhapHangController::class);
