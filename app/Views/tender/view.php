<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<nav class="flex items-center gap-2 mb-6 text-sm px-6 md:px-10">
    <a class="text-slate-500 hover:text-primary dark:text-slate-400" href="/">Tender Browse</a>
    <span class="material-symbols-outlined text-slate-400 text-sm">chevron_right</span>
    <span class="text-slate-900 dark:text-slate-100 font-medium">Tender Details</span>
</nav>

<div class="px-6 md:px-10 py-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div class="flex flex-col gap-1">
            <h1 class="text-slate-900 dark:text-slate-100 text-3xl md:text-4xl font-black leading-tight tracking-tight">
                <?= esc($tender['procuring_entity']['name'] ?? 'Untitled Tender') ?>
            </h1>
            <p class="text-slate-500 dark:text-slate-400 text-lg">
                Tender Reference: <span class="font-semibold"><?= esc($tender['tender_number'] ?? ($tender['ocid'] ?? 'N/A')) ?></span>
            </p>
        </div>
        <a href="/" class="inline-flex items-center justify-center rounded-lg h-11 px-6 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-slate-100 text-sm font-bold border border-slate-200 dark:border-slate-700 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
            <span class="material-symbols-outlined mr-2">arrow_back</span>
            Back to Browse
        </a>
    </div>

    <!-- Tabs -->
    <div class="border-b border-slate-200 dark:border-slate-800 mb-8 overflow-x-auto">
        <div class="flex gap-8 min-w-max px-6 md:px-0">
            <a class="border-b-2 border-primary text-primary pb-3 font-bold text-sm px-1" href="#">Overview</a>
            <a class="border-b-2 border-transparent text-slate-500 dark:text-slate-400 pb-3 font-bold text-sm px-1 hover:text-slate-700 dark:hover:text-slate-200" href="#">Briefing &amp; Documents</a>
            <a class="border-b-2 border-transparent text-slate-500 dark:text-slate-400 pb-3 font-bold text-sm px-1 hover:text-slate-700 dark:hover:text-slate-200" href="#">Enquiries</a>
            <a class="border-b-2 border-transparent text-slate-500 dark:text-slate-400 pb-3 font-bold text-sm px-1 hover:text-slate-700 dark:hover:text-slate-200" href="#">Evaluation Criteria</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column: General Details & Enquiries -->
        <div class="lg:col-span-2 space-y-8">
            <!-- General Details Section -->
            <section class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 p-6 shadow-sm">
                <div class="flex items-center gap-2 mb-6 text-primary">
                    <span class="material-symbols-outlined">info</span>
                    <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100">General Details</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-12">
                    <div class="space-y-1">
                        <p class="text-xs uppercase tracking-wider text-slate-400 font-bold">Tender Number</p>
                        <p class="text-slate-900 dark:text-slate-100 font-medium"><?= esc($tender['tender_number'] ?? ($tender['ocid'] ?? 'N/A')) ?></p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-xs uppercase tracking-wider text-slate-400 font-bold">Organ of State</p>
                        <p class="text-slate-900 dark:text-slate-100 font-medium"><?= esc($tender['organ_of_state']['name'] ?? 'N/A') ?></p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-xs uppercase tracking-wider text-slate-400 font-bold">Tender Type</p>
                        <p class="text-slate-900 dark:text-slate-100 font-medium"><?= esc($tender['tender_type'] ? ucfirst($tender['tender_type']) : 'N/A') ?></p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-xs uppercase tracking-wider text-slate-400 font-bold">Province</p>
                        <p class="text-slate-900 dark:text-slate-100 font-medium"><?= esc($tender['province'] ?? 'N/A') ?></p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-xs uppercase tracking-wider text-slate-400 font-bold">Date Published</p>
                        <p class="text-slate-900 dark:text-slate-100 font-medium"><?= isset($tender['published_date']) ? date('F j, Y', strtotime($tender['published_date'])) : 'N/A' ?></p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-xs uppercase tracking-wider text-slate-400 font-bold">Closing Date</p>
                        <p class="text-primary font-bold"><?= isset($tender['closing_date']) ? date('F j, Y \@ h:i A', strtotime($tender['closing_date'])) : 'TBD' ?></p>
                    </div>
                </div>
                <div class="mt-8 pt-6 border-t border-slate-100 dark:border-slate-800">
                    <h3 class="font-bold text-slate-900 dark:text-slate-100 mb-3">Tender Description</h3>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                        <?= esc($tender['description'] ?? 'No description available.') ?>
                    </p>
                </div>
            </section>

            <!-- Enquiries Section -->
            <section class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 p-6 shadow-sm">
                <div class="flex items-center gap-2 mb-6 text-primary">
                    <span class="material-symbols-outlined">contact_support</span>
                    <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100">Enquiries</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-background-light dark:bg-slate-800/50 p-4 rounded-lg">
                        <p class="font-bold text-slate-900 dark:text-slate-100 mb-3 flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">person</span>
                            Technical Enquiries
                        </p>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-slate-500">Contact Person:</span>
                                <span class="font-medium"><?= esc($tender['contactPerson']['name'] ?? 'TBA') ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-500">Email:</span>
                                <span class="font-medium"><a class="text-primary hover:underline" href="mailto:<?= esc($tender['contactPerson']['email'] ?? 'info@gov.za') ?>"><?= esc($tender['contactPerson']['email'] ?? 'N/A') ?></a></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-500">Telephone:</span>
                                <span class="font-medium"><?= esc($tender['contactPerson']['telephoneNumber'] ?? 'N/A') ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-background-light dark:bg-slate-800/50 p-4 rounded-lg">
                        <p class="font-bold text-slate-900 dark:text-slate-100 mb-3 flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">payments</span>
                            SCM Enquiries
                        </p>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-slate-500">Contact Person:</span>
                                <span class="font-medium"><?= esc($tender['contactPerson']['name'] ?? 'TBA') ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-500">Email:</span>
                                <span class="font-medium"><a class="text-primary hover:underline" href="mailto:<?= esc($tender['contactPerson']['email'] ?? 'TBA') ?>"><?= esc($tender['contactPerson']['email'] ?? 'TBA') ?></a></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-500">Telephone:</span>
                                <span class="font-medium"><?= esc($tender['contactPerson']['telephoneNumber'] ?? 'N/A') ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Right Column: Briefing & Documents -->
        <div class="space-y-8">
            <!-- Briefing Session -->
            <section class="bg-primary/5 dark:bg-primary/10 rounded-xl border border-primary/20 p-6 shadow-sm">
                <div class="flex items-center gap-2 mb-4 text-primary">
                    <span class="material-symbols-outlined">event</span>
                    <h2 class="text-xl font-bold">Briefing Session</h2>
                </div>
                <div class="space-y-4">
                    <div class="flex gap-3">
                        <span class="material-symbols-outlined text-slate-400">calendar_today</span>
                        <div>
                            <p class="text-xs uppercase font-bold text-slate-400">Date &amp; Time</p>
                            <p class="text-slate-900 dark:text-slate-100 font-medium"><?= esc($tender['briefing_session']['date'] ?? 'TBA') ?></p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <span class="material-symbols-outlined text-slate-400">location_on</span>
                        <div>
                            <p class="text-xs uppercase font-bold text-slate-400">Venue</p>
                            <p class="text-slate-900 dark:text-slate-100 font-medium"><?= esc($tender['briefing_session']['venue'] ?? 'TBA') ?></p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <span class="material-symbols-outlined text-slate-400">task_alt</span>
                        <div>
                            <p class="text-xs uppercase font-bold text-slate-400">Compulsory</p>
                            <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-bold text-red-700">YES</span>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-primary/10">
                        <div class="w-full h-32 bg-slate-200 dark:bg-slate-700 rounded-lg overflow-hidden relative">
                            <img class="w-full h-full object-cover opacity-50 dark:opacity-30" data-alt="Stylized map showing Johannesburg city center" data-location="Johannesburg" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAwwum-UaXLvRzSCu6LmiPbSsWRFJgo9irJZdwbhUUGl16f3kDms_LlGxu3US16t4hfKtfVFUGy-oT-hhEB4M5VWVrthTMeko-VkN68puxKZi5KNZAed24GfjuFLiqXyY2uMMS2dFkGl1OSf88_2df1W_VDi65nDDEu403vzlk_E6tFdBTFx-JfqgbItGSjdn2KR1XfW3X_EQsGKhlsEyx5LzbuIX2W0wrBK8blNRL73A0E6QX4Ymouzg3Nofr22Aaz9JMB0l7Qcw" alt="Map placeholder">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <button class="bg-white dark:bg-slate-900 text-primary font-bold px-4 py-2 rounded-lg text-xs shadow-lg flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm">map</span>
                                    View Map
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Documents Section -->
            <section class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 p-6 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-2 text-primary">
                        <span class="material-symbols-outlined">description</span>
                        <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100">Documents</h2>
                    </div>
                    <span class="bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 text-xs font-bold px-2 py-1 rounded"><?= isset($tender['documents']) ? count($tender['documents']) : 0 ?> Files</span>
                </div>
                <div class="space-y-3">
                    <?php if (!empty($tender['documents'])): ?>
                        <?php foreach ($tender['documents'] as $doc): ?>
                            <div class="group flex items-center justify-between p-3 rounded-lg border border-slate-100 dark:border-slate-800 hover:border-primary/50 hover:bg-primary/5 transition-all cursor-pointer">
                                <div class="flex items-center gap-3">
                                    <div class="size-10 bg-red-50 dark:bg-red-900/20 flex items-center justify-center rounded">
                                        <span class="material-symbols-outlined text-red-600">picture_as_pdf</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-900 dark:text-slate-100"><?= esc($doc['title'] ?? 'Document') ?></p>
                                        <p class="text-xs text-slate-500"><?= esc($doc['size'] ?? '—') ?> <?= esc($doc['format'] ?? '') ?></p>
                                    </div>
                                </div>
                                <span class="material-symbols-outlined text-slate-400 group-hover:text-primary">download</span>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-slate-500 dark:text-slate-400">No documents available yet.</p>
                    <?php endif; ?>
                </div>
                <button class="w-full mt-6 py-3 border-2 border-dashed border-slate-200 dark:border-slate-700 rounded-lg text-slate-400 text-sm font-bold hover:border-primary hover:text-primary transition-colors">
                    Download All (ZIP)
                </button>
            </section>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
