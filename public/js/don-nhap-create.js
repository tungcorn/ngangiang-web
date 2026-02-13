document.addEventListener('DOMContentLoaded', function () {
    let itemCount = 1;
    const container = document.getElementById('items-container');
    const addButton = document.getElementById('add-item');
    const loaiHangFilter = document.getElementById('loai-hang-filter');

    // Lọc mặt hàng theo loại hàng
    loaiHangFilter.addEventListener('change', function () {
        const selectedLoai = this.value;
        document.querySelectorAll('.mat-hang-select').forEach(select => {
            const currentValue = select.value;
            select.querySelectorAll('option').forEach(option => {
                if (!option.value) return;
                // Giữ nguyên option đã được chọn
                if (option.value === currentValue) {
                    option.style.display = '';
                    return;
                }
                if (!selectedLoai || option.dataset.loai === selectedLoai) {
                    option.style.display = '';
                } else {
                    option.style.display = 'none';
                }
            });
        });
    });

    // Thêm dòng mặt hàng mới
    addButton.addEventListener('click', () => {
        const firstRow = document.querySelector('.item-row');
        const newRow = firstRow.cloneNode(true);

        const select = newRow.querySelector('select');
        const input = newRow.querySelector('input');
        const removeBtn = newRow.querySelector('.remove-item');

        select.name = `items[${itemCount}][FK_Id_MatHang]`;
        select.value = "";
        input.name = `items[${itemCount}][Count]`;
        input.value = "";
        removeBtn.disabled = false;

        removeBtn.addEventListener('click', function () {
            newRow.remove();
        });

        container.appendChild(newRow);
        itemCount++;

        // Áp dụng bộ lọc cho dòng mới
        loaiHangFilter.dispatchEvent(new Event('change'));
    });
});
