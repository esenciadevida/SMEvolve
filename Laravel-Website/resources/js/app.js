import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

function smoothScroll(options) {
    if (prefersReducedMotion) {
        options.behavior = 'auto';
    }

    return options;
}

document.addEventListener('alpine:init', () => {
    Alpine.data('loadingBar', () => ({
        progress: 0,
        timer: null,

        init() {
            window.addEventListener('click', (event) => {
                const anchor = event.target.closest('a[href]');

                if (! anchor) {
                    return;
                }

                const href = anchor.getAttribute('href') || '';

                if (
                    href.startsWith('#') ||
                    href.startsWith('mailto:') ||
                    href.startsWith('tel:') ||
                    anchor.target === '_blank' ||
                    anchor.hasAttribute('download')
                ) {
                    return;
                }

                this.start();
            });
        },

        start() {
            clearInterval(this.timer);

            this.progress = 8;

            this.timer = setInterval(() => {
                const increment = this.progress < 60 ? 12 : 6;
                this.progress = Math.min(this.progress + increment, 88);
            }, 120);

            window.addEventListener('beforeunload', this.finish, { once: true });
        },

        finish() {
            clearInterval(this.timer);
            this.progress = 100;
        },
    }));

    Alpine.data('actionHub', () => ({
        open: false,
        showTop: false,

        init() {
            this.showTop = window.scrollY > 500;

            window.addEventListener('scroll', () => {
                this.showTop = window.scrollY > 500;
            }, { passive: true });

            document.addEventListener('click', (event) => {
                if (! this.$el.contains(event.target)) {
                    this.close();
                }
            });
        },

        toggle() {
            if (this.open) {
                this.close();
            } else {
                this.open = true;
                Alpine.store('fab').openHub();
            }
        },

        close() {
            this.open = false;
            Alpine.store('fab').closeHub();
        },

        scrollTop() {
            window.scrollTo(smoothScroll({ top: 0, behavior: 'smooth' }));
        },

        track(event, payload = {}) {
            window.SMEvolve.track(event, payload);
        },
    }));

    Alpine.data('aiChat', (config = {}) => ({
        open: false,
        messages: [],
        input: '',
        loading: false,
        error: null,
        available: false,
        enabled: true,
        sessionId: null,
        conversationUuid: null,
        lastReason: null,
        suggestions: [
            'What services do you offer?',
            'How much does a website cost?',
            'How long does a project take?',
            'Do you provide ongoing support?',
        ],
        maxLength: 4000,

        get remaining() {
            return this.maxLength - this.input.length;
        },

        get showSuggestions() {
            return this.available
                && ! this.loading
                && this.messages.filter((message) => message.role === 'user').length === 0;
        },

        init() {
            this.maxLength = parseInt(config.maxMessageLength || '4000', 10) || 4000;

            const stored = this.storageGet('ai_session_id');
            this.sessionId = stored && /^[a-f0-9\-]{8,80}$/i.test(stored) ? stored : this.newId();
            this.storageSet('ai_session_id', this.sessionId);

            const saved = this.storageGet('ai_messages');
            if (saved) {
                try {
                    const parsed = JSON.parse(saved);
                    if (Array.isArray(parsed) && parsed.length) {
                        this.messages = parsed;
                    }
                } catch (e) {}
            }

            this.$watch('messages', (messages) => this.storageSet('ai_messages', JSON.stringify(messages)));

            this.fetchStatus();
        },

        async fetchStatus() {
            try {
                const data = await this.get(`${config.statusUrl}?session_id=${encodeURIComponent(this.sessionId)}`);
                this.enabled = data.enabled !== false;
                this.available = this.enabled;

                if (data.conversation_uuid) {
                    this.conversationUuid = data.conversation_uuid;
                }
            } catch (e) {
                this.available = true;
            }
        },

        toggle() {
            if (this.open) {
                this.close();
            } else {
                this.ensure();
            }
        },

        ensure() {
            Alpine.store('fab').openChat();
            this.open = true;

            if (! this.enabled) {
                this.messages = [{ id: this.newId(), role: 'assistant', content: config.availabilityMessage }];
                this.available = false;
                this.$nextTick(() => this.focusInput());
                return;
            }

            this.available = true;

            if (this.messages.length === 0) {
                this.messages.push({ id: this.newId(), role: 'assistant', content: config.welcomeMessage });
            }

            this.$nextTick(() => {
                this.focusInput();
                this.scrollBottom();
            });
        },

        close() {
            this.open = false;
            Alpine.store('fab').closeChat();
            this.$nextTick(() => this.$refs.launcher?.focus());
        },

        newChat() {
            this.messages = [];
            this.conversationUuid = null;
            this.lastReason = null;
            this.error = null;
            this.ensure();
        },

        askSuggestion(prompt) {
            if (! this.available || this.loading) {
                return;
            }

            this.input = prompt;
            this.send();
        },

        async send() {
            const content = this.input.trim();

            if (! content || this.loading || ! this.available) {
                return;
            }

            this.messages.push({ id: this.newId(), role: 'user', content });
            this.input = '';
            this.error = null;
            this.loading = true;
            this.resizeInput();

            try {
                await this.ensureConversation();

                const data = await this.postMessage(content);

                this.messages.push({ id: this.newId(), role: 'assistant', content: data.reply });
                this.detectHandoff(content, data.reply);
            } catch (error) {
                this.error = error.message || 'Something went wrong. Please try again.';
            } finally {
                this.loading = false;
                this.scrollBottom();
            }
        },

        async ensureConversation() {
            if (this.conversationUuid) {
                return;
            }

            const data = await this.request(config.conversationsUrl, {
                session_id: this.sessionId,
                channel: 'website',
            });

            this.conversationUuid = data.conversation.uuid;
            this.available = true;
        },

        async postMessage(content) {
            try {
                return await this.request(
                    `${config.conversationsUrl}/${this.conversationUuid}/messages`,
                    { session_id: this.sessionId, message: content }
                );
            } catch (error) {
                if (error.status === 404 && this.conversationUuid) {
                    this.conversationUuid = null;
                    await this.ensureConversation();

                    return this.request(
                        `${config.conversationsUrl}/${this.conversationUuid}/messages`,
                        { session_id: this.sessionId, message: content }
                    );
                }

                throw error;
            }
        },

        detectHandoff(userContent, replyContent) {
            const needsHuman = /(talk to|speak to|talk with|human|agent|person|call me|reach you|pricing negotiation|negotiate)/i.test(userContent)
                && /(contact|call|team|reach|whatsapp|email|quote)/i.test(replyContent);

            if (needsHuman && ! this.lastReason) {
                this.lastReason = 'user_requested';

                this.messages.push({
                    id: this.newId(),
                    role: 'assistant',
                    content: 'Would you like me to pass you to a member of the SMEvolve team?',
                    handoff: true,
                });
            }
        },

        async requestHuman() {
            this.loading = true;
            this.error = null;

            try {
                const data = await this.request(config.handoffUrl, {
                    session_id: this.sessionId,
                    reason: this.lastReason || 'user_requested',
                });

                this.lastReason = null;

                this.messages.push({ id: this.newId(), role: 'assistant', content: data.message });

                const contacts = data.contact || {};

                if (contacts.phone || contacts.email || contacts.whatsapp) {
                    this.messages.push({
                        id: this.newId(),
                        role: 'assistant',
                        content: 'You can also reach us directly:',
                        contactOptions: contacts,
                    });
                }
            } catch (error) {
                this.error = error.message || 'Could not start the handoff. Please try again.';
            } finally {
                this.loading = false;
                this.scrollBottom();
            }
        },

        async request(url, body = {}) {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': config.csrfToken,
                },
                body: JSON.stringify(body),
            });

            let data = {};

            try {
                data = await response.json();
            } catch (e) {
                data = {};
            }

            if (! response.ok) {
                const error = new Error(data.message || 'Something went wrong. Please try again.');
                error.status = response.status;
                throw error;
            }

            return data;
        },

        async get(url) {
            const response = await fetch(url, {
                headers: { 'Accept': 'application/json' },
            });

            let data = {};

            try {
                data = await response.json();
            } catch (e) {
                data = {};
            }

            if (! response.ok) {
                const error = new Error(data.message || 'Request failed.');
                error.status = response.status;
                throw error;
            }

            return data;
        },

        resizeInput() {
            const el = this.$refs.input;
            if (! el) {
                return;
            }

            el.style.height = 'auto';
            el.style.height = `${Math.min(el.scrollHeight, 128)}px`;
        },

        focusInput() {
            this.$nextTick(() => this.$refs.input?.focus());
        },

        scrollBottom() {
            this.$nextTick(() => {
                const el = this.$refs.messages;
                if (el) {
                    el.scrollTop = el.scrollHeight;
                }
            });
        },

        newId() {
            if (window.crypto && typeof window.crypto.randomUUID === 'function') {
                return window.crypto.randomUUID();
            }

            return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, (c) => {
                const r = (Math.random() * 16) | 0;
                const v = c === 'x' ? r : (r & 0x3) | 0x8;
                return v.toString(16);
            });
        },

        storageGet(key) {
            try {
                return localStorage.getItem(key);
            } catch (e) {
                return null;
            }
        },

        storageSet(key, value) {
            try {
                localStorage.setItem(key, value);
            } catch (e) {}
        },
    }));

    Alpine.data('contactForm', () => ({
        submitting: false,

        init() {
            if (this.$el.dataset.hasErrors === '1') {
                this.track('contact_form:error');
            }
        },

        track(event, payload = {}) {
            window.SMEvolve.track(event, payload);
        },
    }));

    Alpine.data('mapLoader', () => ({
        loaded: false,

        load() {
            if (this.loaded) {
                return;
            }

            this.loaded = true;

            window.SMEvolve.track('map:load', {});
        },
    }));

    Alpine.data('quoteWizard', (config = {}) => ({
        aiEnabled: false,
        busy: false,
        error: null,
        suggestions: [],
        improvedDescription: null,
        clarifyingQuestions: [],

        init() {
            this.aiEnabled = config.aiEnabled === true;
        },

        async suggestFeatures() {
            if (! this.aiEnabled || this.busy) {
                return;
            }

            this.busy = true;
            this.error = null;

            try {
                const data = await this.post(config.suggestUrl, { session_id: config.sessionId });

                this.suggestions = Array.isArray(data.suggestions) ? data.suggestions : [];

                if (this.suggestions.length === 0) {
                    this.error = 'We could not think of feature suggestions for your description. Try adding a bit more detail.';
                }
            } catch (error) {
                this.error = error.message || 'AI assistance is unavailable right now.';
            } finally {
                this.busy = false;
            }
        },

        toggleSuggestion(key) {
            const input = document.querySelector(`input[name="required_features[]"][value="${key}"]`);

            if (input) {
                input.checked = ! input.checked;
            }
        },

        async improveDescription() {
            if (! this.aiEnabled || this.busy) {
                return;
            }

            this.busy = true;
            this.error = null;

            try {
                const data = await this.post(config.improveUrl, { session_id: config.sessionId });

                this.improvedDescription = data.description || null;
                this.clarifyingQuestions = Array.isArray(data.questions) ? data.questions : [];
            } catch (error) {
                this.error = error.message || 'AI assistance is unavailable right now.';
            } finally {
                this.busy = false;
            }
        },

        applyImprovedDescription() {
            const textarea = document.querySelector('textarea[name="project_description"]');

            if (textarea && this.improvedDescription) {
                textarea.value = this.improvedDescription;
                textarea.dispatchEvent(new Event('input', { bubbles: true }));
            }
        },

        track(event, payload = {}) {
            window.SMEvolve.track(event, payload);
        },

        async post(url, body = {}) {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': config.csrfToken,
                },
                body: JSON.stringify(body),
            });

            let data = {};

            try {
                data = await response.json();
            } catch (e) {
                data = {};
            }

            if (! response.ok) {
                const error = new Error(data.message || 'Something went wrong. Please try again.');
                error.status = response.status;
                throw error;
            }

            return data;
        },
    }));

    Alpine.data('faqSearch', () => ({
        items: window.FAQ_DATA || [],
        categories: window.FAQ_CATEGORIES || [],
        query: '',
        category: 'all',
        placeholderIndex: 0,
        placeholderTimer: null,

        suggestions: [
            'How much does a website cost?',
            'How long does development take?',
            'Do you offer support?',
            'Can I customise a package?',
            'Do you build mobile apps?',
        ],

        init() {
            this.items = window.FAQ_DATA || this.items;
            this.categories = window.FAQ_CATEGORIES || this.categories;

            this.placeholderTimer = setInterval(() => {
                if (this.query === '') {
                    this.placeholderIndex = (this.placeholderIndex + 1) % this.suggestions.length;
                }
            }, 3000);

            this.handleDeepLink();
        },

        handleDeepLink() {
            const questionId = new URLSearchParams(window.location.search).get('question');

            if (! questionId) {
                return;
            }

            this.$nextTick(() => {
                window.dispatchEvent(new CustomEvent('faq-toggle', {
                    detail: { group: 'faq-page', id: questionId },
                }));

                const trigger = document.getElementById('faq-trigger-' + questionId);

                if (trigger) {
                    trigger.scrollIntoView(smoothScroll({ behavior: 'smooth', block: 'center' }));
                }
            });
        },

        get placeholder() {
            return this.query !== ''
                ? 'Search for answers...'
                : this.suggestions[this.placeholderIndex];
        },

        get quickCategories() {
            const quick = ['pricing', 'services', 'development', 'support'];

            return this.categories.filter((category) => quick.includes(category.id));
        },

        matchesSearch(item) {
            const q = this.query.trim().toLowerCase();

            if (this.category !== 'all' && item.category !== this.category) {
                return false;
            }

            if (! q) {
                return true;
            }

            const haystack = [
                item.question,
                item.answer,
                item.category,
                (item.tags || []).join(' '),
            ].join(' ').toLowerCase();

            return haystack.includes(q);
        },

        get filtered() {
            return this.items.filter((item) => this.matchesSearch(item));
        },

        categoryCount(categoryId) {
            const category = this.categories.find((category) => category.id === categoryId);

            if (category && category.count !== undefined) {
                return category.count;
            }

            if (categoryId === 'all') {
                return this.items.length;
            }

            return this.items.filter((item) => item.category === categoryId).length;
        },

        selectCategory(categoryId) {
            if (this.category === categoryId) {
                return;
            }

            this.category = categoryId;
            this.resetAccordions();
            this.track('faq:category', { category: categoryId });
        },

        onSearchInput() {
            this.resetAccordions();
        },

        clearSearch() {
            this.query = '';
            this.resetAccordions();
            this.track('faq:search:clear');
        },

        focusSearch() {
            this.track('faq:search:focus');

            const input = document.getElementById('faq-search-input');

            if (! input) {
                return;
            }

            input.scrollIntoView(smoothScroll({ behavior: 'smooth', block: 'center' }));
            setTimeout(() => input.focus({ preventScroll: true }), 450);
        },

        resetAccordions() {
            window.dispatchEvent(new CustomEvent('faq-reset', {
                detail: { group: 'faq-page' },
            }));
        },

        track(event, payload = {}) {
            window.SMEvolve.track(event, payload);
        },
    }));

    Alpine.store('fab', {
        chatOpen: false,
        hubOpen: false,

        openChat() {
            this.chatOpen = true;
            this.hubOpen = false;
        },

        closeChat() {
            this.chatOpen = false;
        },

        openHub() {
            this.hubOpen = true;
            this.chatOpen = false;
        },

        closeHub() {
            this.hubOpen = false;
        },
    });

    Alpine.store('theme', {
        dark: false,

        init() {
            const stored = localStorage.getItem('theme');

            if (stored === 'dark') {
                this.dark = true;
            } else if (stored === 'light') {
                this.dark = false;
            } else {
                this.dark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            }

            this.apply();
        },

        toggle() {
            this.dark = ! this.dark;
            localStorage.setItem('theme', this.dark ? 'dark' : 'light');
            this.apply();
        },

        apply() {
            document.documentElement.classList.toggle('dark', this.dark);
        },
    });

    Alpine.data('adminSearchBox', (config = {}) => ({
        query: '',
        results: {},
        loading: false,
        error: false,
        open: false,
        highlightIndex: 0,
        flatResults: [],
        debounceTimer: null,
        minQueryLength: 2,
        actionUrl: '/admin/search/autocomplete',
        viewAllUrl: '/admin/search',
        placeholder: 'Search quotes, administrators, settings, knowledge...',

        init() {
            this.minQueryLength = parseInt(config.minQueryLength || '2', 10) || 2;
            this.actionUrl = config.actionUrl || this.actionUrl;
            this.viewAllUrl = config.viewAllUrl || this.viewAllUrl;
            this.placeholder = config.placeholder || this.placeholder;
        },

        get hasQuery() {
            return this.query.trim().length >= this.minQueryLength;
        },

        get groupKeys() {
            return Object.keys(this.results);
        },

        onInput() {
            this.error = false;
            const query = this.query.trim();

            if (query.length < this.minQueryLength) {
                this.open = query.length > 0;
                this.results = {};
                this.flatResults = [];
                return;
            }

            if (this.debounceTimer) {
                clearTimeout(this.debounceTimer);
            }

            this.debounceTimer = setTimeout(() => this.run(query), 250);
        },

        onFocus() {
            if (this.hasQuery) {
                this.open = true;
            }
        },

        async run(query) {
            this.loading = true;
            this.open = true;
            this.highlightIndex = 0;

            try {
                const response = await fetch(
                    this.actionUrl + '?q=' + encodeURIComponent(query),
                    { headers: { 'Accept': 'application/json' } }
                );

                if (! response.ok) {
                    throw new Error('search_failed');
                }

                const data = await response.json();

                if (this.query.trim() !== query) {
                    return;
                }

                this.results = data.results || {};
                this.flatResults = [];

                Object.keys(this.results).forEach((group) => {
                    this.results[group].forEach((item) => {
                        item._searchIndex = this.flatResults.length;
                        this.flatResults.push({ group, item });
                    });
                });
            } catch (e) {
                if (this.query.trim() === query) {
                    this.error = true;
                    this.results = {};
                    this.flatResults = [];
                }
            } finally {
                this.loading = false;
            }
        },

        move(direction) {
            if (this.flatResults.length === 0) {
                return;
            }

            this.highlightIndex = (this.highlightIndex + direction + this.flatResults.length) % this.flatResults.length;
        },

        select() {
            const target = this.flatResults[this.highlightIndex];

            if (target) {
                window.location.href = target.item.url;
                return;
            }

            if (this.query.trim() !== '') {
                window.location.href = this.viewAllLink();
            }
        },

        viewAllLink() {
            return this.query.trim() !== ''
                ? this.viewAllUrl + '?q=' + encodeURIComponent(this.query.trim())
                : this.viewAllUrl;
        },

        isHighlighted(index) {
            return this.highlightIndex === index;
        },

        focus() {
            this.$refs.input?.focus();
        },

        openOnSlash(event) {
            const tag = event.target.tagName;

            if (tag === 'INPUT' || tag === 'TEXTAREA' || tag === 'SELECT' || event.target.isContentEditable) {
                return;
            }

            if (event.key === '/') {
                event.preventDefault();
                this.focus();
            }
        },

        close() {
            this.open = false;
            this.highlightIndex = 0;
        },
    }));

    Alpine.data('siteSearchBox', (config = {}) => ({
        query: '',
        results: {},
        loading: false,
        error: false,
        open: false,
        highlightIndex: 0,
        flatResults: [],
        debounceTimer: null,
        minQueryLength: 2,
        enableShortcuts: true,
        actionUrl: '/search/autocomplete',
        viewAllUrl: '/search',
        placeholder: 'Search services, packages, FAQs...',

        init() {
            this.minQueryLength = parseInt(config.minQueryLength || '2', 10) || 2;
            this.enableShortcuts = config.enableShortcuts !== false;
            this.actionUrl = config.actionUrl || this.actionUrl;
            this.viewAllUrl = config.viewAllUrl || this.viewAllUrl;
            this.placeholder = config.placeholder || this.placeholder;
        },

        get hasQuery() {
            return this.query.trim().length >= this.minQueryLength;
        },

        get groupKeys() {
            return Object.keys(this.results);
        },

        onInput() {
            this.error = false;
            const query = this.query.trim();

            if (query.length < this.minQueryLength) {
                this.open = query.length > 0;
                this.results = {};
                this.flatResults = [];
                return;
            }

            if (this.debounceTimer) {
                clearTimeout(this.debounceTimer);
            }

            this.debounceTimer = setTimeout(() => this.run(query), 250);
        },

        onFocus() {
            if (this.hasQuery) {
                this.open = true;
            }
        },

        async run(query) {
            this.loading = true;
            this.open = true;
            this.highlightIndex = 0;

            try {
                const response = await fetch(
                    this.actionUrl + '?q=' + encodeURIComponent(query),
                    { headers: { 'Accept': 'application/json' } }
                );

                if (! response.ok) {
                    throw new Error('search_failed');
                }

                const data = await response.json();

                if (this.query.trim() !== query) {
                    return;
                }

                this.results = data.results || {};
                this.flatResults = [];

                Object.keys(this.results).forEach((group) => {
                    this.results[group].forEach((item) => {
                        item._searchIndex = this.flatResults.length;
                        this.flatResults.push({ group, item });
                    });
                });
            } catch (e) {
                if (this.query.trim() === query) {
                    this.error = true;
                    this.results = {};
                    this.flatResults = [];
                }
            } finally {
                this.loading = false;
            }
        },

        move(direction) {
            if (this.flatResults.length === 0) {
                return;
            }

            this.highlightIndex = (this.highlightIndex + direction + this.flatResults.length) % this.flatResults.length;
        },

        select() {
            const target = this.flatResults[this.highlightIndex];

            if (target) {
                window.location.href = target.item.url;
                return;
            }

            if (this.query.trim() !== '') {
                window.location.href = this.viewAllLink();
            }
        },

        viewAllLink() {
            return this.query.trim() !== ''
                ? this.viewAllUrl + '?q=' + encodeURIComponent(this.query.trim())
                : this.viewAllUrl;
        },

        isHighlighted(index) {
            return this.highlightIndex === index;
        },

        focus() {
            this.$refs.input?.focus();
        },

        openOnSlash(event) {
            if (! this.enableShortcuts) {
                return;
            }

            const tag = event.target.tagName;

            if (tag === 'INPUT' || tag === 'TEXTAREA' || tag === 'SELECT' || event.target.isContentEditable) {
                return;
            }

            if (event.key === '/') {
                event.preventDefault();
                this.focus();
            }
        },

        close() {
            this.open = false;
            this.highlightIndex = 0;
        },
    }));
});

Alpine.start();

window.__smEvents = window.__smEvents || [];

window.SMEvolve = {
    track(event, payload = {}) {
        const data = { event, ...payload };

        window.__smEvents.push(data);

        // Future integration point for analytics providers (e.g. GA4, Clarity).
        // No third-party network calls are made at this stage.
    },
};

document.addEventListener('click', (event) => {
    const target = event.target.closest('[data-track]');

    if (! target) {
        return;
    }

    let payload = {};

    if (target.dataset.trackData) {
        try {
            payload = JSON.parse(target.dataset.trackData);
        } catch {
            payload = {};
        }
    }

    window.SMEvolve.track(target.dataset.track, payload);
});
