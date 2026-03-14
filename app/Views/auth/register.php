<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="flex flex-1 flex-col md:flex-row w-full">
    <!-- Main Content Area -->
    <section class="flex-1 p-6 md:p-10 space-y-8">
        <div class="max-w-md mx-auto">
            <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 p-8 shadow-sm">
                <div class="text-center mb-8">
                    <div class="bg-primary text-white p-3 rounded-lg flex items-center justify-center w-fit mx-auto mb-4">
                        <span class="material-symbols-outlined text-2xl">person_add</span>
                    </div>
                    <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Create Account</h1>
                    <p class="text-slate-500 dark:text-slate-400 mt-2">Join GovTenders to get started</p>
                </div>

                <?php if (isset($errors)): ?>
                    <div class="rounded-lg bg-rose-50 border border-rose-200 px-4 py-3 text-rose-800 mb-6">
                        <ul class="list-disc list-inside">
                            <?php foreach ($errors as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="post" action="/auth/register" class="space-y-6">
                    <?= csrf_field() ?>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="firstName" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                First Name
                            </label>
                            <input
                                type="text"
                                id="firstName"
                                name="first_name"
                                required
                                class="block w-full px-4 py-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent text-slate-900 dark:text-white placeholder:text-slate-400"
                                placeholder="First name"
                            >
                        </div>
                        <div>
                            <label for="lastName" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Last Name
                            </label>
                            <input
                                type="text"
                                id="lastName"
                                name="last_name"
                                required
                                class="block w-full px-4 py-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent text-slate-900 dark:text-white placeholder:text-slate-400"
                                placeholder="Last name"
                            >
                        </div>
                    </div>

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
                        <label for="organization" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Organization <span class="text-slate-400">(Optional)</span>
                        </label>
                        <input
                            type="text"
                            id="organization"
                            name="organization"
                            class="block w-full px-4 py-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent text-slate-900 dark:text-white placeholder:text-slate-400"
                            placeholder="Your organization"
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
                            placeholder="Create a password"
                        >
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                            Must be at least 8 characters with uppercase, lowercase, numbers, and symbols
                        </p>
                    </div>

                    <div>
                        <label for="passwordConfirm" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Confirm Password
                        </label>
                        <input
                            type="password"
                            id="passwordConfirm"
                            name="password_confirm"
                            required
                            class="block w-full px-4 py-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent text-slate-900 dark:text-white placeholder:text-slate-400"
                            placeholder="Confirm your password"
                        >
                    </div>

                    <div class="flex items-start gap-3">
                        <input
                            type="checkbox"
                            id="terms"
                            name="terms"
                            required
                            class="mt-1 h-4 w-4 text-primary border-slate-200 dark:border-slate-800 rounded focus:ring-primary"
                        >
                        <label for="terms" class="text-sm text-slate-700 dark:text-slate-300">
                            I agree to the <a href="#" class="text-primary hover:underline">Terms of Service</a>
                        </label>
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-primary text-white py-3 px-4 rounded-lg font-bold hover:bg-primary/90 transition-colors flex items-center justify-center gap-2"
                    >
                        <span class="material-symbols-outlined text-sm">person_add</span>
                        Create Account
                    </button>
                </form>

                <div class="mt-8 pt-6 border-t border-slate-100 dark:border-slate-800">
                    <p class="text-center text-slate-500 dark:text-slate-400">
                        Already have an account?
                        <a href="/auth/login" class="text-primary hover:underline font-medium">Sign in here</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
</div>

<?= $this->endSection() ?>
