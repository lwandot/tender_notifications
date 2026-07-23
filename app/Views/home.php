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
            <button type="button" class="filter-toggle group flex items-center justify-between px-3 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 w-full text-left <?= isset($filters['category']) ? 'bg-slate-100 dark:bg-slate-800' : '' ?>">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined">folder</span>
                    <span class="text-sm font-semibold">Category</span>
                </div>
                <span class="material-symbols-outlined chevron-icon text-sm transition-transform">chevron_right</span>
            </button>
            <?php if (!empty($categories) && is_array($categories)): ?>
                <div class="filter-content space-y-1 px-2 hidden">
                    <?php foreach ($categories as $category): ?>
                        <?php $active = isset($filters['category']) && $filters['category'] === $category; ?>
                        <a href="/?category=<?= rawurlencode($category['name']) ?>" class="block px-3 py-2 rounded-lg text-sm <?= $active ? 'bg-primary/10 text-primary font-semibold' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' ?>"><?= esc($category['name']) ?></a>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="px-3 py-2 rounded-lg text-sm text-slate-500 dark:text-slate-400">No categories available</div>
            <?php endif; ?>

            <button type="button" class="filter-toggle group flex items-center justify-between px-3 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 w-full text-left <?= isset($filters['organ']) ? 'bg-slate-100 dark:bg-slate-800' : '' ?>">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined">account_balance</span>
                    <span class="text-sm font-medium">Organ of State</span>
                </div>
                <span class="material-symbols-outlined chevron-icon text-sm transition-transform">chevron_right</span>
            </button>
            <?php if (!empty($organs) && is_array($organs)): ?>
                <div class="filter-content space-y-1 px-2 hidden">
                    <?php foreach ($organs as $organ): ?>
                        <?php $active = isset($filters['organ']) && $filters['organ'] === $organ; ?>
                        <a href="/?organ=<?= rawurlencode($organ['name']) ?>" class="block px-3 py-2 rounded-lg text-sm <?= $active ? 'bg-primary/10 text-primary font-semibold' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' ?>"><?= esc($organ['name']) ?></a>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="px-3 py-2 rounded-lg text-sm text-slate-500 dark:text-slate-400">No organs of state available</div>
            <?php endif; ?>

            <button type="button" class="filter-toggle group flex items-center justify-between px-3 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 w-full text-left <?= isset($filters['province']) ? 'bg-slate-100 dark:bg-slate-800' : '' ?>">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined">map</span>
                    <span class="text-sm font-medium">Province</span>
                </div>
                <span class="material-symbols-outlined chevron-icon text-sm transition-transform">chevron_right</span>
            </button>
            <?php if (!empty($provinces) && is_array($provinces)): ?>
                <div class="filter-content space-y-1 px-2 hidden">
                    <?php foreach ($provinces as $province): ?>
                        <?php $active = isset($filters['province']) && $filters['province'] === $province; ?>
                        <a href="/?province=<?= rawurlencode($province['name']) ?>" class="block px-3 py-2 rounded-lg text-sm <?= $active ? 'bg-primary/10 text-primary font-semibold' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' ?>"><?= esc($province['name']) ?></a>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="px-3 py-2 rounded-lg text-sm text-slate-500 dark:text-slate-400">No provinces available</div>
            <?php endif; ?>
        </nav>

        <script>
            (function(){
                document.querySelectorAll('.filter-toggle').forEach(function(btn){
                    btn.addEventListener('click', function(){
                        var content = btn.nextElementSibling;
                        if(!content) return;
                        var icon = btn.querySelector('.chevron-icon');
                        content.classList.toggle('hidden');
                        btn.classList.toggle('bg-slate-100', !content.classList.contains('hidden'));
                        btn.classList.toggle('dark:bg-slate-800', !content.classList.contains('hidden'));
                        if(icon) icon.textContent = content.classList.contains('hidden') ? 'chevron_right' : 'expand_more';
                    });
                });
            })();
        </script>

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
        <!-- Main Content Panel -->
    <section class="flex-1 p-6 md:p-10 space-y-8">
        <!-- Banner introducing Subscribe notifications -->
        <div class="bg-gradient-to-r from-primary to-indigo-700 text-white rounded-xl p-6 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div class="space-y-1">
                <span class="bg-white/20 text-[10px] sm:text-xs uppercase tracking-wider font-bold px-2.5 py-0.5 rounded-full inline-flex items-center gap-1">
                    🟢 Instant Whatsapp Updates Enabled
                </span>
                <h3 class="text-lg font-bold">Receive active State Tenders straight on your phone!</h3>
                <p class="text-xs text-indigo-100">Setup personalized alert digests. Filter multiple categories, provinces and state organs (Starts from R29.00/mo).</p>
            </div>
            <a href="<?= base_url('subscription') ?>" class="bg-white text-primary text-xs font-bold py-2.5 px-4 rounded-lg shadow-sm hover:bg-indigo-50 active:scale-95 transition-all shrink-0">
                Setup Live Alerts
            </a>
        </div>
        
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

        <!-- API Debug Output (toggle) -->
        <div class="max-w-3xl">
            <button id="apiDebugToggle" type="button" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-slate-100 dark:bg-slate-800 text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-200 dark:hover:bg-slate-700">
                <span class="material-symbols-outlined">visibility</span>
                <span>Show API request/response</span>
            </button>

            <div id="apiDebugPanel" class="mt-4 hidden rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 p-4">
                <div class="flex items-start justify-between gap-4">
                    <div class="space-y-2">
                        <h3 class="text-sm font-semibold text-slate-900 dark:text-white">API request</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 break-words"><code><?= esc($requestUrl ?? 'N/A') ?></code></p>
                    </div>
                    <button id="apiDebugClose" type="button" class="text-slate-500 hover:text-slate-800 dark:hover:text-white text-sm">Hide</button>
                </div>

                <div class="mt-4">
                    <h4 class="text-sm font-semibold text-slate-900 dark:text-white">API response</h4>
                    <pre class="mt-2 max-h-64 overflow-y-auto rounded-lg bg-slate-50 dark:bg-slate-900 p-3 text-xs text-slate-700 dark:text-slate-200">
<?= esc(json_encode($rawApiResponse ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) ?: 'No API response' ?>
                    </pre>
                </div>
            </div>
        </div>

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
                        $tenderTitle = $tender['organ_of_state'] ?? 'Untitled Organ of State';
                        $procurementEntity = $tender['procuring_entity']['name'] ?? 'Untitled Tender'; 
                        $tenderNumber = $tender['title'] ?? ($tender['tender_number'] ?? 'N/A');
                        $tenderStatus = isset($tender['status']) ? strtolower($tender['status']) : 'active';
                        $statusClass = match($tenderStatus) {
                            'active' => 'bg-green-500 text-white ',
                            'closed' => 'bg-red-500 text-white ',
                            'cancelled' => 'bg-gray-500 text-white ',
                            default => 'bg-blue-500 text-white ',
                        };
                        $description = ucfirst(strtolower($tender['description'])) ?? 'No description available.';
                        $categories = is_array($tender['category']) ? implode(', ', $tender['category']) : ($tender['category'] ?? 'N/A');
                        $daysLeft = isset($tender['closing_date']) ? ceil((strtotime($tender['closing_date']) - time()) / (60 * 60 * 24)) : 'N/A';
                        ?>

                        <div class="group relative flex flex-col md:flex-row md:items-center gap-6 bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-primary/50 transition-all shadow-sm hover:shadow-md">
                            <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-primary/10 text-primary shrink-0">
                                <span class="material-symbols-outlined text-2xl">description</span>
                            </div>
                            <div class="flex-1 space-y-1">
                                <div class="flex flex-wrap items-center gap-2 mb-1">
                                    <span class="text-xs font-bold uppercase tracking-wider text-primary bg-primary/10 px-2 py-0.5 rounded"><?= esc($tenderNumber) ?></span>
                                    <span class="text-xs font-medium text-slate-400">Published <?= esc($publishedAt) ?></span>
                                    <span class="ml-auto text-xs font-bold uppercase tracking-wider px-2 py-0.5 rounded <?= $statusClass ?>"><?= esc(ucfirst($tenderStatus)) ?></span>
                                </div>
                                <h3 class="text-lg font-bold text-slate-900 dark:text-white group-hover:text-primary transition-colors">
                                    <a href="/tender/view/<?= esc($tender['ocid'] ?? '') ?>">
                                        <?= esc(mb_strimwidth($procurementEntity, 0, 80, '...')) ?>
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
                                    <div class="flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-base">folder</span>
                                        <span>Category: <?= esc($categories) ?></span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-base">schedule</span>
                                        <span>Start: <?= esc($publishedAt) ?></span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-base">timer</span>
                                        <span>Days left: <?= esc($daysLeft) ?></span>
                                    </div>
                                </div>
                                <?php if (!empty($description)): ?>
                                <div class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                                    <p class="line-clamp-2"><?= esc(mb_strimwidth($description, 0, 150, '...')) ?></p>
                                </div>
                                <?php endif; ?>
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

(function () {
    const toggleBtn = document.getElementById('apiDebugToggle');
    const closeBtn = document.getElementById('apiDebugClose');
    const panel = document.getElementById('apiDebugPanel');

    function setPanelVisibility(visible) {
        if (!panel || !toggleBtn) return;
        panel.classList.toggle('hidden', !visible);
        const label = toggleBtn.querySelector('span:last-child');
        if (label) {
            label.textContent = visible ? 'Hide API request/response' : 'Show API request/response';
        }
    }

    function init() {
        if (!toggleBtn) return;
        toggleBtn.addEventListener('click', () => setPanelVisibility(panel.classList.contains('hidden')));

        if (closeBtn) {
            closeBtn.addEventListener('click', () => setPanelVisibility(false));
        }
    }

    if (document.readyState !== 'loading') {
        init();
    } else {
        document.addEventListener('DOMContentLoaded', init);
    }
})();
</script>
<?= $this->endSection() ?>
