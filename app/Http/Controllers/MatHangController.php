<?php

namespace App\Http\Controllers;

use App\Models\MatHang;
use App\Models\LoaiHang;
use Illuminate\Http\Request;

/**
 * Controller CRUD cho Mặt hàng.
 */
class MatHangController extends Controller
{
    public function index(Request $request)
    {
        $query = MatHang::with('loaiHang')->orderBy('Ten_MatHang');

        // Lọc theo loại hàng
        if ($request->filled('loai_hang')) {
            $query->where('FK_Id_LoaiHang', $request->loai_hang);
        }

        // Lọc theo đơn vị tính
        if ($request->filled('don_vi')) {
            $query->where('DonViTinh', $request->don_vi);
        }

        $dsMatHang = $query->paginate(10)->appends($request->query());
        $dsLoaiHang = LoaiHang::orderBy('Name')->get();
        $dsDonVi = MatHang::DON_VI_TINH;

        return view('mat-hang.index', compact('dsMatHang', 'dsLoaiHang', 'dsDonVi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Ten_MatHang' => 'required|string|max:255',
            'DonViTinh' => 'required|string|max:50',
            'DonGia' => 'required|numeric|min:0',
            'FK_Id_LoaiHang' => 'required|exists:LoaiHang,Id_LoaiHang',
        ], [
            'Ten_MatHang.required' => 'Vui lòng nhập tên mặt hàng.',
            'DonViTinh.required' => 'Vui lòng nhập đơn vị tính.',
            'DonGia.required' => 'Vui lòng nhập đơn giá.',
            'DonGia.min' => 'Đơn giá phải >= 0.',
            'FK_Id_LoaiHang.required' => 'Vui lòng chọn loại hàng.',
            'FK_Id_LoaiHang.exists' => 'Loại hàng không hợp lệ.',
        ]);

        MatHang::create($request->only(['Ten_MatHang', 'DonViTinh', 'DonGia', 'FK_Id_LoaiHang']));
        return redirect()->route('mat-hang.index')->with('success', 'Thêm mặt hàng thành công!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'Ten_MatHang' => 'required|string|max:255',
            'DonViTinh' => 'required|string|max:50',
            'DonGia' => 'required|numeric|min:0',
            'FK_Id_LoaiHang' => 'required|exists:LoaiHang,Id_LoaiHang',
        ], [
            'Ten_MatHang.required' => 'Vui lòng nhập tên mặt hàng.',
            'DonViTinh.required' => 'Vui lòng nhập đơn vị tính.',
            'DonGia.required' => 'Vui lòng nhập đơn giá.',
            'DonGia.min' => 'Đơn giá phải >= 0.',
            'FK_Id_LoaiHang.required' => 'Vui lòng chọn loại hàng.',
        ]);

        $matHang = MatHang::findOrFail($id);
        $matHang->update($request->only(['Ten_MatHang', 'DonViTinh', 'DonGia', 'FK_Id_LoaiHang']));
        return redirect()->route('mat-hang.index')->with('success', 'Cập nhật mặt hàng thành công!');
    }

    public function destroy($id)
    {
        $matHang = MatHang::findOrFail($id);

        // Kiểm tra mặt hàng có trong đơn nhập hàng nào không
        if ($matHang->chiTietDonNhaps()->count() > 0) {
            return redirect()->route('mat-hang.index')
                ->with('error', 'Không thể xóa — Mặt hàng này đang có trong ' . $matHang->chiTietDonNhaps()->count() . ' đơn nhập.');
        }

        $matHang->delete();
        return redirect()->route('mat-hang.index')->with('success', 'Xóa mặt hàng thành công!');
    }
}
