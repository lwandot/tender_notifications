<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="flex flex-1 flex-col md:flex-row w-full">
    <!-- Sidebar / Filters -->
    <aside class="w-full md:w-72 border-r border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 space-y-8 h-full">
        <div>
            <h1 class="text-slate-900 dark:text-white text-lg font-bold mb-1">Filters</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm">Refine your tender search</p>
        </div>

        <nav class="space-y-2">
            <div class="group flex items-center justify-between px-3 py-2.5 rounded-lg bg-primary/10 text-primary cursor-pointer">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined">folder</span>
                    <span class="text-sm font-semibold">Category</span>
                </div>
                <span class="material-symbols-outlined text-sm">expand_more</span>
            </div>
            <div class="group flex items-center justify-between px-3 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 cursor-pointer">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined">account_balance</span>
                    <span class="text-sm font-medium">Organ of State</span>
                </div>
                <span class="material-symbols-outlined text-sm">chevron_right</span>
            </div>
            <div class="group flex items-center justify-between px-3 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 cursor-pointer">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined">map</span>
                    <span class="text-sm font-medium">Province</span>
                </div>
                <span class="material-symbols-outlined text-sm">chevron_right</span>
            </div>
        </nav>

        <div class="pt-6 border-t border-slate-100 dark:border-slate-800">
            <h3 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-4">Saved Searches</h3>
            <div class="space-y-3">
                <div class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400 hover:text-primary cursor-pointer">
                    <span class="material-symbols-outlined text-xs">history</span>
                    <span>Medical Supplies 2024</span>
                </div>
                <div class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400 hover:text-primary cursor-pointer">
                    <span class="material-symbols-outlined text-xs">history</span>
                    <span>IT Infrastructure</span>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <section class="flex-1 p-6 md:p-10 space-y-8">
        <!-- Search Bar -->
        <form method="get" action="/" class="max-w-3xl">
            <label class="relative block group">
                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400 group-focus-within:text-primary">
                    <span class="material-symbols-outlined">search</span>
                </div>
                <input
                    name="search"
                    id="searchInput"
                    type="text"
                    value="<?= isset($filters['search']) ? esc($filters['search']) : '' ?>"
                    placeholder="Search tenders by number, title or keyword"
                    class="block w-full h-14 pl-12 pr-4 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-slate-900 dark:text-white placeholder:text-slate-400 shadow-sm"
                />
            </label>
        </form>

        <!-- Content List -->
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Active Tenders</h2>
                <div class="flex items-center gap-2 text-sm text-slate-500">
                    <span>Showing <?= $total ?> results</span>
                    <span class="material-symbols-outlined">sort</span>
                </div>
            </div>

            <?php if (!empty($tenders)): ?>
                <div class="grid gap-4">
                    <?php foreach ($tenders as $tender): ?>
                        <?php
                        $organName = $tender['organ_of_state']['name'] ?? $tender['organ_of_state'] ?? 'Unknown';
                        $provinceName = $tender['province']['name'] ?? $tender['province'] ?? 'Unknown';
                        $publishedAt = isset($tender['published_date']) ? date('j M Y', strtotime($tender['published_date'])) : 'Unknown';
                        $closingAt = isset($tender['closing_date']) ? date('j M Y', strtotime($tender['closing_date'])) : 'TBD';
                        $tenderTitle = $tender['title'] ?? 'Untitled Tender';
                        $tenderNumber = $tender['tender_number'] ?? ($tender['ocid'] ?? 'N/A');
                        $tenderStatus = isset($tender['status']) ? strtolower($tender['status']) : 'active';
                        ?>

                        <div class="group relative flex flex-col md:flex-row md:items-center gap-6 bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-primary/50 transition-all shadow-sm hover:shadow-md">
                            <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-primary/10 text-primary shrink-0">
                                <span class="material-symbols-outlined text-2xl">description</span>
                            </div>
                            <div class="flex-1 space-y-1">
                                <div class="flex flex-wrap items-center gap-2 mb-1">
                                    <span class="text-xs font-bold uppercase tracking-wider text-primary bg-primary/10 px-2 py-0.5 rounded"><?= esc($tenderNumber) ?></span>
                                    <span class="text-xs font-medium text-slate-400">Published <?= esc($publishedAt) ?></span>
                                </div>
                                <h3 class="text-lg font-bold text-slate-900 dark:text-white group-hover:text-primary transition-colors">
                                    <a href="/tender/view/<?= esc($tender['ocid'] ?? '') ?>">
                                        <?= esc(mb_strimwidth($tenderTitle, 0, 80, '...')) ?>
                                    </a>
                                </h3>
                                <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-sm text-slate-600 dark:text-slate-400">
                                    <div class="flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-base">account_balance</span>
                                        <span><?= esc($organName) ?></span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-base">location_on</span>
                                        <span><?= esc($provinceName) ?></span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-base">event</span>
                                        <span>Closing: <?= esc($closingAt) ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <button class="p-2 text-slate-400 hover:text-primary rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800" aria-label="Bookmark">
                                    <span class="material-symbols-outlined">bookmark</span>
                                </button>
                                <a href="/tender/view/<?= esc($tender['ocid'] ?? '') ?>" class="text-slate-300 group-hover:translate-x-1 transition-transform">
                                    <span class="material-symbols-outlined">chevron_right</span>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination -->
                <div class="flex items-center justify-center pt-8">
                    <nav class="flex items-center gap-1">
                        <?php
                        $totalPages = max(1, ceil($total / $perPage));
                        $startPage = max(1, $page - 2);
                        $endPage = min($totalPages, $page + 2);
                        ?>
                        <button class="w-10 h-10 flex items-center justify-center rounded-lg border border-slate-200 dark:border-slate-800 text-slate-600 hover:bg-slate-100 dark:hover:bg-slate-800" <?= $page <= 1 ? 'disabled' : '' ?> onclick="location.href='/?page=<?= max(1, $page-1) ?>'">
                            <span class="material-symbols-outlined">chevron_left</span>
                        </button>
                        <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                            <button class="w-10 h-10 flex items-center justify-center rounded-lg <?= $i == $page ? 'bg-primary text-white' : 'border border-slate-200 dark:border-slate-800 text-slate-600 hover:bg-slate-100 dark:hover:bg-slate-800' ?>" onclick="location.href='/?page=<?= $i ?>'">
                                <?= $i ?>
                            </button>
                        <?php endfor; ?>
                        <button class="w-10 h-10 flex items-center justify-center rounded-lg border border-slate-200 dark:border-slate-800 text-slate-600 hover:bg-slate-100 dark:hover:bg-slate-800" <?= $page >= $totalPages ? 'disabled' : '' ?> onclick="location.href='/?page=<?= min($totalPages, $page+1) ?>'">
                            <span class="material-symbols-outlined">chevron_right</span>
                        </button>
                    </nav>
                </div>
            <?php else: ?>
                <div class="no-results">
                    <span class="material-symbols-outlined text-6xl text-slate-400">inbox</span>
                    <h4 class="mt-4 text-xl font-semibold text-slate-900 dark:text-white">No tenders found</h4>
                    <p class="mt-2 text-slate-500 dark:text-slate-400">Try adjusting your search filters or browse all available tenders.</p>
                    <a href="/" class="mt-4 inline-flex items-center justify-center rounded-lg bg-primary px-6 py-3 text-sm font-bold text-white hover:bg-primary/90">
                        View All Tenders
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function subscribeTender(tenderId) {
    window.location.href = '/subscription/create?ocid=' + tenderId;
}
</script>
<?= $this->endSection() ?>
