<main class="flex flex-1 flex-col md:flex-row max-w-[1440px] mx-auto w-full">
    <!-- Sidebar Filters Form (Submitted via GET to filter listing) -->
    <aside class="w-full md:w-72 border-r border-slate-200 bg-white p-6 space-y-8 h-full min-h-[calc(100vh-73px)]">
        <div>
            <h1 class="text-slate-900 text-lg font-bold mb-1">Filters</h1>
            <p class="text-slate-500 text-sm">Refine your tender search</p>
        </div>

        <form action="<?= base_url('/') ?>" method="get" class="space-y-6">
            <!-- Category Expandable List -->
            <div class="space-y-2">
                <div onclick="toggleSection('category')" class="flex items-center justify-between px-3 py-2.5 rounded-lg bg-primary/10 text-primary cursor-pointer hover:bg-primary/20 transition-colors">
                    <div class="flex items-center gap-3">
                        <i data-lucide="folder" class="w-5 h-5"></i>
                        <span class="text-sm font-semibold">Category</span>
                    </div>
                    <i data-lucide="chevron-up" class="w-4 h-4 transition-transform duration-200" id="category-chevron"></i>
                </div>
                
                <div id="category-list" class="px-4 space-y-3 mt-3">
                    <?php if (!empty($categories)): ?>
                        <?php foreach($categories as $category): ?>
                            <label class="flex items-start gap-3 cursor-pointer group">
                                <input type="checkbox" name="categories[]" value="<?= esc($category['name']) ?>" class="rounded border-slate-300 text-primary focus:ring-primary h-4 w-4 mt-0.5">
                                <div class="text-sm text-slate-600 group-hover:text-slate-900 transition-colors">
                                    <p class="font-medium"><?= esc($category['name']) ?></p>
                                    <?php if(!empty($category['sub_categories'])): ?>
                                        <p class="text-[10px] text-slate-400 font-mono"><?= implode(', ', json_decode($category['sub_categories'])) ?></p>
                                    <?php endif; ?>
                                </div>
                            </label>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Organ of State Expandable List -->
            <div class="space-y-2">
                <div onclick="toggleSection('organ')" class="flex items-center justify-between px-3 py-2.5 rounded-lg text-slate-600 hover:bg-slate-50 cursor-pointer transition-colors">
                    <div class="flex items-center gap-3">
                        <i data-lucide="landmark" class="w-5 h-5"></i>
                        <span class="text-sm font-medium">Organ of State</span>
                    </div>
                    <i data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-200" id="organ-chevron"></i>
                </div>
                
                <div id="organ-list" class="px-4 space-y-3 mt-3 hidden">
                    <?php if (!empty($organs)): ?>
                        <?php foreach($organs as $organ): ?>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" name="organs[]" value="<?= esc($organ['name']) ?>" class="rounded border-slate-300 text-primary focus:ring-primary h-4 w-4">
                                <span class="text-sm text-slate-600 group-hover:text-slate-900 transition-colors"><?= esc($organ['name']) ?></span>
                            </label>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Province Expandable List -->
            <div class="space-y-2">
                <div onclick="toggleSection('province')" class="flex items-center justify-between px-3 py-2.5 rounded-lg text-slate-600 hover:bg-slate-50 cursor-pointer transition-colors">
                    <div class="flex items-center gap-3">
                        <i data-lucide="map" class="w-5 h-5"></i>
                        <span class="text-sm font-medium">Province</span>
                    </div>
                    <i data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-200" id="province-chevron"></i>
                </div>
                
                <div id="province-list" class="px-4 space-y-3 mt-3 hidden max-h-48 overflow-y-auto pr-2">
                    <?php if (!empty($provinces)): ?>
                        <?php foreach($provinces as $province): ?>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" name="provinces[]" value="<?= esc($province['name']) ?>" class="rounded border-slate-300 text-primary focus:ring-primary h-4 w-4">
                                <span class="text-sm text-slate-600 group-hover:text-slate-900 transition-colors"><?= esc($province['name']) ?></span>
                            </label>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex flex-col gap-2">
                <button type="submit" class="w-full bg-primary text-white font-bold h-10 rounded-lg text-xs hover:opacity-90 active:scale-98 transition-all shadow-xs">
                    Apply Filter Rules
                </button>
                <button type="reset" onclick="window.location.href='<?= base_url('/') ?>'" class="w-full text-xs text-slate-400 font-semibold text-center hover:text-primary transition-colors py-1">
                    Clear Filter Selection
                </button>
            </div>
        </form>
    </aside>

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

        <!-- Search Form -->
        <div class="max-w-3xl">
            <form action="<?= base_url('/') ?>" method="get" class="relative group">
                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400 group-focus-within:text-primary transition-colors">
                    <i data-lucide="search" class="w-5 h-5"></i>
                </div>
                <input type="text" name="q" value="<?= esc($this->request->getGet('q') ?? '') ?>" class="block w-full h-14 pl-12 pr-4 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-slate-900 placeholder:text-slate-400 shadow-sm transition-all outline-none" placeholder="Search tenders by number, title or keyword">
            </form>
        </div>

        <!-- Directory list -->
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-slate-900">Active Tenders</h2>
                <div class="flex items-center gap-2 text-sm text-slate-500">
                    <span>Showing <?= count($tenders) ?> results</span>
                    <i data-lucide="list-filter" class="w-4 h-4"></i>
                </div>
            </div>

            <!-- List Tenders Cards -->
            <div class="grid gap-4">
                <?php if (!empty($tenders)): ?>
                    <?php foreach ($tenders as $tender): ?>
                        <div class="group relative flex flex-col md:flex-row md:items-center gap-6 bg-white p-6 rounded-xl border border-slate-200 hover:border-primary/50 transition-all shadow-sm hover:shadow-md cursor-pointer">
                            <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-slate-100 text-slate-500 shrink-0">
                                <?php if($tender['iconType'] === 'medical'): ?>
                                    <i data-lucide="stethoscope" class="w-6 h-6 text-primary"></i>
                                <?php elseif($tender['iconType'] === 'engineering'): ?>
                                    <i data-lucide="settings" class="w-6 h-6 text-indigo-500"></i>
                                <?php elseif($tender['iconType'] === 'computer'): ?>
                                    <i data-lucide="laptop" class="w-6 h-6 text-slate-600"></i>
                                <?php else: ?>
                                    <i data-lucide="file-text" class="w-6 h-6 text-neutral-400"></i>
                                <?php endif; ?>
                            </div>
                            
                            <div class="flex-1 space-y-1">
                                <div class="flex flex-wrap items-center gap-2 mb-1">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-primary bg-primary/10 px-2 py-0.5 rounded"><?= esc($tender['refNumber']) ?></span>
                                    <span class="text-xs font-medium text-slate-400">Published <?= esc($tender['publishedDate']) ?></span>
                                </div>
                                <h3 class="text-md sm:text-lg font-bold text-slate-900 group-hover:text-primary transition-colors"><?= esc($tender['title']) ?></h3>
                                
                                <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-sm text-slate-600 whitespace-nowrap">
                                    <div class="flex items-center gap-1.5">
                                        <i data-lucide="building-2" class="w-4 h-4 text-slate-400"></i>
                                        <span><?= esc($tender['department']) ?></span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <i data-lucide="map-pin" class="w-4 h-4 text-slate-400"></i>
                                        <span><?= esc($tender['location']) ?></span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <i data-lucide="calendar" class="w-4 h-4 text-slate-400"></i>
                                        <span>Closing: <?= esc($tender['closingDate']) ?></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-4">
                                <button class="p-2 text-slate-400 hover:text-primary rounded-lg hover:bg-slate-50 transition-colors">
                                    <i data-lucide="bookmark" class="w-5 h-5"></i>
                                </button>
                                <i data-lucide="chevron-right" class="w-5 h-5 text-slate-300 group-hover:translate-x-1 transition-transform"></i>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Page Selection Navigator -->
            <div class="flex items-center justify-center pt-8">
                <nav class="flex items-center gap-1">
                    <button class="w-10 h-10 flex items-center justify-center rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 transition-colors"><i data-lucide="chevron-left" class="w-5 h-5"></i></button>
                    <button class="w-10 h-10 flex items-center justify-center rounded-lg bg-primary text-white font-bold shadow-sm">1</button>
                    <button class="w-10 h-10 flex items-center justify-center rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 transition-colors">2</button>
                    <button class="w-10 h-10 flex items-center justify-center rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 transition-colors">3</button>
                    <span class="px-2 text-slate-400">...</span>
                    <button class="w-10 h-10 flex items-center justify-center rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 transition-colors">12</button>
                    <button class="w-10 h-10 flex items-center justify-center rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 transition-colors"><i data-lucide="chevron-right" class="w-5 h-5"></i></button>
                </nav>
            </div>
        </div>
    </section>
</main>

<script>
    function toggleSection(sectionId) {
        const list = document.getElementById(sectionId + '-list');
        const chevron = document.getElementById(sectionId + '-chevron');
        
        if (list.classList.contains('hidden')) {
            list.classList.remove('hidden');
            chevron.style.transform = 'rotate(180deg)';
        } else {
            list.classList.add('hidden');
            chevron.style.transform = 'rotate(0deg)';
        }
    }
</script>
