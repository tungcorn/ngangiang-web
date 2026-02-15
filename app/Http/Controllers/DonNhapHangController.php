<?php

namespace App\Http\Controllers;

use App\Models\LoaiHang;
use Illuminate\Http\Request;
use App\Models\DonNhapHang;
use App\Models\ChiTietDonNhap;
use App\Models\NCC;
use App\Models\MatHang;
use Illuminate\Support\Facades\DB;

/**
 * Controller quản lý Đơn nhập hàng.
 *
 * Xử lý các chức năng: hiển thị danh sách, tạo mới đơn nhập hàng.
 * Mỗi đơn nhập hàng gồm 1 NCC và nhiều chi tiết mặt hàng.
 */
class DonNhapHangController extends Controller
{
    /**
     * Hiển thị danh sách đơn nhập hàng.
     *
     * Eager load quan hệ `ncc` và `chiTiet.matHang` để tránh N+1 query.
     * Sắp xếp đơn mới nhất lên đầu, phân trang 5 đơn/trang.
     */
    public function index()
    {
        $dsDonNhap = DonNhapHang::with(['ncc', 'chiTiet.matHang'])->orderBy('Id_DonNhapHang', 'desc')->paginate(5);
        return view('don-nhap.index', compact('dsDonNhap'));
    }

    /**
     * Hiển thị form tạo đơn nhập hàng mới.
     *
     * Truyền danh sách NCC cho dropdown chọn nhà cung cấp,
     * và danh sách Loại hàng (kèm mặt hàng) để nhóm <optgroup> theo loại.
     */
    public function create()
    {
        $dsNCC = NCC::all();
        $dsLoaiHang = LoaiHang::with('matHangs')->get();
        return view('don-nhap.create', compact('dsNCC', 'dsLoaiHang'));
    }

    /**
     * Lưu đơn nhập hàng mới vào CSDL.
     *
     * Quy trình xử lý:
     * 1. Validate dữ liệu đầu vào (NCC tồn tại, ít nhất 1 mặt hàng, số lượng > 0)
     * 2. Sử dụng Transaction để đảm bảo tính nhất quán dữ liệu
     * 3. Gộp các mặt hàng trùng (cộng dồn số lượng) trước khi lưu chi tiết
     *
     * @param Request $request Dữ liệu từ form tạo đơn
     * @return \Illuminate\Http\RedirectResponse Redirect về danh sách kèm thông báo
     */
    public function store(Request $request)
    {
        // Validate dữ liệu: đảm bảo NCC hợp lệ, có ít nhất 1 mặt hàng, số lượng >= 1
        $request->validate([
            'FK_Id_NCC' => 'required|exists:NCC,Id_NCC',
            'items' => 'required|array|min:1',
            'items.*.FK_Id_MatHang' => 'required|exists:MatHang,Id_MatHang',
            'items.*.Count' => 'required|integer|min:1',
        ], [
            'FK_Id_NCC.required' => 'Vui lòng chọn Nhà cung cấp.',
            'FK_Id_NCC.exists' => 'Nhà cung cấp không hợp lệ.',
            'items.required' => 'Đơn hàng phải có ít nhất một mặt hàng.',
            'items.min' => 'Đơn hàng phải có ít nhất một mặt hàng.',
            'items.*.FK_Id_MatHang.required' => 'Vui lòng chọn mặt hàng.',
            'items.*.FK_Id_MatHang.exists' => 'Mặt hàng không tồn tại.',
            'items.*.Count.required' => 'Vui lòng nhập số lượng.',
            'items.*.Count.min' => 'Số lượng phải lớn hơn 0.',
        ]);

        try {
            // Sử dụng Transaction: nếu insert chi tiết bị lỗi thì rollback toàn bộ đơn,
            // tránh tình trạng đơn nhập tồn tại mà không có chi tiết mặt hàng.
            DB::beginTransaction();

            $donNhap = DonNhapHang::create([
                'FK_Id_NCC' => $request->FK_Id_NCC,
            ]);

            // Gộp các mặt hàng trùng nhau (cộng dồn số lượng).
            // Vì bảng ChiTietDonNhap dùng composite PK (FK_Id_DonNhapHang, FK_Id_MatHang),
            // nên mỗi mặt hàng chỉ được xuất hiện 1 lần trong 1 đơn.
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

    // Các method CRUD còn lại chưa triển khai vì ngoài phạm vi yêu cầu bài test.
    public function show(DonNhapHang $donNhapHang) {}
    public function edit(DonNhapHang $donNhapHang) {}
    public function update(Request $request, DonNhapHang $donNhapHang) {}
    public function destroy(DonNhapHang $donNhapHang) {}
}
