<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DonNhapHang;
use App\Models\ChiTietDonNhap;
use App\Models\NCC;
use App\Models\MatHang;
use App\Models\LoaiHang;
use Illuminate\Support\Facades\DB;

class DonNhapHangController extends Controller
{
    public function index()
    {
        $donNhaps = DonNhapHang::with(['ncc', 'chiTiet.matHang'])->orderBy('NgayNhap', 'desc')->get();
        return view('don-nhap.index', compact('donNhaps'));
    }

    public function create()
    {
        $nccs = NCC::all();
        $loaiHangs = LoaiHang::all();
        $matHangs = MatHang::with('loaiHang')->get();
        return view('don-nhap.create', compact('nccs', 'loaiHangs', 'matHangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'FK_Id_NCC' => 'required|exists:NCC,Id_NCC',
            'items' => 'required|array|min:1',
            'items.*.FK_Id_MatHang' => 'required|exists:MatHang,Id_MatHang',
            'items.*.Count' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $donNhap = DonNhapHang::create([
                'FK_Id_NCC' => $request->FK_Id_NCC,
                'NgayNhap' => now(),
            ]);

            // Gộp các mặt hàng trùng nhau (cộng dồn số lượng)
            $mergedItems = [];
            foreach ($request->items as $item) {
                $matHangId = $item['FK_Id_MatHang'];
                if (isset($mergedItems[$matHangId])) {
                    $mergedItems[$matHangId] += (int) $item['Count'];
                } else {
                    $mergedItems[$matHangId] = (int) $item['Count'];
                }
            }

            foreach ($mergedItems as $matHangId => $count) {
                ChiTietDonNhap::create([
                    'FK_Id_DonNhapHang' => $donNhap->Id_DonNhapHang,
                    'FK_Id_MatHang' => $matHangId,
                    'Count' => $count,
                ]);
            }

            DB::commit();
            return redirect()->route('don-nhap.index')->with('success', 'Tạo đơn nhập hàng thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function show(DonNhapHang $donNhapHang) {}
    public function edit(DonNhapHang $donNhapHang) {}
    public function update(Request $request, DonNhapHang $donNhapHang) {}
    public function destroy(DonNhapHang $donNhapHang) {}
}
