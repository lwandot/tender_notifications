<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'GovTenders - Professional State Tenders Notifications') ?></title>
    
    <!-- Tailwind CSS Playground CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Public Sans Visual Typography Pairing -->
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Lucide Vector Icons Library integration -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <style>
        body {
            font-family: 'Public Sans', sans-serif;
        }
    </style>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        "primary": "#135bec",
                        "background-light": "#f6f6f8",
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-background-light text-slate-900 min-h-screen">
    <div class="layout-container flex flex-col min-h-screen">
        
        <!-- CodeIgniter Navigation Header -->
        <header class="flex items-center justify-between border-b border-slate-200 bg-white px-6 md:px-10 py-4 sticky top-0 z-50 shadow-xs">
            <div class="flex items-center gap-3">
                <a href="<?= base_url('/') ?>" class="bg-primary text-white p-2 rounded-lg flex items-center justify-center hover:opacity-95">
                    <i data-lucide="gavel" class="w-6 h-6"></i>
                </a>
                <a href="<?= base_url('/') ?>" class="text-slate-900 text-xl font-bold leading-tight tracking-tight hover:text-primary transition-colors">
                    GovTenders
                </a>
            </div>
            
            <div class="flex items-center gap-4">
                <a href="<?= base_url('subscription') ?>" class="flex items-center justify-center gap-2 rounded-lg h-10 px-4 bg-primary text-white text-sm font-bold transition-all hover:opacity-90 active:scale-95 shadow-sm">
                    <i data-lucide="bell" class="w-4 h-4 hover:animate-bounce"></i>
                    <span>Subscribe to Notifications</span>
                </a>
            </div>
        </header>
