<div
    x-data="loadingBar"
    x-cloak
    class="pointer-events-none fixed inset-x-0 top-0 z-[70]"
    aria-hidden="true"
>
    <div
        class="h-0.5 bg-gradient-to-r from-primary-600 via-secondary-500 to-accent-500 transition-[width] duration-200 ease-out"
        :style="{ width: progress + '%' }"
    ></div>
</div>
