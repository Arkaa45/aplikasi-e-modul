<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ?? 'E-Modul Praktikum' ?></title>

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        cream: {
                            50: '#fdfbf7',
                            100: '#f9f5ed',
                            200: '#f3ead9',
                            300: '#e8d9be',
                            400: '#d9c19e',
                        },
                        brown: {
                            50: '#faf6f3',
                            100: '#f0e6df',
                            200: '#e0cdbf',
                            300: '#c9a98f',
                            400: '#b08968',
                            500: '#9a7b5b',
                            600: '#7c6048',
                            700: '#5c4634',
                            800: '#3d2e23',
                            900: '#1f1712',
                        }
                    },
                    fontFamily: {
                        'sans': ['Google Sans', 'Roboto', 'Arial', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }

        /* Sidebar transition */
        .sidebar-transition {
            transition: transform 0.3s ease-in-out;
        }

        /* Card hover effect */
        .card-hover:hover {
            box-shadow: 0 1px 3px 0 rgba(60, 64, 67, .3), 0 4px 8px 3px rgba(60, 64, 67, .15);
        }
    </style>
</head>

<body class="bg-cream-50 text-gray-800 min-h-screen">

    <!-- Top Navigation Bar -->
    <nav class="fixed top-0 left-0 right-0 h-16 bg-white border-b border-gray-200 z-50 flex items-center px-4">
        <!-- Menu Toggle & Logo -->
        <div class="flex items-center">
            <button id="sidebarToggle" class="p-2 rounded-full hover:bg-gray-100 mr-2 lg:hidden">
                <span class="material-icons-outlined text-gray-600">menu</span>
            </button>
            <a href="<?= base_url('dashboard') ?>" class="flex items-center">
                <span class="material-icons-outlined text-brown-500 text-3xl mr-2">school</span>
                <span class="text-xl font-normal text-gray-700 hidden sm:inline">E-Modul Praktikum</span>
            </a>
        </div>

        <!-- Spacer -->
        <div class="flex-1"></div>

        <!-- User Menu -->
        <div class="flex items-center gap-2">
            <!-- Current Role Badge -->
            <?php
            $role = $this->session->userdata('role');
            $role_colors = [
                'admin' => 'bg-red-100 text-red-700',
                'laboran' => 'bg-green-100 text-green-700',
                'mahasiswa' => 'bg-blue-100 text-blue-700'
            ];
            $role_color = $role_colors[$role] ?? 'bg-gray-100 text-gray-700';
            ?>
            <span class="px-3 py-1 rounded-full text-xs font-medium <?= $role_color ?> hidden sm:inline-block">
                <?= ucfirst($role) ?>
            </span>

            <!-- User Dropdown -->
            <div class="relative" id="userDropdown">
                <button class="flex items-center gap-2 p-1 rounded-full hover:bg-gray-100" onclick="toggleDropdown()">
                    <div
                        class="w-8 h-8 rounded-full bg-brown-400 flex items-center justify-center text-white text-sm font-medium">
                        <?= strtoupper(substr($this->session->userdata('nama') ?? 'U', 0, 1)) ?>
                    </div>
                </button>

                <!-- Dropdown Menu -->
                <div id="dropdownMenu"
                    class="hidden absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-lg border border-gray-200 py-2">
                    <div class="px-4 py-3 border-b border-gray-100">
                        <p class="text-sm font-medium text-gray-900"><?= $this->session->userdata('nama') ?></p>
                        <p class="text-xs text-gray-500"><?= $this->session->userdata('email') ?></p>
                    </div>
                    <a href="<?= base_url('auth/logout') ?>"
                        class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                        <span class="material-icons-outlined text-gray-500 text-xl">logout</span>
                        Keluar
                    </a>
                </div>
            </div>
        </div>
    </nav>