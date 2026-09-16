import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

const prefersReducedMotion = () =>
    window.matchMedia('(prefers-reduced-motion: reduce)').matches;

/**
 * Hero entrance timeline. Targets are marked with data-hero-* attributes so
 * the markup stays framework-agnostic and safe when JS is unavailable.
 */
function initHero() {
    const hero = document.querySelector('[data-hero]');

    if (!hero) {
        return;
    }

    const tl = gsap.timeline({
        defaults: { ease: 'power3.out', duration: 0.8 },
    });

    tl.from('[data-hero-eyebrow]', { opacity: 0, y: 12, duration: 0.5 })
        .from('[data-hero-title]', { opacity: 0, y: 22 }, '-=0.35')
        .from('[data-hero-copy]', { opacity: 0, y: 16 }, '-=0.55')
        .from('[data-hero-cta] > *', { opacity: 0, y: 14, stagger: 0.1 }, '-=0.45')
        .from('[data-hero-trust] > *', { opacity: 0, y: 12, stagger: 0.06 }, '-=0.4')
        .from('[data-hero-visual]', { opacity: 0, y: 28, scale: 0.97, duration: 1 }, '-=0.75');

    if (document.querySelector('[data-hero-paths]')) {
        gsap.from('[data-hero-paths]', {
            opacity: 0,
            duration: 1.4,
            delay: 0.25,
            ease: 'power2.out',
        });

        gsap.fromTo(
            '[data-hero-paths] [data-path-dot]',
            { opacity: 0, scale: 0.4 },
            {
                opacity: 1,
                scale: 1,
                duration: 0.5,
                stagger: 0.2,
                delay: 1.1,
                transformOrigin: 'center',
            },
        );
    }
}

/**
 * Reveal-on-scroll. Elements carry `data-reveal`. When wrapped in a
 * `data-reveal-group`, descendants animate together with a stagger.
 */
function initReveals() {
    const defaults = { opacity: 0, y: 24, duration: 0.65, ease: 'power2.out' };

    gsap.utils.toArray('[data-reveal-group]').forEach((group) => {
        const items = Array.from(group.children);

        if (!items.length) {
            return;
        }

        gsap.from(items, {
            ...defaults,
            stagger: 0.08,
            scrollTrigger: { trigger: group, start: 'top 82%' },
        });
    });

    gsap.utils.toArray('[data-reveal]').forEach((el) => {
        const delay = Number.parseFloat(el.dataset.revealDelay ?? '') || 0;

        gsap.from(el, {
            ...defaults,
            delay,
            scrollTrigger: { trigger: el, start: 'top 86%' },
        });
    });
}

/**
 * Draws the process connector path as the visitor scrolls through the section.
 */
function initProcessPath() {
    const section = document.querySelector('[data-process]');
    const path = section?.querySelector('[data-process-path]');

    if (!section || !path) {
        return;
    }

    const length = path.getTotalLength();

    gsap.set(path, { strokeDasharray: length, strokeDashoffset: length });

    gsap.to(path, {
        strokeDashoffset: 0,
        ease: 'none',
        scrollTrigger: {
            trigger: section,
            start: 'top 75%',
            end: 'bottom 70%',
            scrub: true,
        },
    });
}

let initialised = false;

export function initAnimations() {
    if (initialised || prefersReducedMotion()) {
        return;
    }

    initialised = true;

    initHero();
    initReveals();
    initProcessPath();

    window.addEventListener('load', () => ScrollTrigger.refresh());
}
