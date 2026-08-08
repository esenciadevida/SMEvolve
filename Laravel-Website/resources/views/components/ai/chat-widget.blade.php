@props([
    'enabled' => null,
    'welcomeMessage' => null,
    'availabilityMessage' => null,
])

@php
    $enabled = $enabled ?? app(\App\Services\AI\AiConfigService::class)->assistantEnabled();
    $welcomeMessage = $welcomeMessage ?? config('ai.assistant.welcome_message');
    $availabilityMessage = $availabilityMessage ?? config('ai.assistant.availability_message');
    $maxMessageLength = (int) config('ai.limits.max_message_length', 4000);
@endphp

@if ($enabled)
    <div
        x-data="aiChat({
            statusUrl: '{{ route('ai.api.status') }}',
            conversationsUrl: '{{ route('ai.api.conversations.store') }}',
            handoffUrl: '{{ route('ai.api.handoffs') }}',
            welcomeMessage: @js($welcomeMessage),
            availabilityMessage: @js($availabilityMessage),
            maxMessageLength: {{ $maxMessageLength }},
            csrfToken: '{{ csrf_token() }}',
        })"
        x-cloak
        x-show="! $store.fab.hubOpen"
        @keydown.escape.window="close()"
        class="fixed bottom-24 right-6 z-50"
    >
        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 scale-95"
            class="mb-3 flex h-[35rem] w-[25rem] min-h-[20rem] max-h-[calc(100dvh-8rem)] max-w-[calc(100vw-2.5rem)] flex-col overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-card-hover ring-1 ring-black/5 dark:border-slate-700 dark:bg-slate-900 dark:ring-white/5"
            role="dialog"
            aria-modal="true"
            aria-labelledby="ai-chat-title"
        >
            <div class="relative flex items-center justify-between gap-2 bg-gradient-to-br from-primary-600 via-primary-600 to-secondary-700 px-4 py-3.5 text-white">
                <div class="pointer-events-none absolute inset-x-0 bottom-0 h-px bg-white/15"></div>
                <div class="flex min-w-0 items-center gap-3">
                    <span class="relative flex h-10 w-10 flex-none items-center justify-center rounded-full bg-white/15 text-white shadow-inner ring-1 ring-white/20">
                        <x-icon name="sparkles" class="h-5 w-5" />
                        <span x-show="available" class="absolute -right-0.5 -top-0.5 flex h-3 w-3" x-cloak>
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-accent-500 opacity-75"></span>
                            <span class="relative inline-flex h-3 w-3 rounded-full border-2 border-primary-600 bg-accent-500"></span>
                        </span>
                    </span>
                    <div class="min-w-0">
                        <p id="ai-chat-title" class="truncate text-sm font-semibold leading-tight">SMEvolve AI Assistant</p>
                        <p class="flex items-center gap-1.5 text-[11px] text-white/75">
                            <span x-text="available ? 'Online, replies instantly' : 'Unavailable right now'"></span>
                        </p>
                    </div>
                </div>
                <div class="flex flex-none items-center gap-0.5">
                    <button
                        type="button"
                        @click="newChat()"
                        aria-label="Start a new chat"
                        title="New chat"
                        class="rounded-lg p-1.5 transition hover:bg-white/20"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                    </button>
                    <button
                        type="button"
                        @click="close()"
                        aria-label="Close chat"
                        title="Close"
                        class="rounded-lg p-1.5 transition hover:bg-white/20"
                    >
                        <x-icon name="x-mark" class="h-4.5 w-4.5" />
                    </button>
                </div>
            </div>

            <div
                x-ref="messages"
                class="chat-scroll flex flex-1 flex-col space-y-1.5 overflow-y-auto bg-slate-50 px-2.5 py-2.5 dark:bg-slate-950"
            >
                <template x-for="(message, index) in messages" :key="message.id">
                    <div
                        class="flex w-full"
                        :class="(message.role === 'user' ? 'justify-end items-end' : 'justify-start items-start') + (index === 0 ? ' mt-auto' : '')"
                    >
                        <span
                            x-show="message.role !== 'user'"
                            class="mr-2 mt-1 flex h-7 w-7 flex-none items-center justify-center rounded-full bg-gradient-to-br from-primary-600 to-secondary-600 text-white shadow-sm"
                        >
                            <x-icon name="sparkles" class="h-3.5 w-3.5" />
                        </span>
                        <div
                            class="w-fit min-w-0 max-w-[85%] rounded-2xl px-2.5 py-1.5 text-sm leading-relaxed"
                            :class="message.role === 'user'
                                ? 'rounded-br-md bg-primary-600 text-white shadow-sm'
                                : 'rounded-bl-md border border-slate-200/80 bg-white text-slate-800 shadow-sm dark:border-slate-700/70 dark:bg-slate-800 dark:text-slate-100'"
                        >
                            <p class="whitespace-pre-wrap break-words" x-text="message.content"></p>

                            <div x-show="message.contactOptions" class="mt-3 space-y-2">
                                <template x-if="message.contactOptions?.phone">
                                    <a
                                        :href="`tel:${String(message.contactOptions.phone).replace(/\s+/g, '')}`"
                                        class="flex items-center gap-2.5 rounded-xl border border-primary-600/20 bg-primary-600/5 px-3 py-2 text-xs font-semibold text-primary-700 transition hover:bg-primary-600/10 dark:border-primary-500/25 dark:text-primary-400"
                                    >
                                        <span class="flex h-6 w-6 flex-none items-center justify-center rounded-full bg-primary-600/10 text-primary-600 dark:text-primary-400">
                                            <x-icon name="phone" class="h-3.5 w-3.5" />
                                        </span>
                                        <span x-text="message.contactOptions.phone"></span>
                                    </a>
                                </template>
                                <template x-if="message.contactOptions?.email">
                                    <a
                                        :href="`mailto:${message.contactOptions.email}`"
                                        class="flex items-center gap-2.5 rounded-xl border border-primary-600/20 bg-primary-600/5 px-3 py-2 text-xs font-semibold text-primary-700 transition hover:bg-primary-600/10 dark:border-primary-500/25 dark:text-primary-400"
                                    >
                                        <span class="flex h-6 w-6 flex-none items-center justify-center rounded-full bg-primary-600/10 text-primary-600 dark:text-primary-400">
                                            <x-icon name="envelope" class="h-3.5 w-3.5" />
                                        </span>
                                        <span x-text="message.contactOptions.email"></span>
                                    </a>
                                </template>
                                <template x-if="message.contactOptions?.whatsapp">
                                    <a
                                        :href="`https://wa.me/${String(message.contactOptions.whatsapp).replace(/\D/g, '')}`"
                                        target="_blank"
                                        rel="noopener"
                                        class="flex items-center gap-2.5 rounded-xl border border-primary-600/20 bg-primary-600/5 px-3 py-2 text-xs font-semibold text-primary-700 transition hover:bg-primary-600/10 dark:border-primary-500/25 dark:text-primary-400"
                                    >
                                        <span class="flex h-6 w-6 flex-none items-center justify-center rounded-full bg-primary-600/10 text-primary-600 dark:text-primary-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                            </svg>
                                        </span>
                                        <span x-text="message.contactOptions.whatsapp"></span>
                                    </a>
                                </template>
                            </div>

                            <button
                                x-show="message.handoff"
                                @click="requestHuman"
                                type="button"
                                class="mt-2.5 inline-flex items-center gap-1.5 rounded-xl bg-gradient-to-r from-primary-600 to-secondary-600 px-3.5 py-2 text-xs font-semibold text-white shadow-sm shadow-primary-600/25 transition hover:brightness-110 disabled:opacity-50"
                                :disabled="loading"
                            >
                                Yes, talk to the team
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12l-7.5 7.5M21 12H3" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </template>

                <div x-show="showSuggestions" class="space-y-2.5">
                    <p class="px-0.5 text-[10px] font-semibold uppercase tracking-widest text-slate-400 dark:text-slate-500">Try asking</p>
                    <div class="flex flex-wrap gap-2">
                        <template x-for="suggestion in suggestions" :key="suggestion">
                            <button
                                type="button"
                                @click="askSuggestion(suggestion)"
                                class="group inline-flex items-center gap-1.5 rounded-full border border-slate-200 bg-white px-3 py-1.5 text-xs font-medium text-slate-600 shadow-sm transition hover:border-primary-500/50 hover:bg-primary-600/5 hover:text-primary-700 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 dark:hover:text-primary-400"
                            >
                                <span x-text="suggestion"></span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-primary-500 opacity-0 transition group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12l-7.5 7.5M21 12H3" />
                                </svg>
                            </button>
                        </template>
                    </div>
                </div>

                <div x-show="loading" class="flex w-full items-start justify-start">
                    <span class="mr-2 mt-1 flex h-7 w-7 flex-none items-center justify-center rounded-full bg-gradient-to-br from-primary-600 to-secondary-600 text-white shadow-sm">
                        <x-icon name="sparkles" class="h-3.5 w-3.5" />
                    </span>
                    <div class="rounded-2xl rounded-bl-md border border-slate-200/80 bg-white px-3 py-2 text-sm text-slate-500 shadow-sm dark:border-slate-700/70 dark:bg-slate-800 dark:text-slate-400">
                        <span class="inline-flex items-center gap-1">
                            <span class="h-1.5 w-1.5 animate-bounce rounded-full bg-primary-500 [animation-delay:-0.3s]"></span>
                            <span class="h-1.5 w-1.5 animate-bounce rounded-full bg-primary-500 [animation-delay:-0.15s]"></span>
                            <span class="h-1.5 w-1.5 animate-bounce rounded-full bg-primary-500"></span>
                        </span>
                    </div>
                </div>

                <div x-show="error" class="flex items-start gap-2.5 rounded-xl border border-error-500/25 bg-error-500/10 px-3 py-2.5 text-sm text-error-700 dark:text-error-500">
                    <x-icon name="exclamation-triangle" class="mt-0.5 h-4 w-4 flex-none" />
                    <div class="min-w-0 flex-1">
                        <p class="text-sm leading-snug" x-text="error"></p>
                        <button type="button" @click="error = null" class="mt-1 text-xs font-semibold underline underline-offset-2">Dismiss</button>
                    </div>
                </div>
            </div>

            <form
                @submit.prevent="send"
                class="border-t border-slate-200/80 bg-white p-3 dark:border-slate-700 dark:bg-slate-900"
            >
                <div class="flex items-end gap-2">
                    <div class="relative flex-1">
                        <textarea
                            x-ref="input"
                            x-model="input"
                            @input="resizeInput"
                            @keydown.enter.prevent="send"
                            rows="1"
                            :maxlength="maxLength"
                            :placeholder="available ? 'Ask us anything...' : 'Assistant is unavailable'"
                            class="chat-scroll max-h-32 w-full resize-none rounded-2xl border border-slate-200 bg-slate-100 px-4 py-3 text-sm text-slate-800 transition placeholder:text-slate-400 focus:border-primary-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:focus:bg-slate-800"
                            :disabled="loading || ! available"
                        ></textarea>
                        <span
                            x-show="available && remaining < 100"
                            x-cloak
                            class="pointer-events-none absolute -top-2 right-3 rounded-full bg-slate-900/80 px-2 py-0.5 text-[10px] font-medium text-white"
                            x-text="remaining"
                        ></span>
                    </div>
                    <button
                        type="submit"
                        class="flex h-10 w-10 flex-none items-center justify-center rounded-full bg-gradient-to-br from-primary-600 to-secondary-600 text-white shadow-md shadow-primary-600/30 transition hover:scale-105 hover:brightness-110 disabled:opacity-50 disabled:hover:scale-100"
                        :disabled="loading || ! available || input.trim() === ''"
                        aria-label="Send message"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                        </svg>
                    </button>
                </div>
                <p class="mt-2 flex items-center justify-center gap-1 text-center text-[10px] text-slate-400 dark:text-slate-500">
                    <x-icon name="information-circle" class="h-3 w-3" />
                    AI assistant &middot; replies may occasionally be imperfect
                </p>
            </form>
        </div>

        <button
            type="button"
            x-ref="launcher"
            @click="toggle()"
            :aria-expanded="open.toString()"
            :aria-label="open ? 'Close AI assistant' : 'Open AI assistant'"
            class="group relative flex h-14 w-14 items-center justify-center rounded-full bg-gradient-to-br from-primary-600 to-secondary-600 text-white shadow-glow ring-1 ring-white/20 transition duration-200 hover:scale-110 hover:shadow-card-hover focus:outline-none focus-visible:ring-2 focus-visible:ring-primary-600 focus-visible:ring-offset-2"
        >
            <span x-show="! open" class="absolute inset-0 animate-ping rounded-full bg-primary-400/30" aria-hidden="true"></span>
            <svg x-show="! open" xmlns="http://www.w3.org/2000/svg" class="relative h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
            </svg>
            <x-icon name="x-mark" x-show="open" x-cloak class="relative h-6 w-6" />
            <span
                x-show="! open"
                x-cloak
                class="pointer-events-none absolute right-16 top-1/2 hidden -translate-y-1/2 whitespace-nowrap rounded-full border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 opacity-0 shadow-md transition duration-200 group-hover:opacity-100 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 sm:block"
            >Chat with us</span>
        </button>
    </div>
@endif
