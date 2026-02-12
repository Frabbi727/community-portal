import './bootstrap';

const menuToggle = document.querySelector('[data-menu-toggle]');
const header = document.querySelector('.site-header');

if (menuToggle && header) {
    menuToggle.addEventListener('click', () => {
        header.classList.toggle('is-open');
    });
}

document.querySelectorAll('[data-photo-slider]').forEach((slider) => {
    let slides = Array.from(slider.querySelectorAll('[data-photo-slide]'));
    const prevButton = slider.querySelector('[data-slider-prev]');
    const nextButton = slider.querySelector('[data-slider-next]');
    const dotsContainer = slider.querySelector('[data-slider-dots]');
    const track = slider.querySelector('.photo-slider-track');
    const sourceUrl = slider.dataset.sourceUrl;

    if (slides.length === 0 || !prevButton || !nextButton || !dotsContainer || !track) {
        return;
    }

    let currentIndex = 0;
    let autoSlideTimer = null;
    const autoSlideDelay = 3500;
    let dots = [];

    const showSlide = (index) => {
        currentIndex = (index + slides.length) % slides.length;

        slides.forEach((slide, slideIndex) => {
            slide.classList.toggle('is-active', slideIndex === currentIndex);
        });

        dots.forEach((dot, dotIndex) => {
            dot.classList.toggle('is-active', dotIndex === currentIndex);
        });
    };

    const buildDots = () => {
        dotsContainer.innerHTML = '';
        dots = slides.map((_, index) => {
            const dot = document.createElement('button');
            dot.type = 'button';
            dot.className = 'photo-slider-dot';
            dot.setAttribute('aria-label', `Go to slide ${index + 1}`);
            dot.addEventListener('click', () => showSlide(index));
            dotsContainer.appendChild(dot);
            return dot;
        });
    };

    const escapeHtml = (value) =>
        String(value ?? '')
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#39;');

    const rebuildSlides = (items) => {
        if (!Array.isArray(items)) {
            return;
        }

        if (items.length === 0) {
            track.innerHTML = `
                <article class="photo-slide is-active" data-photo-slide>
                    <div class="photo-slide-caption">
                        <p class="list-title">No active slider photos</p>
                        <p class="muted">Admin can upload photos from Media Manager.</p>
                    </div>
                </article>
            `;
            slides = Array.from(track.querySelectorAll('[data-photo-slide]'));
            currentIndex = 0;
            buildDots();
            showSlide(0);
            return;
        }

        track.innerHTML = items
            .map((item) => `
                <article class="photo-slide" data-photo-slide>
                    <img src="${escapeHtml(item.image_url)}" alt="${escapeHtml(item.title ?? 'Community image')}" class="photo-slide-image">
                    <div class="photo-slide-caption">
                        <p class="list-title">${escapeHtml(item.title ?? 'Untitled')}</p>
                        <p class="muted">By ${escapeHtml(item.author ?? 'Member')}</p>
                        ${item.body ? `<p>${escapeHtml(item.body)}</p>` : ''}
                    </div>
                </article>
            `)
            .join('');

        slides = Array.from(track.querySelectorAll('[data-photo-slide]'));
        currentIndex = 0;
        buildDots();
        showSlide(0);
    };

    const fetchSlidesFromBackend = async () => {
        if (!sourceUrl) {
            return;
        }

        try {
            const response = await fetch(sourceUrl, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });

            if (!response.ok) {
                return;
            }

            const payload = await response.json();
            rebuildSlides(payload.images);
        } catch {
            // Keep current slides if refresh fails.
        }
    };

    const startAutoSlide = () => {
        if (autoSlideTimer) {
            return;
        }

        autoSlideTimer = window.setInterval(() => {
            showSlide(currentIndex + 1);
        }, autoSlideDelay);
    };

    const stopAutoSlide = () => {
        if (!autoSlideTimer) {
            return;
        }

        window.clearInterval(autoSlideTimer);
        autoSlideTimer = null;
    };

    prevButton.addEventListener('click', () => showSlide(currentIndex - 1));
    nextButton.addEventListener('click', () => showSlide(currentIndex + 1));
    slider.addEventListener('mouseenter', stopAutoSlide);
    slider.addEventListener('mouseleave', startAutoSlide);
    slider.addEventListener('focusin', stopAutoSlide);
    slider.addEventListener('focusout', startAutoSlide);

    buildDots();
    showSlide(0);
    startAutoSlide();
    fetchSlidesFromBackend();
    window.setInterval(fetchSlidesFromBackend, 10000);
});
