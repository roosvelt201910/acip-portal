/**
 * JavaScript Principal - Portal ACIP
 */

document.addEventListener('DOMContentLoaded', function () {

    // ============================================
    // MENÚ MÓVIL
    // ============================================
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const navMenu = document.getElementById('navMenu');

    if (mobileMenuToggle && navMenu) {
        mobileMenuToggle.addEventListener('click', function () {
            navMenu.classList.toggle('active');
            const icon = this.querySelector('i');
            icon.classList.toggle('fa-bars');
            icon.classList.toggle('fa-times');
        });

        // Mobile Dropdown Toggle
        const dropdownToggles = document.querySelectorAll('.nav-menu .dropdown > a');
        dropdownToggles.forEach(toggle => {
            toggle.addEventListener('click', function (e) {
                // If on mobile (check via standard breakpoint or simple logic)
                if (window.innerWidth <= 768) {
                    e.preventDefault();

                    const parent = this.parentElement;
                    const isActive = parent.classList.contains('active');

                    // Close all other dropdowns
                    dropdownToggles.forEach(otherToggle => {
                        otherToggle.parentElement.classList.remove('active');
                    });

                    // Toggle current
                    if (!isActive) {
                        parent.classList.add('active');
                    }
                }
            });
        });

        // Cerrar menú al hacer click fuera
        document.addEventListener('click', function (e) {
            if (!navMenu.contains(e.target) && !mobileMenuToggle.contains(e.target)) {
                navMenu.classList.remove('active');
                const icon = mobileMenuToggle.querySelector('i');
                icon.classList.add('fa-bars');
                icon.classList.remove('fa-times');
            }
        });
    }

    // ============================================
    // SLIDER DE BANNERS
    // ============================================
    const sliderContainer = document.querySelector('.slider-container');

    if (sliderContainer) {
        const slides = document.querySelectorAll('.slide');
        const prevBtn = document.querySelector('.slider-prev');
        const nextBtn = document.querySelector('.slider-next');
        const dotsContainer = document.querySelector('.slider-dots');

        let currentIndex = 0;
        const totalSlides = slides.length;
        let autoPlayInterval;

        // Crear dots
        if (dotsContainer && totalSlides > 1) {
            for (let i = 0; i < totalSlides; i++) {
                const dot = document.createElement('span');
                dot.classList.add('dot');
                if (i === 0) dot.classList.add('active');
                dot.addEventListener('click', () => {
                    goToSlide(i);
                    resetAutoPlay();
                });
                dotsContainer.appendChild(dot);
            }
        }

        // Simple Banner Slider Logic
        function updateSliderPosition() {
            // Standard single-slide carousel behavior
            const offset = currentIndex * -100;
            // Assuming sliderContainer acts as the track or we move slides
            // If there is a track wrapper:
            // But based on context, .slider-container seems to be the wrapper.
            // Let's try simple translateX on the container if it holds slides side-by-side
            // OR toggle active classes if it's a fade slider.

            // Safer approach for undefined HTML structure:
            // Just toggle active class on slides if they are absolute
            slides.forEach((slide, index) => {
                if (index === currentIndex) {
                    slide.style.display = 'block';
                    slide.style.opacity = '1';
                    slide.classList.add('active');
                } else {
                    slide.style.display = 'none';
                    slide.style.opacity = '0';
                    slide.classList.remove('active');
                }
            });

            // Update dots
            const dots = document.querySelectorAll('.slider-dots .dot');
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === currentIndex);
            });
        }

        function goToSlide(n) {
            currentIndex = n;
            updateSliderPosition();
        }

        function nextSlide() {
            currentIndex = (currentIndex + 1) % totalSlides;
            updateSliderPosition();
        }

        function prevSlide() {
            currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
            updateSliderPosition();
        }

        // Auto-play functionality
        function startAutoPlay() {
            if (totalSlides > 1) {
                autoPlayInterval = setInterval(nextSlide, 5000); // Change slide every 5 seconds
            }
        }

        function resetAutoPlay() {
            if (autoPlayInterval) clearInterval(autoPlayInterval);
            startAutoPlay();
        }

        if (prevBtn && nextBtn) {
            nextBtn.addEventListener('click', () => {
                nextSlide();
                resetAutoPlay(); // Reset timer when user manually changes slide
            });

            prevBtn.addEventListener('click', () => {
                prevSlide();
                resetAutoPlay(); // Reset timer when user manually changes slide
            });
        }

        // Start auto-play
        startAutoPlay();

    }

    // ============================================
    // SLIDER DE NOTICIAS (VANILLA JS IMPLEMENTATION)
    // ============================================
    // ============================================
    // SLIDER DE NOTICIAS (2-COLUMN CAROUSEL + CLONING)
    // ============================================
    const newsContainer = document.querySelector('#news-revolver');
    if (newsContainer) {
        const track = newsContainer.querySelector('.news-track');
        // Initial query
        let slides = track.querySelectorAll('.noticia-slide');
        const prevBtn = document.getElementById('news-prev-btn');
        const nextBtn = document.getElementById('news-next-btn');

        // CLONING LOGIC: Ensure enough slides for scrolling
        // We need substantially more slides than the viewport count (2) to allow scrolling.
        // If we have 1 item -> needs 4+ copies.
        // If we have 2 items -> needs 2+ copies.
        // Goal: Minimum 6 slides for smooth looping.

        if (slides.length > 0) {
            let currentCount = slides.length;
            const minSlides = 6;

            // Keep appending copies of the original set until we reach minSlides
            while (currentCount < minSlides) {
                // Clone all original slides effectively by using the current live list 
                // or better: just clone the originals in a loop.
                // To be safe, we iterate over the *initial* slides list we captured.
                for (let i = 0; i < slides.length; i++) {
                    if (currentCount >= minSlides) break;
                    const clone = slides[i].cloneNode(true);
                    clone.classList.add('cloned-slide');
                    track.appendChild(clone);
                    currentCount++;
                }
            }

            // IMPORTANT: Re-query slides after cloning so subsequent logic sees them!
            if (currentCount > slides.length) {
                slides = track.querySelectorAll('.noticia-slide');
                console.log('Slides cloned to meet minimum. New total:', slides.length);
            }
        }

        let currentIndex = 0;
        let autoPlayInterval;

        // Start AutoPlay
        function startAutoPlay() {
            // Determine slidesPerView based on window width
            const isMobile = window.innerWidth < 900;
            const viewCount = isMobile ? 1 : 2;

            if (slides.length > viewCount) {
                autoPlayInterval = setInterval(nextSlide, 5000);
            }
        }

        function updateSliderPosition() {
            const isMobile = window.innerWidth < 900;
            const percent = isMobile ? 100 : 50;
            const slidesPerView = isMobile ? 1 : 2;

            // Max index based on view
            const maxIndex = slides.length - slidesPerView;

            // Boundary checks
            if (currentIndex > maxIndex) currentIndex = 0;
            if (currentIndex < 0) currentIndex = maxIndex;

            track.style.transform = `translateX(-${currentIndex * percent}%)`;
        }

        function nextSlide() {
            const isMobile = window.innerWidth < 900;
            const slidesPerView = isMobile ? 1 : 2;
            const maxIndex = slides.length - slidesPerView;

            if (currentIndex < maxIndex) {
                currentIndex++;
            } else {
                currentIndex = 0; // Loop back to start
            }
            updateSliderPosition();
        }

        function prevSlide() {
            const isMobile = window.innerWidth < 900;
            const slidesPerView = isMobile ? 1 : 2;
            const maxIndex = slides.length - slidesPerView;

            if (currentIndex > 0) {
                currentIndex--;
            } else {
                currentIndex = maxIndex; // Loop to end
            }
            updateSliderPosition();
        }

        function resetAutoPlay() {
            if (autoPlayInterval) clearInterval(autoPlayInterval);
            startAutoPlay();
        }

        // OVERRIDE global functions with actual logic
        window.moveNewsNext = function () {
            nextSlide();
            resetAutoPlay();
        };

        window.moveNewsPrev = function () {
            prevSlide();
            resetAutoPlay();
        };

        // Handle resize
        window.addEventListener('resize', () => {
            updateSliderPosition();
        });

        // Initial call
        setTimeout(() => {
            updateSliderPosition();
            startAutoPlay();
        }, 100);

        console.log('News carousel initialized (Total slides: ' + slides.length + ')');
    }

    // ============================================
    // SLIDER DE EVENTOS (SAME LOGIC AS NEWS)
    // ============================================

    // Global overrides for Events
    window.moveEventsNext = function () { console.warn('Events slider not ready'); };
    window.moveEventsPrev = function () { console.warn('Events slider not ready'); };

    const eventsContainer = document.querySelector('.events-slider-container');
    if (eventsContainer) {
        const track = eventsContainer.querySelector('.events-track');
        let slides = track.querySelectorAll('.evento-slide');
        const prevBtn = document.getElementById('events-prev-btn');
        const nextBtn = document.getElementById('events-next-btn');

        // Cloning for Events
        if (slides.length > 0) {
            let currentCount = slides.length;
            const minSlides = 6; // Need at least 6-9 for 3-col view to loop nicely

            while (currentCount < minSlides) {
                for (let i = 0; i < slides.length; i++) {
                    if (currentCount >= minSlides) break;
                    const clone = slides[i].cloneNode(true);
                    // Remove active classes from clones just in case
                    clone.classList.remove('active-center');
                    track.appendChild(clone);
                    currentCount++;
                }
            }
            if (currentCount > slides.length) {
                slides = track.querySelectorAll('.evento-slide');
            }
        }

        let currentIndex = 0;
        let autoPlayInterval;

        function getSlidesPerView() {
            if (window.innerWidth < 768) return 1;
            if (window.innerWidth < 1024) return 2;
            return 3;
        }

        function updateSliderPosition() {
            const views = getSlidesPerView();
            const percent = 100 / views;
            const maxIndex = slides.length - views;

            if (currentIndex > maxIndex) currentIndex = 0;
            if (currentIndex < 0) currentIndex = maxIndex;

            track.style.transform = `translateX(-${currentIndex * percent}%)`;

            // Optional: Update active-center class for visual style
            // Usually the "middle" one.
            slides.forEach(s => s.classList.remove('active-center'));
            // If 3 views, active is index+1. If 1 view, index.
            let activeIndex = currentIndex;
            if (views === 3) activeIndex = currentIndex + 1;
            if (views === 2) activeIndex = currentIndex; // or +1? Use logic.

            if (slides[activeIndex]) slides[activeIndex].classList.add('active-center');
        }

        function nextSlide() {
            const views = getSlidesPerView();
            const maxIndex = slides.length - views;
            if (currentIndex < maxIndex) currentIndex++;
            else currentIndex = 0;
            updateSliderPosition();
        }

        function prevSlide() {
            const views = getSlidesPerView();
            const maxIndex = slides.length - views;
            if (currentIndex > 0) currentIndex--;
            else currentIndex = maxIndex;
            updateSliderPosition();
        }

        function startAutoPlay() {
            if (slides.length > getSlidesPerView()) {
                autoPlayInterval = setInterval(nextSlide, 5000);
            }
        }

        function resetAutoPlay() {
            if (autoPlayInterval) clearInterval(autoPlayInterval);
            startAutoPlay();
        }

        // Expose globals
        window.moveEventsNext = function () { nextSlide(); resetAutoPlay(); };
        window.moveEventsPrev = function () { prevSlide(); resetAutoPlay(); };

        // Listeners backup
        if (prevBtn && nextBtn) {
            nextBtn.addEventListener('click', (e) => { e.preventDefault(); });
            prevBtn.addEventListener('click', (e) => { e.preventDefault(); });
        }

        window.addEventListener('resize', updateSliderPosition);

        setTimeout(() => {
            updateSliderPosition();
            startAutoPlay();
        }, 100);

        console.log('Events carousel initialized');
    }

    // ============================================
    // NAVBAR STICKY
    // ============================================
    const navbar = document.querySelector('.navbar');

    if (navbar) {
        window.addEventListener('scroll', function () {
            if (window.scrollY > 100) {
                navbar.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.15)';
            } else {
                navbar.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.1)';
            }
        });
    }

    // ============================================
    // ANIMACIONES AL SCROLL
    // ============================================
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function (entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observar elementos con animación
    const animatedElements = document.querySelectorAll('.noticia-card, .programa-card, .evento-item, .acceso-card');
    animatedElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });

    // ============================================
    // FORMULARIOS
    // ============================================
    const forms = document.querySelectorAll('form');

    forms.forEach(form => {
        form.addEventListener('submit', function (e) {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enviando...';
            }
        });
    });

    // ============================================
    // BÚSQUEDA
    // ============================================
    const searchIcon = document.querySelector('.search-icon');

    if (searchIcon) {
        searchIcon.addEventListener('click', function () {
            // Implementar modal de búsqueda
            const searchQuery = prompt('¿Qué estás buscando?');
            if (searchQuery) {
                window.location.href = `/buscar?q=${encodeURIComponent(searchQuery)}`;
            }
        });
    }

    // ============================================
    // SMOOTH SCROLL
    // ============================================
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});

// ============================================
// SLIDER DE ENLACES DESTACADOS
// ============================================
const enlacesContainer = document.getElementById('enlaces-slider');
if (enlacesContainer) {
    const track = enlacesContainer.querySelector('.enlaces-track');
    let slides = track.querySelectorAll('.enlace-slide');

    // Clone slides to ensure infinite scroll (min 6 items)
    if (slides.length > 0) {
        let currentCount = slides.length;
        const minSlides = 6;

        while (currentCount < minSlides) {
            for (let i = 0; i < slides.length; i++) {
                if (currentCount >= minSlides) break;
                const clone = slides[i].cloneNode(true);
                track.appendChild(clone);
                currentCount++;
            }
        }
        if (currentCount > slides.length) {
            slides = track.querySelectorAll('.enlace-slide');
        }
    }

    let currentIndex = 0;
    let autoPlayInterval;

    function getEnlaceSlidesPerView() {
        if (window.innerWidth < 576) return 1;
        if (window.innerWidth < 992) return 2;
        return 5;
    }

    function updateEnlacesPosition() {
        const views = getEnlaceSlidesPerView();
        const percent = 100 / views;
        const maxIndex = slides.length - views;

        if (currentIndex > maxIndex) currentIndex = 0;
        if (currentIndex < 0) currentIndex = maxIndex;

        track.style.transform = `translateX(-${currentIndex * percent}%)`;
    }

    function nextEnlaceSlide() {
        const views = getEnlaceSlidesPerView();
        const maxIndex = slides.length - views;

        if (currentIndex < maxIndex) {
            currentIndex++;
        } else {
            currentIndex = 0;
        }
        updateEnlacesPosition();
    }

    function startEnlacesAutoPlay() {
        if (slides.length > getEnlaceSlidesPerView()) {
            autoPlayInterval = setInterval(nextEnlaceSlide, 3000); // 3 seconds for faster rotation
        }
    }

    // Handle resize
    window.addEventListener('resize', updateEnlacesPosition);

    // Init
    setTimeout(() => {
        updateEnlacesPosition();
        startEnlacesAutoPlay();
    }, 100);

    console.log('Enlaces carousel initialized');
}

// ============================================
// SLIDER DE PROGRAMAS DE ESTUDIO (3 COLUMNAS)
// ============================================
const programasContainer = document.getElementById('programas-slider');
if (programasContainer) {
    const track = programasContainer.querySelector('.programas-track');
    let slides = track.querySelectorAll('.programa-slide');

    // Clone slides to ensure infinite scroll (min 6 items for 3-col view)
    if (slides.length > 0) {
        let currentCount = slides.length;
        const minSlides = 6;

        while (currentCount < minSlides) {
            for (let i = 0; i < slides.length; i++) {
                if (currentCount >= minSlides) break;
                const clone = slides[i].cloneNode(true);
                track.appendChild(clone);
                currentCount++;
            }
        }
        if (currentCount > slides.length) {
            slides = track.querySelectorAll('.programa-slide');
        }
    }

    let currentIndex = 0;
    let autoPlayInterval;

    function getProgramasSlidesPerView() {
        if (window.innerWidth < 576) return 1;
        if (window.innerWidth < 992) return 2;
        return 3; // 3 columns for desktop
    }

    function updateProgramasPosition() {
        const views = getProgramasSlidesPerView();
        const percent = 100 / views;
        const maxIndex = slides.length - views;

        if (currentIndex > maxIndex) currentIndex = 0;
        if (currentIndex < 0) currentIndex = maxIndex;

        track.style.transform = `translateX(-${currentIndex * percent}%)`;
    }

    function nextProgramaSlide() {
        const views = getProgramasSlidesPerView();
        const maxIndex = slides.length - views;

        if (currentIndex < maxIndex) {
            currentIndex++;
        } else {
            currentIndex = 0;
        }
        updateProgramasPosition();
    }

    function startProgramasAutoPlay() {
        if (slides.length > getProgramasSlidesPerView()) {
            autoPlayInterval = setInterval(nextProgramaSlide, 4000); // 4 seconds
        }
    }

    // Handle resize
    window.addEventListener('resize', updateProgramasPosition);

    // Init
    setTimeout(() => {
        updateProgramasPosition();
        startProgramasAutoPlay();
    }, 100);

    console.log('Programas carousel initialized');
}

// ============================================
// BOTON IR ARRIBA
// ============================================
const scrollTopBtn = document.getElementById('scrollTopBtn');

if (scrollTopBtn) {
    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
            scrollTopBtn.classList.add('show');
        } else {
            scrollTopBtn.classList.remove('show');
        }
    });

    scrollTopBtn.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}
