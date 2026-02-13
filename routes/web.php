<?php

use App\Http\Controllers\DonNhapHangController;

Route::get('/', function () {
    return redirect()->route('don-nhap.index');
});

Route::resource('don-nhap', DonNhapHangController::class);
