import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

// ============================================
// Global Scroll Reveal Observer
// Only targets elements with .reveal-on-scroll
// ============================================
// ============================================
// Global Scroll Reveal Observer
// ============================================
document.addEventListener('DOMContentLoaded', () => {
    const revealElements = document.querySelectorAll('.reveal, .reveal-on-scroll');

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active', 'is-visible');
                    // If element has a data-delay, apply it
                    const delay = entry.target.getAttribute('data-delay');
                    if (delay) {
                        entry.target.style.transitionDelay = `${delay}ms`;
                    }
                    observer.unobserve(entry.target);
                }
            });
        },
        {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px',
        }
    );

    revealElements.forEach((el) => observer.observe(el));
});

Alpine.start();