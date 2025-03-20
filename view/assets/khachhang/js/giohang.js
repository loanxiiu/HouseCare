document.addEventListener('DOMContentLoaded', () => {
    const quantityButtons = document.querySelectorAll('.quantity-btn');
    const removeButtons = document.querySelectorAll('.remove-btn');

    // Handle quantity changes
    quantityButtons.forEach(button => {
        button.addEventListener('click', () => {
            const maChiTiet = button.getAttribute('data-ma-chi-tiet');
            const quantityValue = button.parentElement.querySelector('.quantity-value');
            let quantity = parseInt(quantityValue.textContent);
            const isPlus = button.classList.contains('plus');

            quantity = isPlus ? quantity + 1 : Math.max(1, quantity - 1);
            quantityValue.textContent = quantity;

            // Update server-side
            fetch(`update_quantity.php?ma_chi_tiet=${maChiTiet}&so_luong=${quantity}`, {
                method: 'POST'
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload(); // Reload to update totals
                    } else {
                        alert('Cập nhật số lượng thất bại');
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    });

    // Handle remove item
    removeButtons.forEach(button => {
        button.addEventListener('click', () => {
            const maChiTiet = button.getAttribute('data-ma-chi-tiet');
            if (confirm('Bạn có chắc muốn xóa sản phẩm này?')) {
                fetch(`remove_item.php?ma_chi_tiet=${maChiTiet}`, {
                    method: 'POST'
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload(); // Reload to update cart
                        } else {
                            alert('Xóa sản phẩm thất bại');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        });
    });
});