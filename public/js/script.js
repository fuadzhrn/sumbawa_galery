document.addEventListener('DOMContentLoaded', function() {
    console.log('[DOMContentLoaded] Initializing components...');
    
    // Debug: Check if button exists
    const btn = document.getElementById('sidebarToggle');
    const sidebar = document.querySelector('.sidebar');
    console.log('[DEBUG] sidebarToggle button found:', !!btn, btn);
    console.log('[DEBUG] sidebar found:', !!sidebar, sidebar);
    console.log('[DEBUG] Window width:', window.innerWidth);
    
    initSlider();
    initNavigation();
    initSidebarToggle();
    initNavToggle();
    console.log('[DOMContentLoaded] All components initialized!');
});

/**
 * Initialize Sidebar Toggle for Hamburger Menu
 */
function initSidebarToggle() {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.querySelector('.sidebar');

    console.log('[initSidebarToggle] sidebarToggle:', sidebarToggle);
    console.log('[initSidebarToggle] sidebar:', sidebar);

    if (!sidebarToggle || !sidebar) {
        console.log('[initSidebarToggle] Toggle button or sidebar not found!');
        return;
    }

    // Debounce flag untuk prevent double-click
    let isToggling = false;

    // Create overlay element for mobile
    let overlay = document.querySelector('.sidebar-overlay');
    if (!overlay) {
        overlay = document.createElement('div');
        overlay.className = 'sidebar-overlay';
        overlay.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 998;
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        `;
        document.body.appendChild(overlay);
        console.log('[initSidebarToggle] Overlay created and appended');
    }

    // Close sidebar helper function
    function closeSidebar() {
        sidebarToggle.classList.remove('active');
        sidebar.classList.remove('show');
        overlay.style.opacity = '0';
        overlay.style.pointerEvents = 'none';
        setTimeout(() => overlay.style.display = 'none', 300);
    }

    // Toggle sidebar visibility
    sidebarToggle.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        // Only process click on button itself, not nested spans
        if (e.target !== sidebarToggle && !sidebarToggle.contains(e.target)) {
            console.log('[Hamburger Click] Click not on button, ignoring');
            return;
        }
        
        // Prevent double-click/double-toggle
        if (isToggling) {
            console.log('[Hamburger Click] Still toggling, ignoring click');
            return;
        }
        
        isToggling = true;
        console.log('[Hamburger Click] Toggling sidebar', 'target:', e.target);
        
        const isOpen = sidebar.classList.contains('show');
        
        if (!isOpen) {
            console.log('[Hamburger Click] Opening sidebar');
            sidebarToggle.classList.add('active');
            sidebar.classList.add('show');
            overlay.style.display = 'block';
            overlay.style.pointerEvents = 'auto';
            setTimeout(() => overlay.style.opacity = '1', 10);
        } else {
            console.log('[Hamburger Click] Closing sidebar');
            closeSidebar();
        }
        
        // Reset toggle flag after transition
        setTimeout(() => {
            isToggling = false;
        }, 300);
    }, { capture: true });

    // Close sidebar when clicking on nav links
    const navLinks = sidebar.querySelectorAll('a');
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Only close on mobile
            if (window.innerWidth <= 767 && sidebar.classList.contains('show')) {
                console.log('[NavLink Click] Closing sidebar on mobile');
                closeSidebar();
            }
        });
    });

    // Close sidebar when clicking on overlay
    overlay.addEventListener('click', function(e) {
        if (sidebar.classList.contains('show')) {
            console.log('[Overlay Click] Closing sidebar');
            closeSidebar();
        }
    });

    // Close sidebar on window resize to desktop
    window.addEventListener('resize', function() {
        if (window.innerWidth > 767 && sidebar.classList.contains('show')) {
            console.log('[Window Resize] Closing sidebar for desktop view');
            closeSidebar();
        }
    });

    console.log('[initSidebarToggle] Setup complete!');
}

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

/**
 * Initialize Nav Toggle for Kategori Submenu
 */
function initNavToggle() {
    const toggleButtons = document.querySelectorAll('.nav-toggle');
    console.log('[initNavToggle] Found toggle buttons:', toggleButtons.length);
    
    toggleButtons.forEach((button, index) => {
        console.log(`[initNavToggle] Button ${index}:`, button);
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const toggleId = this.getAttribute('data-toggle');
            const submenu = document.getElementById(toggleId);
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            
            console.log(`[Toggle Click] toggleId: ${toggleId}, submenu found: ${!!submenu}, isExpanded: ${isExpanded}`);
            
            if (submenu) {
                // Toggle submenu visibility - ONLY untuk submenu yang di-klik
                submenu.classList.toggle('show');
                
                // Update aria-expanded attribute
                this.setAttribute('aria-expanded', !isExpanded);
            }
        });
    });
}