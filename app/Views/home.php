<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="flex flex-1 flex-col md:flex-row w-full">
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
        <div class="space-y-6" id="tender-list-container">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Active Tenders</h2>
                <div class="flex items-center gap-2 text-sm text-slate-500">
                    <span>Showing <?= $total ?> results</span>
                    <span class="material-symbols-outlined">sort</span>
                </div>
            </div>

            <?= view('partials/tenders_list', ['tenders' => $tenders, 'total' => $total, 'perPage' => $perPage, 'page' => $page]) ?>
        </div>
    </section>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Expose Treasury API base URL to client-side code (do NOT expose API keys)
window.TREASURY_API_URL = "<?= esc(rtrim(getenv('TREASURY_API_URL') ?: 'https://ocds-api.etenders.gov.za/api/OCDSReleases', '/')) ?>";
// Toggle this to true to call the Treasury API directly from the browser.
// Note: calling the external API directly may be blocked by CORS and will NOT include server-side API keys.
window.USE_TREASURY_API = true;
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

    async function fetchTenders(opts = {}) {
        const container = document.getElementById('tender-list-container');
        const form = document.getElementById('sidebar-filters-form');
        const params = new URLSearchParams();

        if (form) {
            const fd = new FormData(form);
            for (const [k, v] of fd.entries()) {
                // Skip empty values
                if (v === null || v === '') continue;
                params.append(k, v);
            }
        }

        if (opts.page) params.set('page', opts.page);
        if (opts.perPage) params.set('perPage', opts.perPage);

        // Enforce hardcoded filter params required by the server/API
        const today = new Date().toISOString().slice(0, 10);
        const sevenDaysFromNow = new Date(Date.now() + 7 * 24 * 60 * 60 * 1000).toISOString().slice(0, 10);
        params.set('limit', '10');
        params.set('status', 'active');
        params.set('dateFrom', today);
        params.set('dateTo', sevenDaysFromNow);

        const backendUrl = '<?= base_url('home/fetchTendersAjax') ?>';
        const treasuryBase = window.TREASURY_API_URL || '';
        const url = (window.USE_TREASURY_API && treasuryBase)
            ? treasuryBase + (params.toString() ? ('?' + params.toString()) : '')
            : backendUrl + (params.toString() ? ('?' + params.toString()) : '');

        try {
            const res = await fetch(url, { credentials: 'same-origin' });
            if (!res.ok) throw new Error('Network response was not ok');
            const data = await res.json();
            if (container && data.html) container.innerHTML = data.html;

            // Update API debug panel info if present
            const apiReqElem = document.querySelector('#apiDebugPanel p code');
            const apiRespElem = document.querySelector('#apiDebugPanel pre');
            if (apiReqElem) apiReqElem.textContent = url || (data.requestUrl ?? 'N/A');
            if (apiRespElem) apiRespElem.textContent = JSON.stringify(data.rawResponse ?? data, null, 2);
        } catch (err) {
            console.error('Fetch tenders failed', err);
        }
    }

    // Intercept filter form submit to fetch via AJAX
    const sidebarForm = document.getElementById('sidebar-filters-form');
    if (sidebarForm) {
        sidebarForm.addEventListener('submit', function (e) {
            e.preventDefault();
            fetchTenders({ page: 1 });
        });
    }
</script>
<?= $this->endSection() ?>
