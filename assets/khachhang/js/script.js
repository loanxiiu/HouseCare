const bannerContainer = document.getElementById('bannerContainer');
const bannerNav = document.getElementById('bannerNav');
const prevArrow = document.getElementById('prevArrow');
const nextArrow = document.getElementById('nextArrow');
const bannerSlides = document.querySelectorAll('.banner-slide');
let currentSlide = 0;
let autoSlideInterval;

bannerSlides[currentSlide].classList.add('active');

bannerSlides.forEach((_, index) => {
    const dot = document.createElement('div');
    dot.classList.add('banner-dot');
    if (index === 0) dot.classList.add('active');
    dot.addEventListener('click', () => {
        clearInterval(autoSlideInterval);
        currentSlide = index;
        updateBannerSlide();
        startAutoSlide();
    });
    bannerNav.appendChild(dot);
});

function updateBannerSlide() {
    bannerSlides.forEach((slide, index) => {
        slide.classList.remove('active', 'prev', 'next');
        if (index === currentSlide) {
            slide.classList.add('active');
        } else if (index === (currentSlide - 1 + bannerSlides.length) % bannerSlides.length) {
            slide.classList.add('prev');
        } else if (index === (currentSlide + 1) % bannerSlides.length) {
            slide.classList.add('next');
        }
    });

    document.querySelectorAll('.banner-dot').forEach((dot, index) => {
        dot.classList.toggle('active', index === currentSlide);
    });
}

prevArrow.addEventListener('click', () => {
    clearInterval(autoSlideInterval);
    currentSlide = (currentSlide - 1 + bannerSlides.length) % bannerSlides.length;
    updateBannerSlide();
    startAutoSlide();
});

nextArrow.addEventListener('click', () => {
    clearInterval(autoSlideInterval);
    currentSlide = (currentSlide + 1) % bannerSlides.length;
    updateBannerSlide();
    startAutoSlide();
});

function startAutoSlide() {
    autoSlideInterval = setInterval(() => {
        currentSlide = (currentSlide + 1) % bannerSlides.length;
        updateBannerSlide();
    }, 5000);
}

startAutoSlide();

function updateTimer() {
    const now = new Date();
    const endOfDay = new Date(now);
    endOfDay.setHours(23, 59, 59, 999);

    const timeLeft = endOfDay - now;
    const hours = Math.floor(timeLeft / (1000 * 60 * 60));
    const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

    document.getElementById('hours').textContent = String(hours).padStart(2, '0');
    document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
    document.getElementById('seconds').textContent = String(seconds).padStart(2, '0');
}

setInterval(updateTimer, 1000);
updateTimer();

const observerOptions = {
    threshold: 0.1
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('fade-in');
            observer.unobserve(entry.target);
        }
    });
}, observerOptions);

document.querySelectorAll('.product-card').forEach(card => {
    observer.observe(card);
});

const flashSaleContainer = document.getElementById('flashSaleContainer');
let isDown = false;
let startX;
let scrollLeft;

flashSaleContainer.addEventListener('mousedown', (e) => {
    isDown = true;
    startX = e.pageX - flashSaleContainer.offsetLeft;
    scrollLeft = flashSaleContainer.scrollLeft;
    flashSaleContainer.style.cursor = 'grabbing';
});

flashSaleContainer.addEventListener('mouseleave', () => {
    isDown = false;
    flashSaleContainer.style.cursor = 'grab';
});

flashSaleContainer.addEventListener('mouseup', () => {
    isDown = false;
    flashSaleContainer.style.cursor = 'grab';
});

flashSaleContainer.addEventListener('mousemove', (e) => {
    if (!isDown) return;
    e.preventDefault();
    const x = e.pageX - flashSaleContainer.offsetLeft;
    const walk = (x - startX) * 2; // Increased multiplier for smoother scrolling
    flashSaleContainer.scrollLeft = scrollLeft - walk;
});

flashSaleContainer.addEventListener('touchstart', (e) => {
    isDown = true;
    startX = e.touches[0].pageX - flashSaleContainer.offsetLeft;
    scrollLeft = flashSaleContainer.scrollLeft;
});

flashSaleContainer.addEventListener('touchend', () => {
    isDown = false;
});

flashSaleContainer.addEventListener('touchmove', (e) => {
    if (!isDown) return;
    e.preventDefault();
    const x = e.touches[0].pageX - flashSaleContainer.offsetLeft;
    const walk = (x - startX) * 2;
    flashSaleContainer.scrollLeft = scrollLeft - walk;
});

// Sticky header effect
window.addEventListener('scroll', function() {
    const header = document.getElementById('header');
    if (window.scrollY > 50) {
        header.style.padding = '10px 0';
        header.style.boxShadow = '0 5px 15px rgba(0,0,0,0.1)';
    } else {
        header.style.padding = '';
        header.style.boxShadow = '';
    }
});

// Mobile menu toggle
function toggleMenu() {
    const navMenu = document.getElementById('navMenu');
    navMenu.classList.toggle('active');
}

// Scroll reveal animation for elements
const revealElements = document.querySelectorAll('.feature-card, .section-title, .about-container');

const revealElement = function() {
    for (let i = 0; i < revealElements.length; i++) {
        const windowHeight = window.innerHeight;
        const elementTop = revealElements[i].getBoundingClientRect().top;
        const elementVisible = 150;

        if (elementTop < windowHeight - elementVisible) {
            revealElements[i].style.opacity = '1';
            revealElements[i].style.transform = 'translateY(0)';
        } else {
            revealElements[i].style.opacity = '0';
            revealElements[i].style.transform = 'translateY(20px)';
        }
    }
};

// Set initial styles for animation
for (let i = 0; i < revealElements.length; i++) {
    revealElements[i].style.opacity = '0';
    revealElements[i].style.transform = 'translateY(20px)';
    revealElements[i].style.transition = 'all 0.6s ease';
}

window.addEventListener('scroll', revealElement);
window.addEventListener('load', revealElement);
