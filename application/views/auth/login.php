<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Login - E-Modul Praktikum' ?></title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        cream: { 50: '#fdfbf7', 100: '#f9f5ed', 200: '#f3ead9' },
                        brown: { 400: '#b08968', 500: '#9a7b5b', 600: '#7c6048', 700: '#5c4634' }
                    }
                }
            }
        }
    </script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>

<body class="bg-cream-50 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md">
        <!-- Logo & Title -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-brown-500 rounded-full mb-4">
                <span class="material-icons-outlined text-white text-3xl">school</span>
            </div>
            <h1 class="text-2xl font-normal text-gray-800">E-Modul Praktikum</h1>
            <p class="text-gray-500 mt-1">Masuk untuk melanjutkan</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">

            <!-- Flash Messages -->
            <?php if ($this->session->flashdata('error')): ?>
                <div
                    class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm flex items-center gap-2">
                    <span class="material-icons-outlined text-lg">error</span>
                    <?= $this->session->flashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('success')): ?>
                <div
                    class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm flex items-center gap-2">
                    <span class="material-icons-outlined text-lg">check_circle</span>
                    <?= $this->session->flashdata('success') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('auth/login') ?>" method="POST">
                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" name="email" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-400 focus:border-brown-400 outline-none transition"
                        placeholder="nama@email.com">
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-400 focus:border-brown-400 outline-none transition"
                        placeholder="Masukkan password">
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full bg-brown-500 hover:bg-brown-600 text-white font-medium py-3 px-4 rounded-lg transition duration-200">
                    Masuk
                </button>
            </form>
        </div>

        <!-- Footer -->
        <p class="text-center text-gray-400 text-sm mt-6">
            &copy; <?= date('Y') ?> E-Modul Praktikum. All rights reserved.
        </p>
    </div>

</body>

</html>