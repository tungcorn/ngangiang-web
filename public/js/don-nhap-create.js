/**
 * Script quản lý form tạo đơn nhập hàng mới.
 *
 * Xử lý thêm/xóa dòng mặt hàng động và đánh lại index
 * cho mảng items[] trước khi submit về server.
 */
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('items-container');
    const addButton = document.getElementById('add-item');

    // Cập nhật trạng thái của tất cả các nút xóa
    function updateDeleteButtons() {
        const rows = container.querySelectorAll('.item-row');
        rows.forEach(row => {
            const deleteBtn = row.querySelector('.remove-item');
            if (rows.length > 1) {
                deleteBtn.disabled = false;
            } else {
                deleteBtn.disabled = true;
            }
        });
    }

    // Đánh lại số thứ tự (index) cho các input để gửi về server đúng mảng
    function updateIndices() {
        const rows = container.querySelectorAll('.item-row');
        rows.forEach((row, index) => {
            const select = row.querySelector('.mat-hang-select');
            const input = row.querySelector('input[type="number"]');
            if (select) select.name = `items[${index}][FK_Id_MatHang]`;
            if (input) input.name = `items[${index}][Count]`;
        });
        updateDeleteButtons();
    }

    // Thêm dòng mặt hàng mới
    addButton.addEventListener('click', function () {
        const rows = container.querySelectorAll('.item-row');
        const firstRow = rows[0];
        const newRow = firstRow.cloneNode(true);

        // Reset các giá trị của dòng mới được clone
        const select = newRow.querySelector('.mat-hang-select');
        const input = newRow.querySelector('input[type="number"]');

        if (select) {
            select.value = "";
            // Xóa validation cũ nếu có
            select.classList.remove('is-invalid');
            const error = select.parentElement.querySelector('.invalid-feedback');
            if (error) error.remove();
        }

        if (input) {
            input.value = "";
            input.classList.remove('is-invalid');
            const error = input.parentElement.querySelector('.invalid-feedback');
            if (error) error.remove();
        }

        container.appendChild(newRow);

        // Cập nhật lại index và trạng thái nút xóa
        updateIndices();
    });

    // Xóa dòng mặt hàng (sử dụng Event Delegation trên container)
    container.addEventListener('click', function (e) {
        const deleteBtn = e.target.closest('.remove-item');
        if (deleteBtn) {
            const rows = container.querySelectorAll('.item-row');
            if (rows.length > 1) {
                const row = deleteBtn.closest('.item-row');
                row.remove();
                updateIndices();
            }
        }
    });

    // Chạy khởi tạo lần đầu khi load trang
    updateIndices();
});
