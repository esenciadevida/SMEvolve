<x-layouts.admin-portal :title="'Chatbot Analytics'">
    <x-admin.page-header title="Chatbot Analytics" subtitle="Conversation and handoff activity for the AI assistant." />

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <x-admin.stat-card label="Conversations" :value="number_format($chatbot['conversations'])" icon="chat-bubble-left-right" tone="primary" />
        <x-admin.stat-card label="Messages" :value="number_format($chatbot['messages'])" icon="chat-bubble-oval-left-ellipsis" tone="info" />
        <x-admin.stat-card label="User Messages" :value="number_format($chatbot['user_messages'] ?? $chatbot['messages'])" icon="arrow-up-right" tone="secondary" />
        <x-admin.stat-card label="Handoffs" :value="number_format($chatbot['handoffs'])" icon="arrow-right-circle" tone="warning" />
    </div>

    <div class="mt-6">
        <x-admin.card title="About this data" subtitle="What is tracked">
            <ul class="list-inside list-disc space-y-1.5 text-sm text-slate-600 dark:text-slate-400">
                <li>Conversations and messages created through the public AI assistant.</li>
                <li>Handoffs requested when the assistant escalates to the SMEvolve team.</li>
                <li>Detailed per-message token and latency analytics live under AI Analytics and the AI console Usage page.</li>
            </ul>
        </x-admin.card>
    </div>
</x-layouts.admin-portal>
