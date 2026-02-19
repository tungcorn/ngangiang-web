/**
 * Xử lý tương tác trang danh sách đơn nhập hàng.
 *
 * 1. Click vào dòng NCC → toggle checkbox và submit form lọc.
 * 2. Click vào dòng đơn hàng hoặc nút "Chi tiết" → mở Modal hiển thị chi tiết.
 *    Dữ liệu chi tiết đã được render sẵn trong các div ẩn (detailContent_*),
 *    JS chỉ việc lấy innerHTML inject vào modal body.
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

    // ====== Click dòng đơn hàng → mở Modal chi tiết ======
    // Sử dụng Bootstrap Modal API (có sẵn qua CDN trong layout)
    var modalEl = document.getElementById('modalChiTiet');
    var modalBody = document.getElementById('modalChiTietBody');
    var modal = modalEl ? new bootstrap.Modal(modalEl) : null;

    document.querySelectorAll('.don-nhap-row').forEach(function (row) {
        row.addEventListener('click', function (e) {
            // Không mở modal nếu click vào nút Sửa hoặc Xóa
            if (e.target.closest('.btn-sua') || e.target.closest('.btn-xoa')) return;

            var donId = row.getAttribute('data-don-id');
            var detailContent = document.getElementById('detailContent_' + donId);

            if (detailContent && modal) {
                // Inject nội dung pre-rendered vào modal body
                modalBody.innerHTML = detailContent.innerHTML;

                // Highlight dòng đang xem
                document.querySelectorAll('.don-nhap-row').forEach(function (r) {
                    r.classList.remove('table-active');
                });
                row.classList.add('table-active');

                // Hiện modal
                modal.show();
            }
        });
    });

    // Bỏ highlight khi đóng modal
    if (modalEl) {
        modalEl.addEventListener('hidden.bs.modal', function () {
            document.querySelectorAll('.don-nhap-row').forEach(function (r) {
                r.classList.remove('table-active');
            });
        });
    }
});
