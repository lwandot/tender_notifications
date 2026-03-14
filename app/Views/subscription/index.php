<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="flex flex-1 flex-col md:flex-row w-full">
    <!-- Main Content Area -->
    <section class="flex-1 p-6 md:p-10 space-y-8">
        <div class="max-w-6xl mx-auto">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">My Subscriptions</h1>
                    <p class="text-slate-500 dark:text-slate-400">Manage your tender notification preferences</p>
                </div>
                <a
                    href="/subscription/create"
                    class="bg-primary text-white py-3 px-6 rounded-lg font-bold hover:bg-primary/90 transition-colors flex items-center gap-2"
                >
                    <span class="material-symbols-outlined text-sm">add</span>
                    New Subscription
                </a>
            </div>

            <?php if (empty($subscriptions)): ?>
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-8 text-center">
                    <div class="bg-blue-100 dark:bg-blue-800/50 text-blue-600 dark:text-blue-400 p-3 rounded-lg flex items-center justify-center w-fit mx-auto mb-4">
                        <span class="material-symbols-outlined text-2xl">notifications</span>
                    </div>
                    <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-2">No Active Subscriptions</h3>
                    <p class="text-blue-700 dark:text-blue-300 mb-6">
                        You don't have any active subscriptions yet. Create one to get notified about new tenders.
                    </p>
                    <a
                        href="/subscription/create"
                        class="inline-flex items-center gap-2 bg-blue-600 text-white py-3 px-6 rounded-lg font-bold hover:bg-blue-700 transition-colors"
                    >
                        <span class="material-symbols-outlined text-sm">add</span>
                        Create Your First Subscription
                    </a>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($subscriptions as $sub): ?>
                        <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 p-6 shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-1">
                                        <?php
                                        if ($sub['filter_type'] == 'category') {
                                            echo 'Category Subscription';
                                        } elseif ($sub['filter_type'] == 'province') {
                                            echo 'Province Filter';
                                        } elseif ($sub['filter_type'] == 'organ_of_state') {
                                            echo 'Organ of State Filter';
                                        } else {
                                            echo 'Tender Subscription';
                                        }
                                        ?>
                                    </h3>
                                    <p class="text-sm text-slate-500 dark:text-slate-400">
                                        Created <?= date('M d, Y', strtotime($sub['created_at'])) ?>
                                    </p>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $sub['is_active'] ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-400' : 'bg-slate-100 text-slate-800 dark:bg-slate-800 dark:text-slate-400' ?>">
                                    <?= $sub['is_active'] ? 'Active' : 'Inactive' ?>
                                </span>
                            </div>

                            <div class="space-y-3 mb-6">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm text-slate-400">notifications</span>
                                    <span class="text-sm text-slate-600 dark:text-slate-400">
                                        <?= ucfirst($sub['notification_type']) ?> notifications
                                    </span>
                                </div>
                            </div>

                            <form method="post" action="/subscription/delete/<?= $sub['id'] ?>" onsubmit="return confirm('Are you sure you want to cancel this subscription?');">
                                <?= csrf_field() ?>
                                <button
                                    type="submit"
                                    class="w-full bg-rose-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-rose-700 transition-colors flex items-center justify-center gap-2"
                                >
                                    <span class="material-symbols-outlined text-sm">delete</span>
                                    Cancel Subscription
                                </button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>

<?= $this->endSection() ?>
