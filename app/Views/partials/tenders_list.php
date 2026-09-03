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
                        <a href="<?= base_url('tender/view/' . esc($tender['ocid'] ?? '')) ?>">
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
                    <a href="<?= base_url('tender/view/' . esc($tender['ocid'] ?? '')) ?>" class="text-slate-300 group-hover:translate-x-1 transition-transform">
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
            <button class="w-10 h-10 flex items-center justify-center rounded-lg border border-slate-200 dark:border-slate-800 text-slate-600 hover:bg-slate-100 dark:hover:bg-slate-800" <?= $page <= 1 ? 'disabled' : '' ?> onclick="fetchTenders({page:<?= max(1, $page-1) ?>})">
                <span class="material-symbols-outlined">chevron_left</span>
            </button>
            <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                <button class="w-10 h-10 flex items-center justify-center rounded-lg <?= $i == $page ? 'bg-primary text-white' : 'border border-slate-200 dark:border-slate-800 text-slate-600 hover:bg-slate-100 dark:hover:bg-slate-800' ?>" onclick="fetchTenders({page:<?= $i ?>})">
                    <?= $i ?>
                </button>
            <?php endfor; ?>
            <button class="w-10 h-10 flex items-center justify-center rounded-lg border border-slate-200 dark:border-slate-800 text-slate-600 hover:bg-slate-100 dark:hover:bg-slate-800" <?= $page >= $totalPages ? 'disabled' : '' ?> onclick="fetchTenders({page:<?= min($totalPages, $page+1) ?>})">
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
