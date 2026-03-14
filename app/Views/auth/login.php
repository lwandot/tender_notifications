<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="flex flex-1 flex-col md:flex-row w-full">
    <!-- Main Content Area -->
    <section class="flex-1 p-6 md:p-10 space-y-8">
        <div class="max-w-md mx-auto">
            <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 p-8 shadow-sm">
                <div class="text-center mb-8">
                    <div class="bg-primary text-white p-3 rounded-lg flex items-center justify-center w-fit mx-auto mb-4">
                        <span class="material-symbols-outlined text-2xl">login</span>
                    </div>
                    <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Welcome Back</h1>
                    <p class="text-slate-500 dark:text-slate-400 mt-2">Sign in to your account</p>
                </div>

                <?php if (isset($error)): ?>
                    <div class="rounded-lg bg-rose-50 border border-rose-200 px-4 py-3 text-rose-800 mb-6">
                        <?= esc($error) ?>
                    </div>
                <?php endif; ?>

                <form method="post" action="/auth/login" class="space-y-6">
                    <?= csrf_field() ?>

                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Email Address
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            required
                            class="block w-full px-4 py-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent text-slate-900 dark:text-white placeholder:text-slate-400"
                            placeholder="Enter your email"
                        >
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Password
                        </label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            required
                            class="block w-full px-4 py-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent text-slate-900 dark:text-white placeholder:text-slate-400"
                            placeholder="Enter your password"
                        >
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-primary text-white py-3 px-4 rounded-lg font-bold hover:bg-primary/90 transition-colors flex items-center justify-center gap-2"
                    >
                        <span class="material-symbols-outlined text-sm">login</span>
                        Sign In
                    </button>
                </form>

                <div class="mt-8 pt-6 border-t border-slate-100 dark:border-slate-800">
                    <p class="text-center text-slate-500 dark:text-slate-400">
                        Don't have an account?
                        <a href="/auth/register" class="text-primary hover:underline font-medium">Create one here</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
</div>

<?= $this->endSection() ?>
