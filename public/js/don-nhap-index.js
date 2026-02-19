/**
 * Xử lý tương tác trang danh sách đơn nhập hàng.
 *
 * 1. Click vào dòng NCC → toggle checkbox và submit form lọc.
 * 2. Click vào dòng đơn hàng → expand/collapse chi tiết inline.
 * 3. Click nút "Chi tiết" → expand/collapse chi tiết inline.
 */
document.addEventListener('DOMContentLoaded', function () {

    // ====== Click dòng NCC → toggle checkbox ======
    document.querySelectorAll('.ncc-row').forEach(function (row) {
        row.addEventListener('click', function (e) {
            // Nếu click trực tiếp vào checkbox thì không cần xử lý thêm
            if (e.target.classList.contains('ncc-checkbox')) return;

            var checkbox = row.querySelector('.ncc-checkbox');
            if (checkbox) {
                checkbox.checked = !checkbox.checked;
                checkbox.form.submit();
            }
        });
    });

    // ====== Click dòng đơn hàng → expand/collapse chi tiết ======
    document.querySelectorAll('.don-nhap-row').forEach(function (row) {
        row.addEventListener('click', function (e) {
            // Không toggle nếu click vào nút Sửa hoặc Xóa
            if (e.target.closest('.btn-sua') || e.target.closest('.btn-xoa')) return;

            var donId = row.getAttribute('data-don-id');
            var detailRow = document.getElementById('chiTiet_' + donId);

            if (detailRow) {
                // Toggle hiển thị dòng chi tiết
                detailRow.classList.toggle('d-none');

                // Highlight dòng đang mở
                row.classList.toggle('table-active');
            }
        });
    });
});
