<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="flex flex-1 flex-col md:flex-row w-full">
    <!-- Main Content Area -->
    <section class="flex-1 p-6 md:p-10 space-y-8">
        <div class="max-w-2xl mx-auto">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">Create New Subscription</h1>
                <p class="text-slate-500 dark:text-slate-400">Get notified when new tenders match your criteria</p>
            </div>

            <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 p-8 shadow-sm">
                <form method="post" action="/subscription/create" class="space-y-6">
                    <?= csrf_field() ?>

                    <div>
                        <label for="filterType" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Filter Type
                        </label>
                        <select
                            id="filterType"
                            name="filter_type"
                            required
                            class="block w-full px-4 py-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent text-slate-900 dark:text-white"
                        >
                            <option value="">Select an option...</option>
                            <option value="category">By Category</option>
                            <option value="province">By Province</option>
                            <option value="organ_of_state">By Organ of State</option>
                        </select>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                            Choose what type of tenders you want to be notified about
                        </p>
                    </div>

                    <div id="filterValueGroup" class="hidden">
                        <label for="filterValue" id="filterValueLabel" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2"></label>
                        <select
                            id="filterValue"
                            name="filter_value"
                            class="block w-full px-4 py-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent text-slate-900 dark:text-white"
                        >
                            <option value="">Select...</option>
                        </select>
                    </div>

                    <div>
                        <label for="notificationType" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Notification Type
                        </label>
                        <select
                            id="notificationType"
                            name="notification_type"
                            required
                            class="block w-full px-4 py-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent text-slate-900 dark:text-white"
                        >
                            <option value="">Select...</option>
                            <option value="email">Email Notifications</option>
                            <option value="push">Push Notifications</option>
                            <option value="sms">SMS Notifications</option>
                        </select>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                            Choose how you'd like to receive notifications
                        </p>
                    </div>

                    <div class="flex items-start gap-3">
                        <input
                            type="checkbox"
                            id="isActive"
                            name="is_active"
                            value="true"
                            checked
                            class="mt-1 h-4 w-4 text-primary border-slate-200 dark:border-slate-800 rounded focus:ring-primary"
                        >
                        <label for="isActive" class="text-sm text-slate-700 dark:text-slate-300">
                            Activate this subscription immediately
                        </label>
                    </div>

                    <div class="flex gap-4 pt-4">
                        <button
                            type="submit"
                            class="flex-1 bg-primary text-white py-3 px-4 rounded-lg font-bold hover:bg-primary/90 transition-colors flex items-center justify-center gap-2"
                        >
                            <span class="material-symbols-outlined text-sm">check_circle</span>
                            Create Subscription
                        </button>
                        <a
                            href="/subscription"
                            class="flex-1 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-slate-100 py-3 px-4 rounded-lg font-bold hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors flex items-center justify-center gap-2"
                        >
                            <span class="material-symbols-outlined text-sm">cancel</span>
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<script>
document.getElementById('filterType').addEventListener('change', function() {
    const filterGroup = document.getElementById('filterValueGroup');
    const filterValueLabel = document.getElementById('filterValueLabel');
    const filterValue = document.getElementById('filterValue');
    const value = this.value;

    if (!value) {
        filterGroup.classList.add('hidden');
        filterValue.innerHTML = '<option value="">Select...</option>';
        return;
    }

    filterGroup.classList.remove('hidden');

    // Populate filter options based on selected type
    let options = '<option value="">Select...</option>';

    if (value === 'category') {
        filterValueLabel.textContent = 'Select Category';
        // These should be populated from the server
        options += '<option value="1">Category 1</option><option value="2">Category 2</option>';
    } else if (value === 'province') {
        filterValueLabel.textContent = 'Select Province';
        options += '<option value="1">Province 1</option><option value="2">Province 2</option>';
    } else if (value === 'organ_of_state') {
        filterValueLabel.textContent = 'Select Organ of State';
        options += '<option value="1">Organ 1</option><option value="2">Organ 2</option>';
    }

    filterValue.innerHTML = options;
});
</script>

<?= $this->endSection() ?>
