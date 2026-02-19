/**
 * Filter đơn nhập hàng theo NCC (client-side).
 *
 * Logic: Mặc định không tick checkbox nào → hiển thị tất cả đơn hàng.
 * Khi tick 1 hoặc nhiều NCC → chỉ hiển thị đơn hàng của NCC đã tick.
 * Nút "Tất cả" bỏ tick toàn bộ → quay lại hiển thị tất cả.
 */
document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.ncc-checkbox');
    const cards = document.querySelectorAll('.don-nhap-card');
    const btnAll = document.getElementById('btnAllNCC');

    /**
     * Cập nhật hiển thị các card đơn hàng theo checkbox đã tick.
     *
     * Nếu không có checkbox nào được tick → hiện tất cả đơn hàng.
     * Nếu có checkbox được tick → chỉ hiện đơn hàng có data-ncc-id
     * khớp với giá trị checkbox.
     */
    function filterByNCC() {
        const checkedIds = Array.from(checkboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);

        // Không tick gì = hiện tất cả
        const showAll = checkedIds.length === 0;

        cards.forEach(card => {
            const nccId = card.getAttribute('data-ncc-id');
            if (showAll || checkedIds.includes(nccId)) {
                card.classList.remove('d-none');
            } else {
                card.classList.add('d-none');
            }
        });

        // Cập nhật style nút "Tất cả"
        if (btnAll) {
            btnAll.classList.toggle('btn-primary', showAll);
            btnAll.classList.toggle('btn-outline-primary', !showAll);
        }
    }

    // Lắng nghe sự kiện change trên từng checkbox NCC
    checkboxes.forEach(cb => cb.addEventListener('change', filterByNCC));

    // Nút "Tất cả": bỏ tick toàn bộ checkbox → hiện tất cả đơn hàng
    if (btnAll) {
        btnAll.addEventListener('click', function () {
            checkboxes.forEach(cb => cb.checked = false);
            filterByNCC();
        });
    }
});
