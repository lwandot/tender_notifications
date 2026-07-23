<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="bg-background-light min-h-[calc(100vh-73px)] py-8 px-4 md:px-8 max-w-6xl mx-auto">
    <!-- Breadcrumb back link -->
    <div class="flex items-center justify-between mb-8">
        <a href="<?= base_url('/') ?>" class="flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors bg-white px-3 py-2 rounded-lg border border-slate-200 shadow-sm">
            <i data-lucide="chevron-left" class="w-4 h-4"></i>
            <span>Back to Tenders</span>
        </a>
        <span class="text-xs font-semibold text-slate-500 bg-white border border-slate-200 px-2.5 py-1 rounded-full shadow-xs">
            Direct Alerts Integration Engine
        </span>
    </div>

    <!-- Error container -->
    <div id="validation-error" class="hidden bg-amber-50 border-l-4 border-amber-500 p-4 rounded-r-lg flex items-start gap-3 mb-6 transition-all">
        <i data-lucide="alert-circle" class="w-5 h-5 text-amber-600 shrink-0 mt-0.5"></i>
        <div>
            <p id="error-message" class="text-xs text-amber-800 font-semibold"></p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start" id="wizard-container">
        <!-- Main Form & Tab scope -->
        <div class="lg:col-span-8 space-y-6">
            <div class="bg-white p-6 md:p-8 rounded-xl border border-slate-200 shadow-sm">
                <div class="flex items-center gap-3 mb-2">
                    <div class="bg-primary/10 text-primary p-2 rounded-lg">
                        <i data-lucide="bell" class="w-6 h-6"></i>
                    </div>
                    <h1 class="text-2xl font-bold text-slate-900">Custom Tender Notifications</h1>
                </div>
                <p class="text-slate-600 max-w-xl">
                    Select your notification methods, choose multiple relevant scopes, and subscribe to tailored real-time alert updates.
                </p>

                <!-- Steps Navigation Header -->
                <div class="grid grid-cols-4 gap-2 mt-8 border-t border-slate-100 pt-6">
                    <button type="button" onclick="goToStep('package')" id="step-nav-package" class="text-left pb-3 border-b-2 border-primary text-primary font-bold transition-all">
                        <span class="text-[10px] uppercase font-mono block text-neutral-400">Step 1</span>
                        <span class="text-xs md:text-sm truncate block">Plan Selection</span>
                    </button>
                    <button type="button" onclick="goToStep('channels')" id="step-nav-channels" class="text-left pb-3 border-b-2 border-slate-200 text-slate-400 font-semibold hover:text-slate-600 transition-all">
                        <span class="text-[10px] uppercase font-mono block text-neutral-400">Step 2</span>
                        <span class="text-xs md:text-sm truncate block">Alert Channels</span>
                    </button>
                    <button type="button" onclick="goToStep('filters')" id="step-nav-filters" class="text-left pb-3 border-b-2 border-slate-200 text-slate-400 font-semibold hover:text-slate-600 transition-all">
                        <span class="text-[10px] uppercase font-mono block text-neutral-400">Step 3</span>
                        <span class="text-xs md:text-sm truncate block">Filter Scopes</span>
                    </button>
                    <button type="button" onclick="goToStep('checkout')" id="step-nav-checkout" class="text-left pb-3 border-b-2 border-slate-200 text-slate-400 font-semibold hover:text-slate-600 transition-all">
                        <span class="text-[10px] uppercase font-mono block text-neutral-400">Step 4</span>
                        <span class="text-xs md:text-sm truncate block">Setup Alerts</span>
                    </button>
                </div>
            </div>

            <!-- Form Wrapper containing wizard inputs -->
            <form id="subscribe-form" method="post" action="<?= base_url('subscription/process') ?>" class="bg-white p-6 md:p-8 rounded-xl border border-slate-200 shadow-sm space-y-8">
                <!-- CSRF Protection -->
                <input type="hidden" name="<?= $csrf_token ?>" value="<?= $csrf_hash ?>" />
                
                <!-- Hidden inputs for active package -->
                <input type="hidden" name="package_id" id="input-package-id" value="basic" />

                <!-- PANEL 1: PACAKGE CHOOSER -->
                <div id="panel-package" class="space-y-6">
                    <h3 class="text-lg font-bold text-slate-900">Choose your Alert Frequency Package</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        
                        <!-- Free Trial Plan Card -->
                        <div onclick="selectPackage('free')" id="card-free" class="relative border-2 border-slate-200 rounded-xl p-5 cursor-pointer hover:border-slate-300 transition-all flex flex-col justify-between">
                            <div>
                                <h4 class="text-md font-bold text-slate-800">Free Trial</h4>
                                <div class="my-2 flex items-baseline">
                                    <span class="text-2xl font-bold text-slate-900">R0.00</span>
                                    <span class="text-xs text-slate-500 ml-1">/ month</span>
                                </div>
                                <p class="text-xs text-slate-500 mt-2 min-h-[40px]">Get a taste of tender notifications for a single region.</p>
                            </div>
                            <div class="mt-4 pt-4 border-t border-slate-100 flex flex-col gap-2">
                                <span class="text-xs font-semibold text-slate-700 flex items-center gap-1.5"><span class="w-1.5 h-1.5 bg-primary rounded-full"></span>Max 1 Category</span>
                                <span class="text-xs font-semibold text-slate-700 flex items-center gap-1.5"><span class="w-1.5 h-1.5 bg-primary rounded-full"></span>Max 1 Province</span>
                                <span class="text-xs text-slate-700 flex items-center gap-1.5"><span class="w-1.5 h-1.5 bg-primary rounded-full"></span>Email notifications only</span>
                            </div>
                            <button type="button" class="mt-5 w-full py-2 bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-bold rounded-lg pointer-events-none">Choose Plan</button>
                        </div>

                        <!-- Basic Alert Plan Card (Default and user specified R29) -->
                        <div onclick="selectPackage('basic')" id="card-basic" class="relative border-2 border-primary bg-primary/[0.02] shadow-md rounded-xl p-5 cursor-pointer hover:border-slate-300 transition-all flex flex-col justify-between">
                            <div>
                                <h4 class="text-md font-bold text-slate-800">Basic Alert</h4>
                                <div class="my-2 flex items-baseline">
                                    <span class="text-2xl font-bold text-slate-900">R29.00</span>
                                    <span class="text-xs text-slate-500 ml-1">/ month</span>
                                </div>
                                <p class="text-xs text-slate-500 mt-2 min-h-[40px]">5+ Categories, 2 Provinces. Perfect for local suppliers tracking state tenders on WhatsApp!</p>
                            </div>
                            <div class="mt-4 pt-4 border-t border-slate-100 flex flex-col gap-2">
                                <span class="text-xs font-semibold text-slate-700 flex items-center gap-1.5"><span class="w-1.5 h-1.5 bg-primary rounded-full"></span>Max 5 Categories</span>
                                <span class="text-xs font-semibold text-slate-700 flex items-center gap-1.5"><span class="w-1.5 h-1.5 bg-primary rounded-full"></span>Max 2 Provinces</span>
                                <span class="text-xs text-slate-700 flex items-center gap-1.5"><span class="w-1.5 h-1.5 bg-primary rounded-full"></span>Email, WhatsApp Alerts</span>
                            </div>
                            <button type="button" class="mt-5 w-full py-2 bg-primary text-white text-xs font-bold rounded-lg pointer-events-none">Selected</button>
                        </div>

                        <!-- Premium Max Alert Card (User specified R49) -->
                        <div onclick="selectPackage('premium')" id="card-premium" class="relative border-2 border-slate-200 rounded-xl p-5 cursor-pointer hover:border-slate-300 transition-all flex flex-col justify-between">
                            <span class="absolute top-0 right-4 transform -translate-y-1/2 bg-amber-500 text-white text-[10px] uppercase font-bold tracking-wider px-2 py-0.5 rounded-full flex items-center gap-1 shadow-xs">
                                🌟 Popular Choice
                            </span>
                            <div>
                                <h4 class="text-md font-bold text-slate-800">Premium Max</h4>
                                <div class="my-2 flex items-baseline">
                                    <span class="text-2xl font-bold text-slate-900">R49.00</span>
                                    <span class="text-xs text-slate-500 ml-1">/ month</span>
                                </div>
                                <p class="text-xs text-slate-500 mt-2 min-h-[40px]">10+ Categories, WhatsApp, SMS & Push Notifications matching wide coverage profiles.</p>
                            </div>
                            <div class="mt-4 pt-4 border-t border-slate-100 flex flex-col gap-2">
                                <span class="text-xs font-semibold text-slate-700 flex items-center gap-1.5"><span class="w-1.5 h-1.5 bg-primary rounded-full"></span>Max 10 Categories</span>
                                <span class="text-xs font-semibold text-slate-700 flex items-center gap-1.5"><span class="w-1.5 h-1.5 bg-primary rounded-full"></span>Unlimited Provinces (All 9)</span>
                                <span class="text-xs text-slate-700 flex items-center gap-1.5"><span class="w-1.5 h-1.5 bg-primary rounded-full"></span>Email, WhatsApp, Push & SMS</span>
                            </div>
                            <button type="button" class="mt-5 w-full py-2 bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-bold rounded-lg pointer-events-none">Choose Plan</button>
                        </div>

                    </div>
                </div>

                <!-- PANEL 2: DELIVEY METHODS ALERTS CHANNELS -->
                <div id="panel-channels" class="hidden space-y-6">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">How would you like to receive tender updates?</h3>
                        <p class="text-xs text-slate-500 mt-1">Select one or multiple. Available channels vary based on your selected package plan.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                        
                        <!-- Email toggle block -->
                        <div onclick="toggleChannel('email')" id="btn-chan-email" class="p-4 border-2 border-primary bg-primary/[0.02] rounded-xl text-left cursor-pointer transition-all">
                            <input type="checkbox" name="channels[]" value="email" id="chk-email" checked class="hidden" />
                            <div class="flex items-center justify-between mb-3">
                                <i data-lucide="mail" class="w-8 h-8 text-primary"></i>
                                <span class="text-primary font-bold" id="badge-email">✓ Selected</span>
                            </div>
                            <h4 class="font-bold text-slate-800 text-sm">Email Digest</h4>
                            <p class="text-[10px] text-slate-400 mt-1">Hourly batch email detailing matched state tenders.</p>
                        </div>

                        <!-- WhatsApp toggle block (R29+) -->
                        <div onclick="toggleChannel('whatsapp')" id="btn-chan-whatsapp" class="p-4 border-2 border-primary bg-primary/[0.02] rounded-xl text-left cursor-pointer transition-all">
                            <input type="checkbox" name="channels[]" value="whatsapp" id="chk-whatsapp" checked class="hidden" />
                            <div class="flex items-center justify-between mb-3">
                                <i data-lucide="messages-square" class="w-8 h-8 text-green-600"></i>
                                <span class="text-green-600 font-bold" id="badge-whatsapp">✓ Selected</span>
                            </div>
                            <h4 class="font-bold text-slate-800 text-sm">WhatsApp Alert</h4>
                            <p class="text-[10px] text-slate-400 mt-1">Instant broadcasts matching active bids.</p>
                        </div>

                        <!-- SMS toggle block (R49 Premium limit) -->
                        <div onclick="toggleChannel('sms')" id="btn-chan-sms" class="p-4 border border-slate-100 rounded-xl text-left cursor-pointer hover:border-slate-200 transition-all opacity-50">
                            <input type="checkbox" name="channels[]" value="sms" id="chk-sms" class="hidden" />
                            <div class="flex items-center justify-between mb-3">
                                <i data-lucide="smartphone" class="w-8 h-8 text-blue-600"></i>
                                <span class="text-slate-400 text-xs" id="badge-sms">Not Selected</span>
                            </div>
                            <h4 class="font-bold text-slate-800 text-sm">SMS Broadcast</h4>
                            <p class="text-[10px] text-slate-400 mt-1">Instant transactional text summary matching active RFQs.</p>
                            <span class="text-[9px] uppercase font-bold text-amber-600 bg-amber-50 px-1 py-0.5 rounded block mt-2 text-center" id="restrict-sms">Requires R49 Premium</span>
                        </div>

                        <!-- Push notification toggle block (R49) -->
                        <div onclick="toggleChannel('push')" id="btn-chan-push" class="p-4 border border-slate-100 rounded-xl text-left cursor-pointer hover:border-slate-200 transition-all opacity-50">
                            <input type="checkbox" name="channels[]" value="push" id="chk-push" class="hidden" />
                            <div class="flex items-center justify-between mb-3">
                                <i data-lucide="bell" class="w-8 h-8 text-amber-500"></i>
                                <span class="text-slate-400 text-xs" id="badge-push">Not Selected</span>
                            </div>
                            <h4 class="font-bold text-slate-800 text-sm">Push Notifications</h4>
                            <p class="text-[10px] text-slate-400 mt-1">Direct browser notification on publication.</p>
                            <span class="text-[9px] uppercase font-bold text-amber-600 bg-amber-50 px-1 py-0.5 rounded block mt-2 text-center" id="restrict-push">Requires R49 Premium</span>
                        </div>

                    </div>
                </div>

                <!-- PANEL 3: MULTIPLE FILTER SCOPES SELECTION -->
                <div id="panel-filters" class="hidden space-y-6">
                    <p class="text-xs text-slate-500 mb-2">
                        Search and select your desired target scopes below. Options are searchable with multiple selection.
                    </p>

                    <!-- Category Searchable Dropdown -->
                    <div class="space-y-2 relative" id="dropdown-wrapper-category">
                        <div class="flex justify-between items-center">
                            <label class="text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center gap-1.5">
                                <i data-lucide="folder-open" class="w-4 h-4 text-primary"></i> 1. Category
                            </label>
                            <span class="text-xs font-semibold text-primary bg-primary/5 px-2.5 py-0.5 rounded-full border border-primary/20" id="lbl-cat-limit">
                                Selected: 0 / Max 5
                            </span>
                        </div>

                        <!-- Trigger box -->
                        <div onclick="toggleDropdownMenu('category')" id="trigger-category" class="min-h-[48px] w-full p-2.5 bg-white border border-slate-200 rounded-xl cursor-pointer hover:border-slate-300 transition-all flex items-center justify-between gap-2 shadow-xs">
                            <div class="flex flex-wrap items-center gap-1.5 flex-1" id="chips-category">
                                <span class="text-xs text-slate-400 pl-1">Select category...</span>
                            </div>
                            <div class="flex items-center gap-1 shrink-0 text-slate-400">
                                <i data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-200" id="chevron-category"></i>
                            </div>
                        </div>

                        <!-- Dropdown Menu -->
                        <div id="menu-category" class="hidden absolute z-30 top-full left-0 right-0 mt-1.5 bg-white border border-slate-200 rounded-xl shadow-xl overflow-hidden">
                            <!-- Search box -->
                            <div class="p-2.5 border-b border-slate-100 bg-slate-50/80 flex items-center gap-2">
                                <i data-lucide="search" class="w-4 h-4 text-slate-400 shrink-0"></i>
                                <input type="text" id="search-input-category" oninput="filterDropdownOptions('category', this.value)" placeholder="Type to filter categories (e.g. Medical, IT)..." class="w-full text-xs bg-transparent border-none outline-none text-slate-900 placeholder:text-slate-400">
                            </div>

                            <!-- List -->
                            <div class="max-h-56 overflow-y-auto p-1.5 space-y-0.5" id="options-category">
                                <?php foreach($categories as $category): ?>
                                    <div onclick="toggleMultiItem('category', '<?= esc($category['name']) ?>')" id="chk-category-<?= esc($category['name']) ?>" class="flex items-center justify-between p-2.5 rounded-lg text-xs hover:bg-slate-50 text-slate-700 font-medium cursor-pointer transition-all opt-item-category" data-name="<?= esc(strtolower($category['name'])) ?>">
                                        <div class="flex items-center gap-2.5 truncate pr-2">
                                            <div class="w-4 h-4 rounded border border-slate-300 flex items-center justify-center bg-white shrink-0" id="box-category-<?= esc($category['name']) ?>"></div>
                                            <span class="truncate"><?= esc($category['name']) ?></span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                <div id="no-match-category" class="hidden p-6 text-center text-slate-400 text-xs">No matching categories found</div>
                            </div>
                        </div>
                    </div>

                    <!-- Province Searchable Dropdown -->
                    <div class="space-y-2 relative" id="dropdown-wrapper-province">
                        <div class="flex justify-between items-center">
                            <label class="text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center gap-1.5">
                                <i data-lucide="map" class="w-4 h-4 text-primary"></i> 2. Province
                            </label>
                            <span class="text-xs font-semibold text-primary bg-primary/5 px-2.5 py-0.5 rounded-full border border-primary/20" id="lbl-prov-limit">
                                Selected: 0 / Max 2
                            </span>
                        </div>

                        <!-- Trigger box -->
                        <div onclick="toggleDropdownMenu('province')" id="trigger-province" class="min-h-[48px] w-full p-2.5 bg-white border border-slate-200 rounded-xl cursor-pointer hover:border-slate-300 transition-all flex items-center justify-between gap-2 shadow-xs">
                            <div class="flex flex-wrap items-center gap-1.5 flex-1" id="chips-province">
                                <span class="text-xs text-slate-400 pl-1">Select province...</span>
                            </div>
                            <div class="flex items-center gap-1 shrink-0 text-slate-400">
                                <i data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-200" id="chevron-province"></i>
                            </div>
                        </div>

                        <!-- Dropdown Menu -->
                        <div id="menu-province" class="hidden absolute z-30 top-full left-0 right-0 mt-1.5 bg-white border border-slate-200 rounded-xl shadow-xl overflow-hidden">
                            <!-- Search box -->
                            <div class="p-2.5 border-b border-slate-100 bg-slate-50/80 flex items-center gap-2">
                                <i data-lucide="search" class="w-4 h-4 text-slate-400 shrink-0"></i>
                                <input type="text" id="search-input-province" oninput="filterDropdownOptions('province', this.value)" placeholder="Type to filter provinces (e.g. Gauteng, Western Cape)..." class="w-full text-xs bg-transparent border-none outline-none text-slate-900 placeholder:text-slate-400">
                            </div>

                            <!-- List -->
                            <div class="max-h-56 overflow-y-auto p-1.5 space-y-0.5" id="options-province">
                                <?php foreach($provinces as $province): ?>
                                    <div onclick="toggleMultiItem('province', '<?= esc($province['name']) ?>')" id="chk-province-<?= esc($province['name']) ?>" class="flex items-center justify-between p-2.5 rounded-lg text-xs hover:bg-slate-50 text-slate-700 font-medium cursor-pointer transition-all opt-item-province" data-name="<?= esc(strtolower($province['name'])) ?>">
                                        <div class="flex items-center gap-2.5 truncate pr-2">
                                            <div class="w-4 h-4 rounded border border-slate-300 flex items-center justify-center bg-white shrink-0" id="box-province-<?= esc($province['name']) ?>"></div>
                                            <span class="truncate"><?= esc($province['name']) ?></span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                <div id="no-match-province" class="hidden p-6 text-center text-slate-400 text-xs">No matching provinces found</div>
                            </div>
                        </div>
                    </div>

                    <!-- Organ of State Searchable Dropdown -->
                    <div class="space-y-2 relative" id="dropdown-wrapper-organ">
                        <div class="flex justify-between items-center">
                            <label class="text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center gap-1.5">
                                <i data-lucide="building-2" class="w-4 h-4 text-primary"></i> 3. Organ of State
                            </label>
                            <span class="text-xs font-semibold text-slate-500 bg-slate-100 px-2.5 py-0.5 rounded-full" id="lbl-organ-limit">
                                Multiselect enabled
                            </span>
                        </div>

                        <!-- Trigger box -->
                        <div onclick="toggleDropdownMenu('organ')" id="trigger-organ" class="min-h-[48px] w-full p-2.5 bg-white border border-slate-200 rounded-xl cursor-pointer hover:border-slate-300 transition-all flex items-center justify-between gap-2 shadow-xs">
                            <div class="flex flex-wrap items-center gap-1.5 flex-1" id="chips-organ">
                                <span class="text-xs text-slate-400 pl-1">Select organs of state...</span>
                            </div>
                            <div class="flex items-center gap-1 shrink-0 text-slate-400">
                                <i data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-200" id="chevron-organ"></i>
                            </div>
                        </div>

                        <!-- Dropdown Menu -->
                        <div id="menu-organ" class="hidden absolute z-30 top-full left-0 right-0 mt-1.5 bg-white border border-slate-200 rounded-xl shadow-xl overflow-hidden">
                            <!-- Search box -->
                            <div class="p-2.5 border-b border-slate-100 bg-slate-50/80 flex items-center gap-2">
                                <i data-lucide="search" class="w-4 h-4 text-slate-400 shrink-0"></i>
                                <input type="text" id="search-input-organ" oninput="filterDropdownOptions('organ', this.value)" placeholder="Type to filter departments / organs (e.g. Treasury, Eskom)..." class="w-full text-xs bg-transparent border-none outline-none text-slate-900 placeholder:text-slate-400">
                            </div>

                            <!-- List -->
                            <div class="max-h-56 overflow-y-auto p-1.5 space-y-0.5" id="options-organ">
                                <?php foreach($organs as $organ): ?>
                                    <div onclick="toggleMultiItem('organ', '<?= esc($organ['name']) ?>')" id="chk-organ-<?= esc($organ['name']) ?>" class="flex items-center justify-between p-2.5 rounded-lg text-xs hover:bg-slate-50 text-slate-700 font-medium cursor-pointer transition-all opt-item-organ" data-name="<?= esc(strtolower($organ['name'])) ?>">
                                        <div class="flex items-center gap-2.5 truncate pr-2">
                                            <div class="w-4 h-4 rounded border border-slate-300 flex items-center justify-center bg-white shrink-0" id="box-organ-<?= esc($organ['name']) ?>"></div>
                                            <span class="truncate"><?= esc($organ['name']) ?></span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                <div id="no-match-organ" class="hidden p-6 text-center text-slate-400 text-xs">No matching organs of state found</div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- PANEL 4: CHECKOUT FORM -->
                <div id="panel-checkout" class="hidden space-y-6">
                    <h3 class="text-lg font-bold text-slate-900">Setup & Finalize Alerts</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 animate-fadeIn">
                        <!-- User credentials -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Company Contact Name:</label>
                                <input type="text" name="name" required class="block w-full h-11 px-3 border border-slate-200 rounded-lg text-sm text-slate-950 focus:ring-2 focus:ring-primary focus:border-transparent outline-none" placeholder="e.g. John Doe">
                            </div>

                            <div id="wrapper-input-email">
                                <label class="block text-xs font-bold text-slate-700 mb-1 flex items-center gap-1">
                                    <i data-lucide="mail" class="w-3.5 h-3.5 text-primary"></i> Email Address
                                </label>
                                <input type="email" name="email" id="field-email" class="block w-full h-11 px-3 border border-slate-200 rounded-lg text-sm text-slate-950 focus:ring-2 focus:ring-primary focus:border-transparent outline-none" placeholder="e.g. admin@yourcorp.co.za">
                                <p class="text-[10px] text-slate-400 mt-1">Daily matched bulletins will route to this destination.</p>
                            </div>

                            <div id="wrapper-input-whatsapp">
                                <label class="block text-xs font-bold text-slate-700 mb-1 flex items-center gap-1">
                                    <i data-lucide="messages-square" class="w-3.5 h-3.5 text-green-600 animate-pulse"></i> WhatsApp Contact Number
                                </label>
                                <input type="tel" name="whatsapp" id="field-whatsapp" class="block w-full h-11 px-3 border border-slate-200 rounded-lg text-sm text-slate-950 focus:ring-2 focus:ring-primary focus:border-transparent outline-none" placeholder="e.g. +27 72 123 4567">
                                <p class="text-[10px] text-slate-400 mt-1">Receive direct PDF link, ref code, and details instantly on WhatsApp.</p>
                            </div>

                            <div id="wrapper-input-phone" class="hidden">
                                <label class="block text-xs font-bold text-slate-700 mb-1 flex items-center gap-1">
                                    <i data-lucide="smartphone" class="w-3.5 h-3.5 text-blue-600"></i> Standard Mobile/SMS Number
                                </label>
                                <input type="tel" name="phone" id="field-phone" class="block w-full h-11 px-3 border border-slate-200 rounded-lg text-sm text-slate-950 focus:ring-2 focus:ring-primary focus:border-transparent outline-none" placeholder="e.g. +27 82 987 6543">
                                <p class="text-[10px] text-slate-400 mt-1">Instant transactional broadcast SMS alerts.</p>
                            </div>
                        </div>

                        <!-- Pay summary dynamic widget box -->
                        <div class="bg-slate-50 border border-slate-200 rounded-xl p-5 space-y-4">
                            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Plan Summary Details</h4>
                            <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                                <span class="text-sm text-slate-700 font-semibold" id="sum-package-name">Basic Alert Alerts</span>
                                <span class="text-md font-bold text-primary" id="sum-package-price">R29.00 / month</span>
                            </div>

                            <div class="space-y-2">
                                <div class="flex justify-between items-center text-xs">
                                    <span class="text-slate-500">Categories setup:</span>
                                    <span class="font-semibold text-slate-700" id="sum-cat-count">0 selected</span>
                                </div>
                                <div class="flex justify-between items-center text-xs">
                                    <span class="text-slate-500">Provinces scope:</span>
                                    <span class="font-semibold text-slate-700" id="sum-prov-scope">None selected</span>
                                </div>
                                <div class="flex justify-between items-center text-xs">
                                    <span class="text-slate-500">Delivery channels:</span>
                                    <span class="font-semibold text-slate-700 text-right" id="sum-channels-list">EMAIL, WHATSAPP</span>
                                </div>
                            </div>

                            <div class="pt-4 border-t border-slate-100 space-y-3" id="payment-gateways-container">
                                <span class="text-xs text-slate-500 block">Indirect South African Secure Gateway Payfast / Ozow simulated sandbox:</span>
                                <div class="bg-white border border-slate-100 rounded-lg p-3 flex items-center justify-between cursor-pointer hover:border-primary transition-all">
                                    <span class="text-xs text-slate-700 font-bold flex items-center gap-1.5">
                                        <i data-lucide="credit-card" class="w-4 h-4 text-primary"></i> Pay via Credit/Debit card
                                    </span>
                                    <span class="text-[10px] bg-slate-100 text-slate-500 px-1.5 py-0.5 rounded font-mono">SECURE</span>
                                </div>
                            </div>

                            <button type="submit" class="w-full h-11 bg-primary text-white text-sm font-bold rounded-lg transition-all hover:opacity-95 active:scale-98 flex items-center justify-center gap-2 mt-4 cursor-pointer">
                                <i data-lucide="shield-check" class="w-5 h-5"></i>
                                <span>Activate Alerts Subscription</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Navigation Action Buttons -->
                <div class="flex items-center justify-between border-t border-slate-100 pt-6 mt-6">
                    <button type="button" onclick="prevStep()" id="btn-wizard-prev" class="text-xs font-bold px-4 py-2 border border-slate-200 rounded-lg text-slate-400 bg-slate-50 cursor-not-allowed" disabled>
                        Previous Step
                    </button>
                    <button type="button" onclick="nextStep()" id="btn-wizard-next" class="text-xs font-bold px-5 py-2.5 bg-primary text-white rounded-lg transition-all hover:opacity-95 cursor-pointer">
                        Next Step
                    </button>
                </div>
            </form>
        </div>

        <!-- Right Side info column -->
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-gradient-to-br from-indigo-900 to-primary text-white rounded-xl p-6 shadow-md relative overflow-hidden">
                <div class="absolute right-0 bottom-0 transform translate-x-12 translate-y-12 opacity-15">
                    <i data-lucide="bell" class="w-48 h-48"></i>
                </div>
                <h3 class="text-md font-bold mb-3 flex items-center gap-2">
                    <i data-lucide="sparkles" class="w-5 h-5 text-amber-300"></i>
                    Instant Tender Match alerts
                </h3>
                <p class="text-xs text-indigo-100 leading-relaxed">
                    Never miss out on potential revenue leads. Subscribed users report receiving updates up to 24 hours before they get published on legacy state portals.
                </p>

                <div class="mt-6 space-y-4 border-t border-white/10 pt-4">
                    <div class="flex items-start gap-3">
                        <div class="bg-white/10 p-1.5 rounded-lg text-white">
                            <i data-lucide="mail" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold">Email Digest Includes:</h4>
                            <p class="text-[10px] text-indigo-200">PDF Tender bulletins & direct submission guides.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="bg-white/10 p-1.5 rounded-lg text-green-300">
                            <i data-lucide="messages-square" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-emerald-200">Instant WhatsApp Delivery:</h4>
                            <p class="text-[10px] text-indigo-200">R29 or R49 subscriber notification broadcasts.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm space-y-4">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider flex items-center gap-1.5">
                    <i data-lucide="help-circle" class="w-4 h-4 text-primary"></i>
                    Frequently Asked Questions
                </h3>
                <div class="space-y-3">
                    <div>
                        <h4 class="text-xs font-bold text-slate-800">What is the R29 WhatsApp package?</h4>
                        <p class="text-[10px] text-slate-500 mt-1 leading-relaxed">
                            This plan lets you select up to 5 specific tender categories and 2 South African provinces. Direct alerts are broadcast immediately to your WhatsApp number.
                        </p>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-slate-800">Can I change my scope of filters?</h4>
                        <p class="text-[10px] text-slate-500 mt-1 leading-relaxed">
                            Yes. You can update your selected categories, organs of state, or provinces at any time from your subscriber alert settings workspace.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SUCCESS STATE DISPLAY (rendered dynamically via AJAX success) -->
    <div id="success-container" class="hidden max-w-xl mx-auto bg-white border border-slate-200 rounded-xl p-8 shadow-md text-center space-y-6 animate-fadeIn">
        <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4">
            <i data-lucide="check-circle" class="w-10 h-10"></i>
        </div>
        
        <div class="space-y-2">
            <h2 class="text-2xl font-bold text-slate-900">Subscription Active!</h2>
            <p class="text-slate-600 text-sm">
                Your tender notification dashboard alerts have been activated under the <strong id="success-package-name" class="text-primary">Basic Alert</strong>.
              </p>
        </div>

        <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 text-left space-y-2 text-xs">
            <div class="flex justify-between">
                <span class="text-slate-500">Subscription Ref ID:</span>
                <span class="font-mono font-bold text-slate-700" id="success-sub-ref">GT-000000</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-500">Plan Rate Charge:</span>
                <span class="font-semibold text-slate-700" id="success-sub-rate">R29.00 / mo</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-500">Routing Target:</span>
                <span class="font-semibold text-green-600" id="success-sub-channels">WHATSAPP, EMAIL</span>
            </div>
        </div>

        <div class="text-[11px] text-amber-700 bg-amber-50 p-3 rounded-lg flex items-center gap-2 border border-amber-200 text-left">
            <i data-lucide="alert-circle" class="w-4 h-4 shrink-0"></i>
            <span>We have sent a test notification payload. Please verify response link on selected alert channels to fully register updates.</span>
        </div>

        <a href="<?= base_url('/') ?>" class="w-full h-11 bg-primary text-white text-sm font-bold rounded-lg transition-all hover:opacity-95 active:scale-98 flex items-center justify-center">
            Return to Tender Workspace
        </a>
    </div>
</div>

<script>
    // State storage variables representing active configuration
    let currentStep = 'package'; // package, channels, filters, checkout
    let activePackageId = 'basic'; // free, basic, premium
    
    // Limits based on package
    let limits = {
        free:    { categories: 1, provinces: 1, channels: ['email'] },
        basic:   { categories: 5, provinces: 2, channels: ['email', 'whatsapp'] },
        premium: { categories: 10, provinces: 9, channels: ['email', 'whatsapp', 'sms', 'push'] }
    };

    // User chosen scoping arrays
    let selections = {
        categories: [],
        provinces: [],
        organs: [],
        channels: ['email', 'whatsapp'] // Default Basic setup
    };

    // 1. Navigation controllers
    function goToStep(stepId) {
        // Enforce validations upon step transitions
        if (stepId === 'channels' || stepId === 'filters' || stepId === 'checkout') {
            const err = validateStepCriteria();
            if (err) {
                showError(err);
                return;
            }
        }

        clearError();
        
        // Hide all panels
        document.getElementById('panel-package').classList.add('hidden');
        document.getElementById('panel-channels').classList.add('hidden');
        document.getElementById('panel-filters').classList.add('hidden');
        document.getElementById('panel-checkout').classList.add('hidden');

        // Show active
        document.getElementById('panel-' + stepId).classList.remove('hidden');

        // Toggle nav headers state
        const steps = ['package', 'channels', 'filters', 'checkout'];
        steps.forEach(st => {
            const el = document.getElementById('step-nav-' + st);
            if (st === stepId) {
                el.className = "text-left pb-3 border-b-2 border-primary text-primary font-bold transition-all";
            } else {
                el.className = "text-left pb-3 border-b-2 border-slate-200 text-slate-400 font-semibold hover:text-slate-600 transition-all";
            }
        });

        currentStep = stepId;

        // Toggle prev/next physical buttons
        const prevBtn = document.getElementById('btn-wizard-prev');
        const nextBtn = document.getElementById('btn-wizard-next');

        if (currentStep === 'package') {
            prevBtn.disabled = true;
            prevBtn.className = "text-xs font-bold px-4 py-2 border border-slate-200 rounded-lg text-slate-400 bg-slate-50 cursor-not-allowed";
        } else {
            prevBtn.disabled = false;
            prevBtn.className = "text-xs font-bold px-4 py-2 border border-slate-200 rounded-lg text-slate-700 bg-white hover:bg-slate-50 transition-colors";
        }

        if (currentStep === 'checkout') {
            nextBtn.classList.add('hidden');
            updateCheckoutSummary();
        } else {
            nextBtn.classList.remove('hidden');
        }
    }

    function nextStep() {
        if (currentStep === 'package') goToStep('channels');
        else if (currentStep === 'channels') goToStep('filters');
        else if (currentStep === 'filters') goToStep('checkout');
    }

    function prevStep() {
        if (currentStep === 'channels') goToStep('package');
        else if (currentStep === 'filters') goToStep('channels');
        else if (currentStep === 'checkout') goToStep('filters');
    }

    // 2. Pricing Package Selection Handling
    function selectPackage(pkgId) {
        activePackageId = pkgId;
        document.getElementById('input-package-id').value = pkgId;

        // Visual updates of plans
        ['free', 'basic', 'premium'].forEach(p => {
            const card = document.getElementById('card-' + p);
            const btn = card.querySelector('button');
            if (p === pkgId) {
                card.className = "relative border-2 border-primary bg-primary/[0.02] shadow-md rounded-xl p-5 cursor-pointer hover:border-slate-300 transition-all flex flex-col justify-between";
                btn.className = "mt-5 w-full py-2 bg-primary text-white text-xs font-bold rounded-lg pointer-events-none";
                btn.innerText = "Selected";
            } else {
                card.className = "relative border-2 border-slate-200 rounded-xl p-5 cursor-pointer hover:border-slate-300 transition-all flex flex-col justify-between";
                btn.className = "mt-5 w-full py-2 bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-bold rounded-lg pointer-events-none";
                btn.innerText = "Choose Plan";
            }
        });

        // Align limits & filters matching selected plan parameters (downgrades)
        const activeLimit = limits[pkgId];
        
        // Downgrade selected categories/provinces representation if limits exceeded
        if (selections.categories.length > activeLimit.categories) {
            selections.categories = selections.categories.slice(0, activeLimit.categories);
            redrawSelectedMultiViews('category');
        }
        if (selections.provinces.length > activeLimit.provinces) {
            selections.provinces = selections.provinces.slice(0, activeLimit.provinces);
            redrawSelectedMultiViews('province');
        }

        // Align allowed delivery channels checking restricted choices
        if (pkgId === 'free') {
            selections.channels = ['email'];
        } else if (pkgId === 'basic') {
            selections.channels = selections.channels.filter(c => ['email', 'whatsapp'].includes(c));
            if (selections.channels.length === 0) selections.channels = ['email', 'whatsapp'];
        }

        syncChannelsView();
        updateLimitLabelsTextAndScopes();
        clearError();
    }

    // 3. Channels Delivery Toggler
    function toggleChannel(channelId) {
        const activeLimit = limits[activePackageId];
        
        // Check block restriction and handle auto suggest package upgrades easily!
        if (!activeLimit.channels.includes(channelId)) {
            selectPackage('premium');
            showError("Auto upgraded plan to Premium Max (R49/mo) to unlock push and SMS broadcast channels!");
            setTimeout(clearError, 4000);
            return;
        }

        const checkbox = document.getElementById('chk-' + channelId);
        checkbox.checked = !checkbox.checked;

        if (checkbox.checked) {
            if (!selections.channels.includes(channelId)) selections.channels.push(channelId);
        } else {
            selections.channels = selections.channels.filter(c => c !== channelId);
        }

        syncChannelsView();
    }

    function syncChannelsView() {
        const channelsList = ['email', 'whatsapp', 'sms', 'push'];
        const activeLimit = limits[activePackageId];

        channelsList.forEach(c => {
            const toggleBlock = document.getElementById('btn-chan-' + c);
            const badge = document.getElementById('badge-' + c);
            const checkbox = document.getElementById('chk-' + c);
            const restrictSpan = document.getElementById('restrict-' + c);

            // Setup disabled state visuals based on selected package rules
            if (!activeLimit.channels.includes(c)) {
                toggleBlock.classList.add('opacity-50', 'border-dashed');
                toggleBlock.classList.remove('border-primary', 'bg-primary/[0.02]');
                badge.innerText = 'Restricted';
                checkbox.checked = false;
                selections.channels = selections.channels.filter(ch => ch !== c);
                if (restrictSpan) restrictSpan.classList.remove('hidden');
            } else {
                toggleBlock.classList.remove('opacity-50', 'border-dashed');
                if (restrictSpan) restrictSpan.classList.add('hidden');
                
                const isSelected = selections.channels.includes(c);
                checkbox.checked = isSelected;

                if (isSelected) {
                    toggleBlock.className = "p-4 border-2 border-primary bg-primary/[0.02] rounded-xl text-left cursor-pointer transition-all";
                    badge.className = (c === 'whatsapp') ? 'text-green-600 font-bold' : (c === 'sms') ? 'text-blue-600 font-bold' : (c === 'push') ? 'text-amber-500 font-bold' : 'text-primary font-bold';
                    badge.innerText = '✓ Selected';
                } else {
                    toggleBlock.className = "p-4 border border-slate-100 rounded-xl text-left cursor-pointer hover:border-slate-200 transition-all";
                    badge.className = "text-slate-400 text-xs";
                    badge.innerText = 'Not Selected';
                }
            }
        });

        // Hide/Show dynamic target inputs on checkout
        document.getElementById('wrapper-input-email').style.display = selections.channels.includes('email') ? 'block' : 'none';
        document.getElementById('wrapper-input-whatsapp').style.display = selections.channels.includes('whatsapp') ? 'block' : 'none';
        
        if (selections.channels.includes('sms')) {
            document.getElementById('wrapper-input-phone').classList.remove('hidden');
        } else {
            document.getElementById('wrapper-input-phone').classList.add('hidden');
        }
    }

    // 4. Multiple selection Scopes handling & Searchable Dropdowns
    function toggleDropdownMenu(type) {
        const types = ['category', 'province', 'organ'];
        types.forEach(t => {
            const menu = document.getElementById('menu-' + t);
            const chevron = document.getElementById('chevron-' + t);
            if (t === type) {
                const isOpen = !menu.classList.contains('hidden');
                if (isOpen) {
                    menu.classList.add('hidden');
                    if (chevron) chevron.classList.remove('rotate-180');
                } else {
                    menu.classList.remove('hidden');
                    if (chevron) chevron.classList.add('rotate-180');
                    const searchInput = document.getElementById('search-input-' + t);
                    if (searchInput) searchInput.focus();
                }
            } else {
                if (menu) menu.classList.add('hidden');
                if (chevron) chevron.classList.remove('rotate-180');
            }
        });
    }

    function filterDropdownOptions(type, query) {
        const q = query.toLowerCase().trim();
        const items = document.querySelectorAll('.opt-item-' + type);
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

        const noMatch = document.getElementById('no-match-' + type);
        if (noMatch) {
            noMatch.style.display = (matchCount === 0) ? 'block' : 'none';
        }
    }

    function removeSelectedItem(type, name) {
        toggleMultiItem(type, name);
    }

    function toggleMultiItem(type, name) {
        const activeLimit = limits[activePackageId];
        const array = (type === 'category') ? selections.categories : (type === 'province') ? selections.provinces : selections.organs;
        const max = (type === 'category') ? activeLimit.categories : (type === 'province') ? activeLimit.provinces : 100;

        const idx = array.indexOf(name);
        if (idx > -1) {
            array.splice(idx, 1);
            clearError();
        } else {
            // Check boundaries
            if (array.length >= max) {
                // Auto upscale package to unlock more options for users
                if (activePackageId !== 'premium') {
                    selectPackage('premium');
                    array.push(name);
                    showError(`Auto upgraded option boundary limit scope. Plan is set to Premium Max (${limits.premium.categories} categories & All Provinces).`);
                    setTimeout(clearError, 4000);
                } else {
                    showError(`Your currently active package plan is limited to maximum ${max} ${type} tags.`);
                    return;
                }
            } else {
                array.push(name);
                clearError();
            }
        }

        redrawSelectedMultiViews(type);
        updateLimitLabelsTextAndScopes();
    }

    function redrawSelectedMultiViews(type) {
        const array = (type === 'category') ? selections.categories : (type === 'province') ? selections.provinces : selections.organs;
        const boxPrefix = 'box-' + type + '-';
        const chkPrefix = 'chk-' + type + '-';

        // Update list option row checkboxes
        const allItems = document.querySelectorAll(`[id^="${chkPrefix}"]`);
        allItems.forEach(item => {
            const itemName = item.id.replace(chkPrefix, '');
            const box = document.getElementById(boxPrefix + itemName);
            const isSelected = array.includes(itemName);

            if (isSelected) {
                item.className = "flex items-center justify-between p-2.5 rounded-lg text-xs bg-primary/5 text-primary font-bold cursor-pointer transition-all opt-item-" + type;
                if (box) {
                    box.className = "w-4 h-4 rounded border bg-primary border-primary text-white flex items-center justify-center font-bold text-[10px] shrink-0";
                    box.innerHTML = "✓";
                }
            } else {
                item.className = "flex items-center justify-between p-2.5 rounded-lg text-xs hover:bg-slate-50 text-slate-700 font-medium cursor-pointer transition-all opt-item-" + type;
                if (box) {
                    box.className = "w-4 h-4 rounded border border-slate-300 flex items-center justify-center bg-white shrink-0";
                    box.innerHTML = "";
                }
            }
        });

        // Update Trigger Chips Container
        const chipsContainer = document.getElementById('chips-' + type);
        if (chipsContainer) {
            if (array.length === 0) {
                const placeholder = (type === 'category') ? 'Select category...' : (type === 'province') ? 'Select province...' : 'Select organs of state...';
                chipsContainer.innerHTML = `<span class="text-xs text-slate-400 pl-1">${placeholder}</span>`;
            } else {
                let html = '';
                array.forEach(item => {
                    const safeName = item.replace(/'/g, "\\'");
                    html += `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-primary/10 text-primary text-xs font-semibold border border-primary/20">
                        <span>${item}</span>
                        <button type="button" onclick="event.stopPropagation(); removeSelectedItem('${type}', '${safeName}')" class="hover:bg-primary/20 rounded p-0.5 transition-colors">
                            <i data-lucide="x" class="w-3 h-3"></i>
                        </button>
                    </span>`;
                });
                chipsContainer.innerHTML = html;
                if (window.lucide) lucide.createIcons();
            }
        }
    }

    // Close dropdowns on outside click
    document.addEventListener('click', function(e) {
        ['category', 'province', 'organ'].forEach(t => {
            const wrapper = document.getElementById('dropdown-wrapper-' + t);
            if (wrapper && !wrapper.contains(e.target)) {
                const menu = document.getElementById('menu-' + t);
                const chevron = document.getElementById('chevron-' + t);
                if (menu) menu.classList.add('hidden');
                if (chevron) chevron.classList.remove('rotate-180');
            }
        });
    });

    function updateLimitLabelsTextAndScopes() {
        const activeLimit = limits[activePackageId];
        document.getElementById('lbl-cat-limit').innerText = `Selected: ${selections.categories.length} / Max ${activeLimit.categories}`;
        document.getElementById('lbl-prov-limit').innerText = `Selected: ${selections.provinces.length} / Max ${activeLimit.provinces}`;
    }

    // 5. Checkout Summarizer
    function updateCheckoutSummary() {
        const names = { free: 'Free Trial alerts', basic: 'Basic Alert alerts', premium: 'Premium Max alerts' };
        const rates = { free: 'R0.00 / month', basic: 'R29.00 / month', premium: 'R49.00 / month' };

        document.getElementById('sum-package-name').innerText = names[activePackageId];
        document.getElementById('sum-package-price').innerText = rates[activePackageId];

        document.getElementById('sum-cat-count').innerText = selections.categories.length + ' selected';
        document.getElementById('sum-prov-scope').innerText = (selections.provinces.length > 0) ? selections.provinces.join(', ') : 'None chosen';
        document.getElementById('sum-channels-list').innerText = selections.channels.join(', ').toUpperCase();

        if (activePackageId === 'free') {
            document.getElementById('payment-gateways-container').style.display = 'none';
        } else {
            document.getElementById('payment-gateways-container').style.display = 'block';
        }
    }

    // 6. Validations
    function validateStepCriteria() {
        if (currentStep === 'package') {
            if (!activePackageId) return 'Please choose an alert subscription plan to continue.';
        }
        if (currentStep === 'channels') {
            if (selections.channels.length === 0) return 'Please specify at least one notification Delivery Channel option.';
        }
        if (currentStep === 'filters') {
            if (selections.categories.length === 0) return 'Please pick at least one tender Category filter scope to register alerts.';
            if (selections.provinces.length === 0) return 'Please select at least one Province destination.';
        }
        return null;
    }

    // 7. Error handlers helpers
    function showError(msg) {
        document.getElementById('validation-error').classList.remove('hidden');
        document.getElementById('error-message').innerText = msg;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function clearError() {
        document.getElementById('validation-error').classList.add('hidden');
    }

    // 8. Ajax Submissions Form
    document.getElementById('subscribe-form').addEventListener('submit', function(e) {
        e.preventDefault();
        clearError();

        const activeLimit = limits[activePackageId];
        const formData = new FormData(this);

        // Prepopulate arrays inside form payload manually matching Ajax structures
        selections.channels.forEach(ch => formData.append('channels[]', ch));
        selections.categories.forEach(ct => formData.append('categories[]', ct));
        selections.provinces.forEach(pr => formData.append('provinces[]', pr));
        selections.organs.forEach(or => formData.append('organs[]', or));

        // Submit via AJAX Fetch
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Display responsive success feedback screen
                document.getElementById('wizard-container').classList.add('hidden');
                document.getElementById('success-container').classList.remove('hidden');
                
                // Set metadata values
                document.getElementById('success-package-name').innerText = data.package_name + ' Alerts';
                document.getElementById('success-sub-ref').innerText = data.subscription_id;
                document.getElementById('success-sub-rate').innerText = 'R' + parseFloat(data.price).toFixed(2) + ' / mo';
                document.getElementById('success-sub-channels').innerText = selections.channels.join(', ').toUpperCase();
                
                lucide.createIcons();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            } else {
                showError(data.message);
            }
        })
        .catch(error => {
            showError("An error occurred during communication. Check your database setup rules.");
        });
    });

    // Run setup values automatically on view load
    updateLimitLabelsTextAndScopes();
</script>

<?= $this->endSection() ?>
