<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title . ' - ' : '' ?>GovTenders</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#135bec",
                        "background-light": "#f6f6f8",
                        "background-dark": "#101622",
                    },
                    fontFamily: {
                        "display": ["Public Sans", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    }
                },
            },
        }
    </script>

    <style>
        body {
            font-family: 'Public Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 min-h-screen">
<div class="layout-container flex flex-col min-h-screen">
    <!-- Header -->
    <header class="flex items-center justify-between whitespace-nowrap border-b border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 px-6 md:px-10 py-4 sticky top-0 z-50">
        <div class="flex items-center gap-3">
            <div class="bg-primary text-white p-2 rounded-lg flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">gavel</span>
            </div>
            <h2 class="text-slate-900 dark:text-white text-xl font-bold leading-tight tracking-tight">GovTenders</h2>
        </div>
        <div class="flex items-center gap-4">
            <button class="hidden md:flex items-center justify-center gap-2 rounded-lg h-10 px-4 bg-primary text-white text-sm font-bold transition-opacity hover:opacity-90">
                <span class="material-symbols-outlined text-sm">notifications</span>
                <span class="truncate">Subscribe to Notifications</span>
            </button>
            <button class="md:hidden p-2 text-slate-600 dark:text-slate-400">
                <span class="material-symbols-outlined">menu</span>
            </button>
        </div>
    </header>

    <?php if (session()->has('success')): ?>
        <div class="mx-auto w-full max-w-[1440px] px-6 md:px-10 mt-4">
            <div class="rounded-lg bg-emerald-50 border border-emerald-200 px-4 py-3 text-emerald-800">
                <?= session()->getFlashdata('success') ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if (session()->has('error')): ?>
        <div class="mx-auto w-full max-w-[1440px] px-6 md:px-10 mt-4">
            <div class="rounded-lg bg-rose-50 border border-rose-200 px-4 py-3 text-rose-800">
                <?= session()->getFlashdata('error') ?>
            </div>
        </div>
    <?php endif; ?>

    <main class="flex flex-1 flex-col md:flex-row max-w-[1440px] mx-auto w-full">
        <?= $this->renderSection('content') ?>
    </main>

    <footer class="bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 py-6 px-10">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 max-w-[1440px] mx-auto w-full">
            <p class="text-slate-500 text-sm">© <?= date('Y') ?> Government Tender Portal. All rights reserved.</p>
            <div class="flex items-center gap-6">
                <a class="text-sm text-slate-500 hover:text-primary" href="#">Privacy Policy</a>
                <a class="text-sm text-slate-500 hover:text-primary" href="#">Terms of Service</a>
                <a class="text-sm text-slate-500 hover:text-primary" href="#">Help Center</a>
            </div>
        </div>
    </footer>
</div>

<?= $this->renderSection('scripts') ?>
</body>
</html>
