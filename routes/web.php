<?php

use App\Http\Controllers\DonNhapHangController;
use App\Http\Controllers\NCCController;
use App\Http\Controllers\LoaiHangController;
use App\Http\Controllers\MatHangController;

// Trang chủ redirect về danh sách đơn nhập hàng
Route::get('/', function () {
    return redirect()->route('don-nhap.index');
});

// NCC routes (index, store, update, destroy)
Route::resource('ncc', NCCController::class)->only(['index', 'store', 'update', 'destroy']);

// Loại hàng routes
Route::resource('loai-hang', LoaiHangController::class)->only(['index', 'store', 'update', 'destroy']);

// Mặt hàng routes
Route::resource('mat-hang', MatHangController::class)->only(['index', 'store', 'update', 'destroy']);

// Đơn nhập hàng (resource đầy đủ)
Route::resource('don-nhap', DonNhapHangController::class);
