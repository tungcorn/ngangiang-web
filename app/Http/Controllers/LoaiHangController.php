<?php

namespace App\Http\Controllers;

use App\Models\LoaiHang;
use Illuminate\Http\Request;

/**
 * Controller CRUD cho Loại hàng.
 */
class LoaiHangController extends Controller
{
    public function index()
    {
        $dsLoaiHang = LoaiHang::withCount('matHangs')->orderBy('Name')->get();
        return view('loai-hang.index', compact('dsLoaiHang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Name' => 'required|string|max:255|unique:LoaiHang,Name',
        ], [
            'Name.required' => 'Vui lòng nhập tên loại hàng.',
            'Name.unique' => 'Tên loại hàng đã tồn tại.',
        ]);

        LoaiHang::create($request->only('Name'));
        return redirect()->route('loai-hang.index')->with('success', 'Thêm loại hàng thành công!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'Name' => 'required|string|max:255|unique:LoaiHang,Name,' . $id . ',Id_LoaiHang',
        ], [
            'Name.required' => 'Vui lòng nhập tên loại hàng.',
            'Name.unique' => 'Tên loại hàng đã tồn tại.',
        ]);

        $loaiHang = LoaiHang::findOrFail($id);
        $loaiHang->update($request->only('Name'));
        return redirect()->route('loai-hang.index')->with('success', 'Cập nhật loại hàng thành công!');
    }

    public function destroy($id)
    {
        $loaiHang = LoaiHang::findOrFail($id);

        // Kiểm tra có mặt hàng nào thuộc loại này không
        if ($loaiHang->matHangs()->count() > 0) {
            return redirect()->route('loai-hang.index')
                ->with('error', 'Không thể xóa — Loại hàng này đang có ' . $loaiHang->matHangs()->count() . ' mặt hàng.');
        }

        $loaiHang->delete();
        return redirect()->route('loai-hang.index')->with('success', 'Xóa loại hàng thành công!');
    }
}
