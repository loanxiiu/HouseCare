    // Thêm JavaScript để xử lý tương tác nếu cần
    document.addEventListener('DOMContentLoaded', function() {
    const filterOptions = document.querySelectorAll('.filter-option');

    filterOptions.forEach(option => {
    option.addEventListener('click', function() {
    filterOptions.forEach(opt => opt.classList.remove('active'));
    this.classList.add('active');
});
});

    const productCards = document.querySelectorAll('.product-card');

    productCards.forEach(card => {
    card.addEventListener('click', function() {
    // alert('Bạn đã chọn sản phẩm: ' + this.querySelector('.product-name').textContent);
});
});

    const pageButtons = document.querySelectorAll('.page-button');

    pageButtons.forEach(button => {
    button.addEventListener('click', function() {
    if(!this.classList.contains('active') && this.textContent !== '←' && this.textContent !== '→') {
    pageButtons.forEach(btn => btn.classList.remove('active'));
    this.classList.add('active');
}
});
});
});
