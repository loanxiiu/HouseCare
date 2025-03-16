// JavaScript for quantity control
document.querySelectorAll('.quantity-btn').forEach(button => {
    button.addEventListener('click', () => {
        const input = button.parentElement.querySelector('.quantity-input');
        let value = parseInt(input.value);
        const maxQuantity = parseInt(input.getAttribute('max')); // Get max quantity from input's max attribute

        if (button.textContent === '-') {
            value = Math.max(1, value - 1);
        } else {
            value = Math.min(maxQuantity, value + 1);
        }
        input.value = value;
    });
});

// JavaScript for tab switching
document.querySelectorAll('.tab-button').forEach(button => {
    button.addEventListener('click', () => {
        document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
        document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('active'));
        button.classList.add('active');
        document.getElementById(button.dataset.tab).classList.add('active');
    });
});

// JavaScript for thumbnail switching
document.querySelectorAll('.thumbnail').forEach(thumb => {
    thumb.addEventListener('click', () => {
        document.querySelectorAll('.thumbnail').forEach(t => t.classList.remove('active'));
        thumb.classList.add('active');
        document.querySelector('.main-image img').src = thumb.querySelector('img').src;
    });
});