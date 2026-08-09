<x-layouts.admin-auth :title="'Reset Password'">
    <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-card dark:border-slate-800 dark:bg-slate-900">
        <h1 class="text-xl font-semibold text-slate-900 dark:text-slate-100">Reset your password</h1>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Choose a new password for your SMEvolve administrator account.</p>

        @if ($errors->any())
            <div class="mt-5 flex items-start gap-3 rounded-xl border border-error-500/30 bg-error-500/10 px-4 py-3 text-sm text-error-700 dark:text-error-500">
                <x-icon name="exclamation-triangle" class="mt-0.5 h-5 w-5 shrink-0" />
                <div class="space-y-1">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.password.reset.store') }}" class="mt-6 space-y-5">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div>
                <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    required
                    autofocus
                    autocomplete="email"
                    value="{{ old('email', $email) }}"
                    class="mt-1.5 w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 shadow-sm transition placeholder:text-slate-400 focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:placeholder:text-slate-500"
                >
            </div>

            <div>
                <x-forms.password-input
                    name="password"
                    label="New password"
                    autocomplete="new-password"
                    :required="true"
                />
            </div>

            <div>
                <x-forms.password-input
                    name="password_confirmation"
                    label="Confirm new password"
                    autocomplete="new-password"
                    :required="true"
                />
            </div>

            <button
                type="submit"
                class="w-full rounded-xl bg-primary-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-primary-600/25 transition hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500/40"
            >
                Reset password
            </button>
        </form>

        <p class="mt-6 text-center text-xs text-slate-400 dark:text-slate-500">
            Secured by SMEvolve &middot; {{ date('Y') }}
        </p>
    </div>
</x-layouts.admin-auth>
