<?php

namespace App\Http\Controllers;

use App\Models\NCC;
use Illuminate\Http\Request;

/**
 * Controller quản lý Nhà cung cấp (NCC).
 * CRUD: Hiển thị, thêm, sửa, xóa NCC.
 */
class NCCController extends Controller
{
    public function index()
    {
        $dsNCC = NCC::withCount('donNhapHangs')->orderBy('Ten_NCC')->get();
        return view('ncc.index', compact('dsNCC'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Ten_NCC' => 'required|string|max:255',
            'DiaChi' => 'nullable|string|max:255',
            'Email' => 'nullable|email|max:255',
        ], [
            'Ten_NCC.required' => 'Vui lòng nhập tên nhà cung cấp.',
            'Email.email' => 'Email không hợp lệ.',
        ]);

        NCC::create($request->only(['Ten_NCC', 'DiaChi', 'Email']));
        return redirect()->route('ncc.index')->with('success', 'Thêm nhà cung cấp thành công!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'Ten_NCC' => 'required|string|max:255',
            'DiaChi' => 'nullable|string|max:255',
            'Email' => 'nullable|email|max:255',
        ], [
            'Ten_NCC.required' => 'Vui lòng nhập tên nhà cung cấp.',
            'Email.email' => 'Email không hợp lệ.',
        ]);

        $ncc = NCC::findOrFail($id);
        $ncc->update($request->only(['Ten_NCC', 'DiaChi', 'Email']));
        return redirect()->route('ncc.index')->with('success', 'Cập nhật nhà cung cấp thành công!');
    }

    public function destroy($id)
    {
        $ncc = NCC::findOrFail($id);

        if ($ncc->donNhapHangs()->count() > 0) {
            return redirect()->route('ncc.index')
                ->with('error', 'Không thể xóa — NCC này đang có ' . $ncc->donNhapHangs()->count() . ' đơn nhập hàng.');
        }

        $ncc->delete();
        return redirect()->route('ncc.index')->with('success', 'Xóa nhà cung cấp thành công!');
    }
}
