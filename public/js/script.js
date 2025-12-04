document.addEventListener('DOMContentLoaded', function() {
    initSlider();
    initNavigation();
});

// SLIDER CONFIGURATION
const sliderConfig = {
    slides: document.querySelectorAll('.slide'),
    indicators: document.querySelectorAll('.indicator'),
    currentSlide: 0,
    autoPlayInterval: 3000, // 3 detik
    autoPlayTimer: null
};

/**
 * Initialize Slider
 */
function initSlider() {
    // Tombol kontrol slider
    const prevBtn = document.getElementById('sliderPrev');
    const nextBtn = document.getElementById('sliderNext');

    // Check if slider elements exist
    if (!prevBtn || !nextBtn) {
        return;
    }

    prevBtn.addEventListener('click', () => previousSlide());
    nextBtn.addEventListener('click', () => nextSlide());

    // Indicator click
    sliderConfig.indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => goToSlide(index));
    });

    // Auto play
    startAutoPlay();

    // Pause on hover
    const sliderContainer = document.querySelector('.slider-container');
    if (sliderContainer) {
        sliderContainer.addEventListener('mouseenter', pauseAutoPlay);
        sliderContainer.addEventListener('mouseleave', startAutoPlay);
    }
}

/**
 * Next Slide
 */
function nextSlide() {
    sliderConfig.currentSlide = (sliderConfig.currentSlide + 1) % sliderConfig.slides.length;
    updateSlider();
    resetAutoPlay();
}

/**
 * Previous Slide
 */
function previousSlide() {
    sliderConfig.currentSlide = (sliderConfig.currentSlide - 1 + sliderConfig.slides.length) % sliderConfig.slides.length;
    updateSlider();
    resetAutoPlay();
}

/**
 * Go to Specific Slide
 */
function goToSlide(index) {
    sliderConfig.currentSlide = index;
    updateSlider();
    resetAutoPlay();
}

/**
 * Update Slider Display
 */
function updateSlider() {
    // Update slides
    sliderConfig.slides.forEach((slide, index) => {
        if (index === sliderConfig.currentSlide) {
            slide.classList.add('active');
        } else {
            slide.classList.remove('active');
        }
    });

    // Update indicators
    sliderConfig.indicators.forEach((indicator, index) => {
        if (index === sliderConfig.currentSlide) {
            indicator.classList.add('active');
        } else {
            indicator.classList.remove('active');
        }
    });
}

/**
 * Start Auto Play
 */
function startAutoPlay() {
    sliderConfig.autoPlayTimer = setInterval(() => {
        sliderConfig.currentSlide = (sliderConfig.currentSlide + 1) % sliderConfig.slides.length;
        updateSlider();
    }, sliderConfig.autoPlayInterval);
}

/**
 * Pause Auto Play
 */
function pauseAutoPlay() {
    clearInterval(sliderConfig.autoPlayTimer);
}

/**
 * Reset Auto Play (ketika user klik tombol atau indicator)
 */
function resetAutoPlay() {
    pauseAutoPlay();
    startAutoPlay();
}

/**
 * Initialize Navigation Menu
 */
function initNavigation() {
    const navLinks = document.querySelectorAll('.nav-link');

    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        
        // HANYA handle placeholder links (#)
        // Real href links dibiarkan browser handle sepenuhnya, server akan set active class
        if (href === '#') {
            link.addEventListener('click', (e) => {
                e.preventDefault();

                // Remove active class dari semua links
                navLinks.forEach(l => l.classList.remove('active'));

                // Add active class ke link yang diklik
                link.classList.add('active');

                // Get page name from data-page attribute
                const page = link.getAttribute('data-page');
                console.log('Navigate to:', page);
            });
        }
    });
}

/**
 * Fix active navigation berdasarkan current URL
 * Sebagai fallback jika server-side active class tidak ditetapkan dengan benar
 */
function fixActiveNavigation() {
    console.log('[fixActiveNavigation] Current pathname:', window.location.pathname);
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-link[href]');
    
    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        console.log('[fixActiveNavigation] Checking link:', href);
        
        // Bersihkan active class dari semua
        link.classList.remove('active');
        
        // Set active jika href match dengan current path
        if (href === '/' && currentPath === '/GalerySumbawa/') {
            console.log('[fixActiveNavigation] MATCH: / (home)');
            link.classList.add('active');
        } else if (href !== '/' && currentPath.endsWith(href)) {
            console.log('[fixActiveNavigation] MATCH:', href);
            link.classList.add('active');
        }
    });
    
    // Log final state
    console.log('[fixActiveNavigation] Final active links:');
    document.querySelectorAll('.nav-link.active').forEach((link, idx) => {
        console.log(`  [${idx}] href="${link.getAttribute('href')}" - ${link.textContent.trim()}`);
    });
}

