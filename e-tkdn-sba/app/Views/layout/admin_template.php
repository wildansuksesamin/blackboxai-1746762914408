<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard' ?> - E-TKDN SBA</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div x-data="{ sidebarOpen: false }" class="min-h-screen">
        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 w-64 bg-[#2A2859] transform lg:translate-x-0 transition-transform duration-200 ease-in-out"
             :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}">
            
            <!-- Logo -->
            <div class="flex items-center justify-center h-16 bg-[#23214C]">
                <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo" class="h-8">
            </div>

            <!-- Navigation -->
            <nav class="mt-5">
                <a href="<?= base_url('dashboard') ?>" 
                   class="flex items-center px-6 py-3 text-gray-100 hover:bg-[#23214C]">
                    <i class="fas fa-home w-5"></i>
                    <span class="mx-3">Dashboard</span>
                </a>
                
                <a href="<?= base_url('applications') ?>" 
                   class="flex items-center px-6 py-3 text-gray-100 hover:bg-[#23214C]">
                    <i class="fas fa-file-alt w-5"></i>
                    <span class="mx-3">Applications</span>
                </a>

                <?php if (session()->get('role') === 'admin'): ?>
                <a href="<?= base_url('users') ?>" 
                   class="flex items-center px-6 py-3 text-gray-100 hover:bg-[#23214C]">
                    <i class="fas fa-users w-5"></i>
                    <span class="mx-3">Users</span>
                </a>
                <?php endif; ?>

                <a href="<?= base_url('reports') ?>" 
                   class="flex items-center px-6 py-3 text-gray-100 hover:bg-[#23214C]">
                    <i class="fas fa-chart-bar w-5"></i>
                    <span class="mx-3">Reports</span>
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="lg:pl-64">
            <!-- Top Navigation -->
            <div class="flex items-center justify-between h-16 bg-white px-6 shadow">
                <!-- Mobile menu button -->
                <button @click="sidebarOpen = !sidebarOpen" 
                        class="lg:hidden text-gray-500 hover:text-gray-600">
                    <i class="fas fa-bars"></i>
                </button>

                <!-- User Menu -->
                <div class="flex items-center">
                    <span class="text-gray-700 mr-4"><?= session()->get('username') ?></span>
                    <a href="<?= base_url('auth/logout') ?>" 
                       class="text-gray-500 hover:text-gray-600">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </div>
            </div>

            <!-- Page Content -->
            <main class="p-6">
                <?= $this->renderSection('content') ?>
            </main>
        </div>
    </div>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
