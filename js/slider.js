document.addEventListener('DOMContentLoaded', function() {
    const sliders = document.querySelectorAll('.slider-container');

    sliders.forEach(slider => {
        const track = slider.querySelector('.slider-track');
        const slides = slider.querySelectorAll('.slider-slide');
        const nextBtn = slider.querySelector('.next');
        const prevBtn = slider.querySelector('.prev');
        const dotsContainer = slider.parentElement.querySelector('.carousel-indicators'); 
        
        if (!track || slides.length === 0) return;

        let currentIndex = 0;
        const slideCount = slides.length;

        function updateSlide() {
            track.style.transform = `translateX(-${currentIndex * 100}%)`;
            
             if (dotsContainer) {
                const dots = dotsContainer.querySelectorAll('.indicator');
                dots.forEach((dot, index) => {
                    dot.classList.toggle('active', index === currentIndex);
                });
            }
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                currentIndex = (currentIndex + 1) % slideCount;
                updateSlide();
            });
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                currentIndex = (currentIndex - 1 + slideCount) % slideCount;
                updateSlide();
            });
        }

        let touchStartX = 0;
        let touchEndX = 0;

        slider.addEventListener('touchstart', e => {
            touchStartX = e.changedTouches[0].screenX;
        }, {passive: true});

        slider.addEventListener('touchend', e => {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        }, {passive: true});

        function handleSwipe() {
            if (touchEndX < touchStartX - 50) {
                currentIndex = (currentIndex + 1) % slideCount;
                updateSlide();
            }
            if (touchEndX > touchStartX + 50) {
                currentIndex = (currentIndex - 1 + slideCount) % slideCount;
                updateSlide();
            }
        }
    });

    const testimonials = document.querySelectorAll('.testimonial-card');
    const indicators = document.querySelectorAll('.carousel-indicators .indicator');
    
    if (testimonials.length > 0 && indicators.length > 0) {
        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                testimonials.forEach(t => t.classList.remove('active'));
                indicators.forEach(i => i.classList.remove('active'));
                
                testimonials[index].classList.add('active');
                indicator.classList.add('active');
            });
        });
    }
});
