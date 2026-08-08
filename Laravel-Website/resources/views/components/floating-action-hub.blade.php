@php
    $contact = config('company.contact', []);

    $resolve = function (array $action) use ($contact) {
        if (! empty($action['route'])) {
            return ['type' => 'link', 'href' => route($action['route']), 'external' => false];
        }

        if (! empty($action['action']) && $action['action'] === 'back-to-top') {
            return ['type' => 'back-to-top'];
        }

        if (isset($action['href'])) {
            $value = $action['href'];

            if ($value === 'whatsapp') {
                $value = $contact['whatsapp'] ?? null;
            } elseif ($value === 'phone') {
                $value = $contact['phone'] ?? null;
            } elseif ($value === 'email') {
                $value = $contact['email'] ?? null;
            }

            if (! filled($value)) {
                return ['type' => 'hidden'];
            }

            if (str_starts_with($value, 'http') && ! str_contains($value, 'smevolve')) {
                return ['type' => 'link', 'href' => $value, 'external' => true];
            }

            if ($action['id'] === 'phone') {
                return ['type' => 'link', 'href' => 'tel:'.preg_replace('/\s+/', '', $value), 'external' => false];
            }

            if ($action['id'] === 'email') {
                return ['type' => 'link', 'href' => 'mailto:'.$value, 'external' => false];
            }

            return ['type' => 'link', 'href' => $value, 'external' => true];
        }

        return ['type' => 'hidden'];
    };

    $actions = collect(config('floating_actions.actions', []))
        ->map(fn (array $action) => $action + ['resolved' => $resolve($action)])
        ->reject(fn (array $action) => $action['resolved']['type'] === 'hidden')
        ->values();
@endphp

<div
    x-data="actionHub"
    x-cloak
    x-show="! $store.fab.chatOpen"
    class="fixed bottom-6 right-6 z-40 flex flex-col items-end gap-3"
    aria-label="Quick actions"
>
    <div
        x-show="open"
        x-cloak
        x-transition:enter="transition duration-200 ease-out"
        x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition duration-150 ease-in"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-2"
        class="flex flex-col-reverse items-end gap-2.5"
        role="menu"
        aria-label="{{ config('floating_actions.label', 'Quick actions') }}"
    >
        @foreach ($actions as $action)
            @if ($action['resolved']['type'] === 'back-to-top')
                <button
                    type="button"
                    x-show="showTop"
                    x-cloak
                    @click="scrollTop(); close()"
                    class="group flex min-w-[13.5rem] items-center gap-3 rounded-xl border border-gray-200/70 bg-white py-2.5 dark:bg-dark-card pl-3 pr-3.5 text-sm font-medium text-gray-800 shadow-lg shadow-black/5 transition duration-200 hover:border-primary-600/30 hover:text-gray-900 hover:shadow-xl"
                    role="menuitem"
                    data-track="fab:action"
                    data-track-data="{{ json_encode(['id' => $action['id']]) }}"
                >
                    <span class="flex h-9 w-9 flex-none items-center justify-center rounded-lg bg-primary-600/10 text-primary-600 transition duration-200 group-hover:bg-gradient-to-br group-hover:from-primary-600 group-hover:to-secondary-600 group-hover:text-white">
                        <x-icon :name="$action['icon']" class="h-4.5 w-4.5" />
                    </span>
                    <span class="whitespace-nowrap">{{ $action['label'] }}</span>
                    <x-icon name="arrow-up" class="ml-auto h-4 w-4 flex-none text-gray-300 transition duration-200 group-hover:text-primary-600" />
                </button>
            @else
                <a
                    href="{{ $action['resolved']['href'] }}"
                    @if (($action['resolved']['external'] ?? false)) target="_blank" rel="noopener" @endif
                    class="group flex min-w-[13.5rem] items-center gap-3 rounded-xl border border-gray-200/70 bg-white py-2.5 dark:bg-dark-card pl-3 pr-3.5 text-sm font-medium text-gray-800 shadow-lg shadow-black/5 transition duration-200 hover:border-primary-600/30 hover:text-gray-900 hover:shadow-xl"
                    role="menuitem"
                    data-track="fab:action"
                    data-track-data="{{ json_encode(['id' => $action['id']]) }}"
                >
                    <span class="flex h-9 w-9 flex-none items-center justify-center rounded-lg bg-primary-600/10 text-primary-600 transition duration-200 group-hover:bg-gradient-to-br group-hover:from-primary-600 group-hover:to-secondary-600 group-hover:text-white">
                        <x-icon :name="$action['icon']" class="h-4.5 w-4.5" />
                    </span>
                    <span class="whitespace-nowrap">{{ $action['label'] }}</span>
                    <x-icon name="arrow-right" class="ml-auto h-4 w-4 flex-none text-gray-300 transition duration-200 group-hover:text-primary-600" />
                </a>
            @endif
        @endforeach
    </div>

    <button
        type="button"
        @click="toggle()"
        :aria-expanded="open.toString()"
        aria-haspopup="menu"
        :aria-label="open ? 'Close quick actions' : '{{ config('floating_actions.label', 'Get in touch') }}'"
        class="inline-flex h-14 w-14 items-center justify-center gap-2.5 rounded-full bg-gradient-to-r from-primary-600 to-secondary-600 text-sm font-semibold text-white shadow-glow ring-1 ring-white/10 transition duration-200 hover:shadow-card-hover focus:outline-none focus-visible:ring-2 focus-visible:ring-primary-600 focus-visible:ring-offset-2 sm:h-auto sm:w-auto sm:px-6 sm:py-3.5"
        data-track="fab:toggle"
    >
        <span class="relative flex h-5 w-5 flex-none items-center justify-center">
            <x-icon
                name="chat-bubble-left-right"
                class="h-5 w-5 transition duration-200"
                x-bind:class="open ? 'scale-0 opacity-0 rotate-90' : 'scale-100 opacity-100 rotate-0'"
            />
            <x-icon
                name="x-mark"
                class="absolute inset-0 m-auto h-5 w-5 transition duration-200"
                x-bind:class="open ? 'scale-100 opacity-100 rotate-0' : 'scale-0 opacity-0 -rotate-90'"
                x-cloak
            />
        </span>
        <span class="hidden sm:inline" x-text="open ? 'Close' : '{{ config('floating_actions.label', 'Get in touch') }}'"></span>
    </button>
</div>
