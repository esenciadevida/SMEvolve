import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

const prefersReducedMotion = () =>
    window.matchMedia('(prefers-reduced-motion: reduce)').matches;

/**
 * Hero entrance timeline. Targets are marked with data-hero-* attributes so
 * the markup stays framework-agnostic and safe when JS is unavailable.
 *
 * Motion is transform-only (no opacity tweens) so content is never left in a
 * faded state if animation setup is interrupted.
 */
function initHero() {
    const hero = document.querySelector('[data-hero]');

    if (! hero) {
        return;
    }

    const tl = gsap.timeline({
        defaults: { ease: 'power3.out', duration: 0.8, clearProps: 'transform' },
    });

    tl.from('[data-hero-eyebrow]', { y: 12, duration: 0.5 })
        .from('[data-hero-title]', { y: 22 }, '-=0.35')
        .from('[data-hero-copy]', { y: 16 }, '-=0.55')
        .from('[data-hero-cta] > *', { y: 14, stagger: 0.1 }, '-=0.45')
        .from('[data-hero-trust] > *', { y: 12, stagger: 0.06 }, '-=0.4')
        .from('[data-hero-visual]', { y: 28, scale: 0.97, duration: 1 }, '-=0.75');
}

let initialised = false;

export function initAnimations() {
    if (initialised || prefersReducedMotion()) {
        return;
    }

    initialised = true;

    // Content is never hidden by animation. The one-time hero entrance is
    // isolated so a single failure cannot leave the rest of the page affected.
    try {
        initHero();
    } catch (error) {
        console.warn('[SMEvolve animations]', error);
    }

    const refresh = () => ScrollTrigger.refresh();

    if (document.readyState !== 'complete') {
        window.addEventListener('load', refresh, { once: true });
    } else {
        requestAnimationFrame(refresh);
    }

    requestAnimationFrame(refresh);
}