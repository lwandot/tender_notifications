<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="page-header">
    <div class="container">
        <h1 class="mb-0">
            <i class="fas fa-bell me-2"></i>Create New Subscription
        </h1>
    </div>
</div>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body p-5">
                    <form method="post" action="/subscription/create">
                        <?= csrf_field() ?>

                        <div class="mb-4">
                            <label for="filterType" class="form-label">Filter Type</label>
                            <select class="form-select" id="filterType" name="filter_type" required>
                                <option value="">Select an option...</option>
                                <option value="category">By Category</option>
                                <option value="province">By Province</option>
                                <option value="organ_of_state">By Organ of State</option>
                            </select>
                            <small class="form-text text-muted">
                                Choose what type of tenders you want to be notified about
                            </small>
                        </div>

                        <div class="mb-4" id="filterValueGroup" style="display:none;">
                            <label for="filterValue" class="form-label" id="filterValueLabel"></label>
                            <select class="form-select" id="filterValue" name="filter_value">
                                <option value="">Select...</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="notificationType" class="form-label">Notification Type</label>
                            <select class="form-select" id="notificationType" name="notification_type" required>
                                <option value="">Select...</option>
                                <option value="email">Email Notifications</option>
                                <option value="push">Push Notifications</option>
                                <option value="sms">SMS Notifications</option>
                            </select>
                            <small class="form-text text-muted">
                                Choose how you'd like to receive notifications
                            </small>
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="true" 
                                       id="isActive" name="is_active" checked>
                                <label class="form-check-label" for="isActive">
                                    Activate this subscription immediately
                                </label>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-check-circle me-2"></i>Create Subscription
                            </button>
                            <a href="/subscription" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('filterType').addEventListener('change', function() {
    const filterGroup = document.getElementById('filterValueGroup');
    const filterValueLabel = document.getElementById('filterValueLabel');
    const filterValue = document.getElementById('filterValue');
    const value = this.value;

    if (!value) {
        filterGroup.style.display = 'none';
        filterValue.innerHTML = '<option value="">Select...</option>';
        return;
    }

    filterGroup.style.display = 'block';

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
