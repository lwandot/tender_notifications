<main class="flex flex-1 flex-col md:flex-row max-w-[1440px] mx-auto w-full">
    <!-- Sidebar Filters Form (Submitted via GET to filter listing) -->
    <aside class="w-full md:w-80 border-r border-slate-200 bg-white p-6 space-y-6 h-full min-h-[calc(100vh-73px)]">
        <div>
            <h1 class="text-slate-900 text-lg font-bold mb-1">Filters</h1>
            <p class="text-slate-500 text-xs">Search and refine active tenders</p>
        </div>

        <form action="<?= base_url('/') ?>" method="get" class="space-y-6" id="sidebar-filters-form">
            <!-- Category Searchable Dropdown -->
            <div class="space-y-2 relative" id="sb-dropdown-wrapper-category">
                <div class="flex justify-between items-center">
                    <label class="text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center gap-1.5">
                        <i data-lucide="folder" class="w-4 h-4 text-primary"></i> Category
                    </label>
                    <span class="text-xs font-semibold text-primary bg-primary/5 px-2.5 py-0.5 rounded-full border border-primary/20" id="sb-count-category">
                        0 Selected
                    </span>
                </div>

                <!-- Trigger Box -->
                <div onclick="sbToggleDropdownMenu('category')" id="sb-trigger-category" class="min-h-[48px] w-full p-2.5 bg-white border border-slate-200 rounded-xl cursor-pointer hover:border-slate-300 transition-all flex items-center justify-between gap-2 shadow-xs">
                    <div class="flex flex-wrap items-center gap-1.5 flex-1" id="sb-chips-category">
                        <span class="text-xs text-slate-400 pl-1">Select category...</span>
                    </div>
                    <div class="flex items-center gap-1 shrink-0 text-slate-400">
                        <i data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-200" id="sb-chevron-category"></i>
                    </div>
                </div>

                <!-- Dropdown Menu -->
                <div id="sb-menu-category" class="hidden absolute z-30 top-full left-0 right-0 mt-1.5 bg-white border border-slate-200 rounded-xl shadow-xl overflow-hidden">
                    <div class="p-2.5 border-b border-slate-100 bg-slate-50/80 flex items-center gap-2">
                        <i data-lucide="search" class="w-4 h-4 text-slate-400 shrink-0"></i>
                        <input type="text" id="sb-search-category" oninput="sbFilterOptions('category', this.value)" placeholder="Type to filter categories..." class="w-full text-xs bg-transparent border-none outline-none text-slate-900 placeholder:text-slate-400">
                    </div>
                    <div class="max-h-56 overflow-y-auto p-1.5 space-y-0.5" id="sb-options-category">
                        <?php if (!empty($categories)): ?>
                            <?php foreach($categories as $category): ?>
                                <label class="flex items-center justify-between p-2.5 rounded-lg text-xs hover:bg-slate-50 text-slate-700 font-medium cursor-pointer transition-all sb-opt-item-category" data-name="<?= esc(strtolower($category['name'])) ?>">
                                    <div class="flex items-center gap-2.5 truncate pr-2">
                                        <input type="checkbox" name="categories[]" value="<?= esc($category['name']) ?>" onchange="sbSyncSelections('category')" class="rounded border-slate-300 text-primary focus:ring-primary h-4 w-4 shrink-0">
                                        <span class="truncate"><?= esc($category['name']) ?></span>
                                    </div>
                                </label>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <div id="sb-nomatch-category" class="hidden p-6 text-center text-slate-400 text-xs">No matching categories</div>
                    </div>
                </div>
            </div>

            <!-- Organ of State Searchable Dropdown -->
            <div class="space-y-2 relative" id="sb-dropdown-wrapper-organ">
                <div class="flex justify-between items-center">
                    <label class="text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center gap-1.5">
                        <i data-lucide="landmark" class="w-4 h-4 text-primary"></i> Organ of State
                    </label>
                    <span class="text-xs font-semibold text-primary bg-primary/5 px-2.5 py-0.5 rounded-full border border-primary/20" id="sb-count-organ">
                        0 Selected
                    </span>
                </div>

                <!-- Trigger Box -->
                <div onclick="sbToggleDropdownMenu('organ')" id="sb-trigger-organ" class="min-h-[48px] w-full p-2.5 bg-white border border-slate-200 rounded-xl cursor-pointer hover:border-slate-300 transition-all flex items-center justify-between gap-2 shadow-xs">
                    <div class="flex flex-wrap items-center gap-1.5 flex-1" id="sb-chips-organ">
                        <span class="text-xs text-slate-400 pl-1">Select organs of state...</span>
                    </div>
                    <div class="flex items-center gap-1 shrink-0 text-slate-400">
                        <i data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-200" id="sb-chevron-organ"></i>
                    </div>
                </div>

                <!-- Dropdown Menu -->
                <div id="sb-menu-organ" class="hidden absolute z-30 top-full left-0 right-0 mt-1.5 bg-white border border-slate-200 rounded-xl shadow-xl overflow-hidden">
                    <div class="p-2.5 border-b border-slate-100 bg-slate-50/80 flex items-center gap-2">
                        <i data-lucide="search" class="w-4 h-4 text-slate-400 shrink-0"></i>
                        <input type="text" id="sb-search-organ" oninput="sbFilterOptions('organ', this.value)" placeholder="Type to filter organs..." class="w-full text-xs bg-transparent border-none outline-none text-slate-900 placeholder:text-slate-400">
                    </div>
                    <div class="max-h-56 overflow-y-auto p-1.5 space-y-0.5" id="sb-options-organ">
                        <?php if (!empty($organs)): ?>
                            <?php foreach($organs as $organ): ?>
                                <label class="flex items-center justify-between p-2.5 rounded-lg text-xs hover:bg-slate-50 text-slate-700 font-medium cursor-pointer transition-all sb-opt-item-organ" data-name="<?= esc(strtolower($organ['name'])) ?>">
                                    <div class="flex items-center gap-2.5 truncate pr-2">
                                        <input type="checkbox" name="organs[]" value="<?= esc($organ['name']) ?>" onchange="sbSyncSelections('organ')" class="rounded border-slate-300 text-primary focus:ring-primary h-4 w-4 shrink-0">
                                        <span class="truncate"><?= esc($organ['name']) ?></span>
                                    </div>
                                </label>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <div id="sb-nomatch-organ" class="hidden p-6 text-center text-slate-400 text-xs">No matching organs</div>
                    </div>
                </div>
            </div>

            <!-- Province Searchable Dropdown -->
            <div class="space-y-2 relative" id="sb-dropdown-wrapper-province">
                <div class="flex justify-between items-center">
                    <label class="text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center gap-1.5">
                        <i data-lucide="map" class="w-4 h-4 text-primary"></i> Province
                    </label>
                    <span class="text-xs font-semibold text-primary bg-primary/5 px-2.5 py-0.5 rounded-full border border-primary/20" id="sb-count-province">
                        0 Selected
                    </span>
                </div>

                <!-- Trigger Box -->
                <div onclick="sbToggleDropdownMenu('province')" id="sb-trigger-province" class="min-h-[48px] w-full p-2.5 bg-white border border-slate-200 rounded-xl cursor-pointer hover:border-slate-300 transition-all flex items-center justify-between gap-2 shadow-xs">
                    <div class="flex flex-wrap items-center gap-1.5 flex-1" id="sb-chips-province">
                        <span class="text-xs text-slate-400 pl-1">Select province...</span>
                    </div>
                    <div class="flex items-center gap-1 shrink-0 text-slate-400">
                        <i data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-200" id="sb-chevron-province"></i>
                    </div>
                </div>

                <!-- Dropdown Menu -->
                <div id="sb-menu-province" class="hidden absolute z-30 top-full left-0 right-0 mt-1.5 bg-white border border-slate-200 rounded-xl shadow-xl overflow-hidden">
                    <div class="p-2.5 border-b border-slate-100 bg-slate-50/80 flex items-center gap-2">
                        <i data-lucide="search" class="w-4 h-4 text-slate-400 shrink-0"></i>
                        <input type="text" id="sb-search-province" oninput="sbFilterOptions('province', this.value)" placeholder="Type to filter provinces..." class="w-full text-xs bg-transparent border-none outline-none text-slate-900 placeholder:text-slate-400">
                    </div>
                    <div class="max-h-56 overflow-y-auto p-1.5 space-y-0.5" id="sb-options-province">
                        <?php if (!empty($provinces)): ?>
                            <?php foreach($provinces as $province): ?>
                                <label class="flex items-center justify-between p-2.5 rounded-lg text-xs hover:bg-slate-50 text-slate-700 font-medium cursor-pointer transition-all sb-opt-item-province" data-name="<?= esc(strtolower($province['name'])) ?>">
                                    <div class="flex items-center gap-2.5 truncate pr-2">
                                        <input type="checkbox" name="provinces[]" value="<?= esc($province['name']) ?>" onchange="sbSyncSelections('province')" class="rounded border-slate-300 text-primary focus:ring-primary h-4 w-4 shrink-0">
                                        <span class="truncate"><?= esc($province['name']) ?></span>
                                    </div>
                                </label>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <div id="sb-nomatch-province" class="hidden p-6 text-center text-slate-400 text-xs">No matching provinces</div>
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex flex-col gap-2">
                <button type="submit" class="w-full bg-primary text-white font-bold h-10 rounded-lg text-xs hover:opacity-90 active:scale-98 transition-all shadow-xs flex items-center justify-center gap-1.5">
                    <i data-lucide="filter" class="w-4 h-4"></i>
                    <span>Apply Filter Rules</span>
                </button>
                <button type="button" onclick="sbResetFilters()" class="w-full text-xs text-slate-400 font-semibold text-center hover:text-primary transition-colors py-1 flex items-center justify-center gap-1">
                    <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                    <span>Clear Filter Selection</span>
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
    function sbToggleDropdownMenu(type) {
        const types = ['category', 'organ', 'province'];
        types.forEach(t => {
            const menu = document.getElementById('sb-menu-' + t);
            const chevron = document.getElementById('sb-chevron-' + t);
            if (t === type) {
                const isOpen = !menu.classList.contains('hidden');
                if (isOpen) {
                    menu.classList.add('hidden');
                    if (chevron) chevron.classList.remove('rotate-180');
                } else {
                    menu.classList.remove('hidden');
                    if (chevron) chevron.classList.add('rotate-180');
                    const searchInput = document.getElementById('sb-search-' + t);
                    if (searchInput) searchInput.focus();
                }
            } else {
                if (menu) menu.classList.add('hidden');
                if (chevron) chevron.classList.remove('rotate-180');
            }
        });
    }

    function sbFilterOptions(type, query) {
        const q = query.toLowerCase().trim();
        const items = document.querySelectorAll('.sb-opt-item-' + type);
        let matchCount = 0;

        items.forEach(item => {
            const name = item.getAttribute('data-name') || '';
            if (name.includes(q)) {
                item.style.display = 'flex';
                matchCount++;
            } else {
                item.style.display = 'none';
            }
        });

        const noMatch = document.getElementById('sb-nomatch-' + type);
        if (noMatch) {
            noMatch.style.display = (matchCount === 0) ? 'block' : 'none';
        }
    }

    function sbSyncSelections(type) {
        const checkboxes = document.querySelectorAll(`#sb-options-${type} input[type="checkbox"]:checked`);
        const countSpan = document.getElementById('sb-count-' + type);
        const chipsContainer = document.getElementById('sb-chips-' + type);

        if (countSpan) {
            countSpan.innerText = `${checkboxes.length} Selected`;
        }

        if (chipsContainer) {
            if (checkboxes.length === 0) {
                const placeholder = (type === 'category') ? 'Select category...' : (type === 'organ') ? 'Select organs of state...' : 'Select province...';
                chipsContainer.innerHTML = `<span class="text-xs text-slate-400 pl-1">${placeholder}</span>`;
            } else {
                let html = '';
                checkboxes.forEach(cb => {
                    const val = cb.value;
                    const safeVal = val.replace(/'/g, "\\'");
                    html += `<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-primary/10 text-primary text-xs font-semibold border border-primary/20">
                        <span>${val}</span>
                        <button type="button" onclick="event.stopPropagation(); sbUnselectItem('${type}', '${safeVal}')" class="hover:bg-primary/20 rounded p-0.5 transition-colors">
                            <i data-lucide="x" class="w-3 h-3"></i>
                        </button>
                    </span>`;
                });
                chipsContainer.innerHTML = html;
                if (window.lucide) lucide.createIcons();
            }
        }
    }

    function sbUnselectItem(type, value) {
        const checkboxes = document.querySelectorAll(`#sb-options-${type} input[type="checkbox"]`);
        checkboxes.forEach(cb => {
            if (cb.value === value) {
                cb.checked = false;
            }
        });
        sbSyncSelections(type);
    }

    function sbResetFilters() {
        const form = document.getElementById('sidebar-filters-form');
        if (form) form.reset();
        ['category', 'organ', 'province'].forEach(t => sbSyncSelections(t));
        window.location.href = "<?= base_url('/') ?>";
    }

    // Close dropdowns on outside click
    document.addEventListener('click', function(e) {
        ['category', 'organ', 'province'].forEach(t => {
            const wrapper = document.getElementById('sb-dropdown-wrapper-' + t);
            if (wrapper && !wrapper.contains(e.target)) {
                const menu = document.getElementById('sb-menu-' + t);
                const chevron = document.getElementById('sb-chevron-' + t);
                if (menu) menu.classList.add('hidden');
                if (chevron) chevron.classList.remove('rotate-180');
            }
        });
    });

    // Initial setup on page load
    document.addEventListener('DOMContentLoaded', function() {
        ['category', 'organ', 'province'].forEach(t => sbSyncSelections(t));
    });
</script>
