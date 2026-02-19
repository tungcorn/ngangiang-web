/**
 * Xử lý tương tác trang danh sách đơn nhập hàng.
 *
 * Click vào dòng NCC → toggle checkbox và submit form lọc server-side.
 * Giao diện dạng card nên không cần xử lý expand/collapse hay modal.
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
});
