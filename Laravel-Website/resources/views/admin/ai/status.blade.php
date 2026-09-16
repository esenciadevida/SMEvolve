<x-layouts.admin-portal :title="'AI Status'">
    <div class="mb-6">
        <h1 class="text-xl font-semibold">AI Status</h1>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Diagnostic overview of the AI service.</p>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @php
            $cards = [
                ['label' => 'AI Enabled', 'value' => $aiEnabled ? 'Yes' : 'No'],
                ['label' => 'Assistant', 'value' => $assistantEnabled ? 'Active' : 'Disabled'],
                ['label' => 'Quote Analysis', 'value' => $quoteEnabled ? 'Active' : 'Disabled'],
                ['label' => 'Provider', 'value' => $provider],
                ['label' => 'Model', 'value' => $model],
                ['label' => 'Provider Key', 'value' => $configured ? 'Configured' : 'Missing', 'warn' => ! $configured],
                ['label' => 'Last Check', 'value' => $lastCheckAt->format('M j, Y H:i')],
            ];
        @endphp
        @foreach ($cards as $card)
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <p class="text-sm text-slate-500 dark:text-slate-400">{{ $card['label'] }}</p>
                <p class="mt-1 text-lg font-semibold {{ ! empty($card['warn']) ? 'text-warning-600' : '' }}">{{ $card['value'] }}</p>
            </div>
        @endforeach
    </div>

    @if (session('status'))
        <div class="mt-4 rounded-lg border border-success-500/30 bg-success-500/10 px-4 py-3 text-sm text-success-700 dark:text-success-500">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->has('check'))
        <div class="mt-4 rounded-lg border border-error-500/30 bg-error-500/10 px-4 py-3 text-sm text-error-700 dark:text-error-500">
            {{ $errors->first('check') }}
        </div>
    @endif

    <div class="mt-6">
        <form method="POST" action="{{ route('admin.ai.check') }}">
            @csrf
            <button type="submit" class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white hover:bg-primary-700">
                Run live connection check
            </button>
        </form>
        <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">Sends a real (costing) request to {{ $provider }} to verify the configured model works.</p>
    </div>
</x-layouts.admin-portal>
