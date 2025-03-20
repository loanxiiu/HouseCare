// Giữ nguyên JavaScript của bạn, chỉ sửa xử lý form
const infoModal = document.getElementById('infoModal');
const addressModal = document.getElementById('addressModal');
const editInfoBtn = document.getElementById('edit-info-btn');
const editAddressBtn = document.getElementById('edit-address-btn');
const closeButtons = document.querySelectorAll('.close-modal');
const cancelButtons = document.querySelectorAll('.modal-cancel');

editInfoBtn.addEventListener('click', () => infoModal.style.display = 'block');
editAddressBtn.addEventListener('click', () => addressModal.style.display = 'block');

closeButtons.forEach(button => {
    button.addEventListener('click', () => {
        infoModal.style.display = 'none';
        addressModal.style.display = 'none';
    });
});

cancelButtons.forEach(button => {
    button.addEventListener('click', () => {
        infoModal.style.display = 'none';
        addressModal.style.display = 'none';
    });
});

window.addEventListener('click', (event) => {
    if (event.target === infoModal) infoModal.style.display = 'none';
    if (event.target === addressModal) addressModal.style.display = 'none';
});

document.getElementById('info-form').addEventListener('submit', (e) => {
    e.preventDefault();
    document.getElementById('customer-name').textContent = document.getElementById('name').value;
    document.getElementById('customer-email').textContent = document.getElementById('email').value;
    document.getElementById('customer-phone').textContent = document.getElementById('phone').value;
    infoModal.style.display = 'none';
});

document.getElementById('address-form').addEventListener('submit', (e) => {
    e.preventDefault();
    document.getElementById('shipping-address').textContent = document.getElementById('address').value;
    document.getElementById('shipping-city').textContent = document.getElementById('city').value;
    addressModal.style.display = 'none';
});

const paymentSelect = document.getElementById('paymentMethod');
const paymentDetails = document.getElementById('paymentDetails');

paymentSelect.addEventListener('change', () => {
    const selectedPayment = paymentSelect.value;
    if (selectedPayment) {
        paymentDetails.style.display = 'block';
        let paymentForm = '';
        if (selectedPayment === 'credit_card') {
            paymentForm = `
                    <div class="form-group">
                        <label for="card_number">Số thẻ</label>
                        <input type="text" id="card_number" name="card_number" placeholder="1234 5678 9012 3456" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="expiry">Ngày hết hạn</label>
                            <input type="text" id="expiry" name="expiry" placeholder="MM/YY" required>
                        </div>
                        <div class="form-group">
                            <label for="cvv">CVV</label>
                            <input type="text" id="cvv" name="cvv" placeholder="123" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="card_name">Tên chủ thẻ</label>
                        <input type="text" id="card_name" name="card_name" placeholder="NGUYEN VAN A" required>
                    </div>
                `;
        } else if (selectedPayment === 'bank_transfer') {
            paymentForm = `
                    <div class="form-group">
                        <p>Vui lòng chuyển khoản đến tài khoản sau:</p>
                        <p><strong>Ngân hàng:</strong> Vietcombank</p>
                        <p><strong>Số tài khoản:</strong> 1234567890</p>
                        <p><strong>Chủ tài khoản:</strong> CÔNG TY ABC</p>
                        <p><strong>Nội dung:</strong> Thanh toán đơn hàng #123456</p>
                    </div>
                `;
        } else if (selectedPayment === 'e_wallet') {
            paymentForm = `
                    <div class="form-group">
                        <label for="wallet_type">Chọn ví điện tử</label>
                        <select id="wallet_type" name="wallet_type" required>
                            <option value="" selected disabled>Chọn ví điện tử</option>
                            <option value="momo">MoMo</option>
                            <option value="zalopay">ZaloPay</option>
                            <option value="vnpay">VNPay</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="wallet_phone">Số điện thoại đăng ký</label>
                        <input type="tel" id="wallet_phone" name="wallet_phone" placeholder="0912345678" required>
                    </div>
                `;
        }
        paymentDetails.innerHTML = paymentForm;
    } else {
        paymentDetails.style.display = 'none';
    }
});

document.querySelector('.close-btn').addEventListener('click', () => {
    if (confirm('Bạn có chắc muốn hủy quá trình thanh toán?')) {
        window.location.href = '../khachhang/TrangChu.php';
    }
});
