@props(['enabled' => true])

@unless ($enabled)
    <style>#site-skeleton { display: none !important; }</style>
@endunless

<div id="site-skeleton" class="sm-skeleton" aria-hidden="true">
    <div class="sm-skeleton__inner">
        <div class="sm-skeleton__nav">
            <div class="skeleton sm-skeleton__logo"></div>
            <div class="sm-skeleton__nav-links">
                <div class="skeleton sm-skeleton__nav-link"></div>
                <div class="skeleton sm-skeleton__nav-link"></div>
                <div class="skeleton sm-skeleton__nav-link"></div>
                <div class="skeleton sm-skeleton__nav-link sm-skeleton__nav-link--optional"></div>
            </div>
            <div class="skeleton sm-skeleton__cta"></div>
        </div>

        <div class="sm-skeleton__hero">
            <div class="sm-skeleton__hero-copy">
                <div class="skeleton sm-skeleton__eyebrow"></div>
                <div class="skeleton sm-skeleton__title"></div>
                <div class="skeleton sm-skeleton__title sm-skeleton__title--narrow"></div>
                <div class="skeleton sm-skeleton__copy"></div>
                <div class="skeleton sm-skeleton__copy sm-skeleton__copy--narrow"></div>
                <div class="sm-skeleton__buttons">
                    <div class="skeleton sm-skeleton__button"></div>
                    <div class="skeleton sm-skeleton__button sm-skeleton__button--ghost"></div>
                </div>
            </div>
            <div class="skeleton sm-skeleton__media"></div>
        </div>

        <div class="sm-skeleton__cards">
            @for ($i = 0; $i < 3; $i++)
                <div class="sm-skeleton__card">
                    <div class="skeleton sm-skeleton__card-media"></div>
                    <div class="skeleton sm-skeleton__card-title"></div>
                    <div class="skeleton sm-skeleton__card-line"></div>
                    <div class="skeleton sm-skeleton__card-line sm-skeleton__card-line--narrow"></div>
                </div>
            @endfor
        </div>
    </div>
</div>

<noscript>
    <style>#site-skeleton { display: none !important; }</style>
</noscript>

<script>
    (function () {
        var el = document.getElementById('site-skeleton');
        if (! el) {
            return;
        }

        if (window.SMEVOLVE_SKELETON_DISABLED === true) {
            el.remove();
            return;
        }

        document.documentElement.classList.add('sm-skeleton-lock');

        var done = false;

        function hide() {
            if (done) {
                return;
            }

            done = true;

            document.documentElement.classList.remove('sm-skeleton-lock');
            el.classList.add('sm-skeleton--done');

            setTimeout(function () {
                if (el.parentNode) {
                    el.parentNode.removeChild(el);
                }
            }, 420);
        }

        window.addEventListener('load', hide);

        setTimeout(hide, 2400);
    })();
</script>