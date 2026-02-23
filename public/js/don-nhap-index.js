/**
 * Xử lý tương tác trang danh sách đơn nhập hàng.
 *
 * 1. Click vào dòng NCC → toggle checkbox và submit form lọc.
 * 2. Click nút "Chi tiết" (👁) → mở Modal hiển thị chi tiết đơn hàng.
 *    Dữ liệu chi tiết đã render sẵn trong div ẩn (detailContent_*),
 *    JS lấy innerHTML inject vào modal body rồi show modal.
 */
document.addEventListener('DOMContentLoaded', function () {

    // ====== Click dòng NCC → toggle checkbox ======
    // Submit form chung filterForm (bao gồm cả ncc_ids[] và tu_ngay/den_ngay)
    document.querySelectorAll('.ncc-row').forEach(function (row) {
        row.addEventListener('click', function (e) {
            // Nếu click trực tiếp vào checkbox thì để onchange xử lý
            if (e.target.classList.contains('ncc-checkbox')) return;

            var checkbox = row.querySelector('.ncc-checkbox');
            if (checkbox) {
                checkbox.checked = !checkbox.checked;
                document.getElementById('filterForm').submit();
            }
        });
    });

    // ====== Checkbox NCC: khi thay đổi, submit form ======
    document.querySelectorAll('.ncc-checkbox').forEach(function (cb) {
        cb.addEventListener('change', function () {
            document.getElementById('filterForm').submit();
        });
    });

    // ====== Click nút "Chi tiết" hoặc click vào dòng đơn → mở Modal ======
    var modalEl = document.getElementById('modalChiTiet');
    var modalBody = document.getElementById('modalChiTietBody');
    var modal = modalEl ? new bootstrap.Modal(modalEl) : null;

    /**
     * Hàm mở modal chi tiết theo ID đơn hàng.
     * Lấy innerHTML từ div ẩn (detailContent_*) rồi inject vào modal body.
     */
    function openDetail(donId) {
        var detailContent = document.getElementById('detailContent_' + donId);
        if (detailContent && modal) {
            modalBody.innerHTML = detailContent.innerHTML;
            modal.show();
        }
    }

    // Click nút 👁 Chi tiết → mở modal
    document.querySelectorAll('.btn-chi-tiet').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            openDetail(btn.getAttribute('data-don-id'));
        });
    });

    // Click vào dòng đơn hàng → mở modal (trừ khi click nút Sửa/Xóa)
    document.querySelectorAll('#tblDonNhap tbody tr').forEach(function (row) {
        row.style.cursor = 'pointer';
        row.addEventListener('click', function (e) {
            if (e.target.closest('.btn-warning') || e.target.closest('.btn-danger')) return;

            var btn = row.querySelector('.btn-chi-tiet');
            if (btn) {
                openDetail(btn.getAttribute('data-don-id'));
            }
        });
    });
});
