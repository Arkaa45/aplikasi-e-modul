<!-- Sidebar Overlay (Mobile) -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden" onclick="closeSidebar()">
</div>

<!-- Sidebar -->
<aside id="sidebar"
    class="fixed top-16 left-0 w-72 h-[calc(100vh-4rem)] bg-white border-r border-gray-200 z-40 sidebar-transition -translate-x-full lg:translate-x-0 overflow-y-auto">
    <nav class="py-4">
        <?php $role = $this->session->userdata('role'); ?>
        <?php $current_url = uri_string(); ?>

        <!-- Main Menu -->
        <div class="px-3 mb-2">
            <a href="<?= base_url('dashboard') ?>"
                class="flex items-center gap-3 px-3 py-2.5 rounded-full text-sm font-medium <?= $current_url == 'dashboard' ? 'bg-brown-100 text-brown-700' : 'text-gray-700 hover:bg-gray-100' ?>">
                <span class="material-icons-outlined text-xl">home</span>
                Beranda
            </a>
        </div>

        <?php if ($role == 'admin'): ?>
            <!-- Admin Menu -->
            <div class="px-3 pt-4 pb-2">
                <p class="px-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Manajemen</p>
            </div>
            <div class="px-3 space-y-1">
                <a href="<?= base_url('admin/users') ?>"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-full text-sm font-medium <?= strpos($current_url, 'admin/users') !== false ? 'bg-brown-100 text-brown-700' : 'text-gray-700 hover:bg-gray-100' ?>">
                    <span class="material-icons-outlined text-xl">people</span>
                    Kelola User
                </a>
                <a href="<?= base_url('admin/semester') ?>"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-full text-sm font-medium <?= strpos($current_url, 'admin/semester') !== false ? 'bg-brown-100 text-brown-700' : 'text-gray-700 hover:bg-gray-100' ?>">
                    <span class="material-icons-outlined text-xl">calendar_month</span>
                    Kelola Semester
                </a>
                <a href="<?= base_url('admin/matkul') ?>"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-full text-sm font-medium <?= strpos($current_url, 'admin/matkul') !== false ? 'bg-brown-100 text-brown-700' : 'text-gray-700 hover:bg-gray-100' ?>">
                    <span class="material-icons-outlined text-xl">menu_book</span>
                    Kelola Mata Kuliah
                </a>
                <a href="<?= base_url('admin/activity') ?>"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-full text-sm font-medium <?= strpos($current_url, 'admin/activity') !== false ? 'bg-brown-100 text-brown-700' : 'text-gray-700 hover:bg-gray-100' ?>">
                    <span class="material-icons-outlined text-xl">history</span>
                    Log Aktivitas
                </a>
            </div>

        <?php elseif ($role == 'laboran'): ?>
            <!-- Laboran Menu -->
            <div class="px-3 pt-4 pb-2">
                <p class="px-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Kelola Praktikum</p>
            </div>
            <div class="px-3 space-y-1">
                <a href="<?= base_url('laboran/modul') ?>"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-full text-sm font-medium <?= strpos($current_url, 'laboran/modul') !== false ? 'bg-brown-100 text-brown-700' : 'text-gray-700 hover:bg-gray-100' ?>">
                    <span class="material-icons-outlined text-xl">description</span>
                    Kelola Modul
                </a>
                <a href="<?= base_url('laboran/upload') ?>"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-full text-sm font-medium <?= strpos($current_url, 'laboran/upload') !== false ? 'bg-brown-100 text-brown-700' : 'text-gray-700 hover:bg-gray-100' ?>">
                    <span class="material-icons-outlined text-xl">upload_file</span>
                    Upload Modul
                </a>
                <a href="<?= base_url('laboran/pertemuan') ?>"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-full text-sm font-medium <?= strpos($current_url, 'laboran/pertemuan') !== false ? 'bg-brown-100 text-brown-700' : 'text-gray-700 hover:bg-gray-100' ?>">
                    <span class="material-icons-outlined text-xl">event</span>
                    Kelola Pertemuan
                </a>
            </div>

        <?php elseif ($role == 'mahasiswa'): ?>
            <!-- Mahasiswa Menu -->
            <div class="px-3 pt-4 pb-2">
                <p class="px-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Akses Modul</p>
            </div>
            <div class="px-3 space-y-1">
                <a href="<?= base_url('mahasiswa/semester') ?>"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-full text-sm font-medium <?= strpos($current_url, 'mahasiswa/semester') !== false ? 'bg-brown-100 text-brown-700' : 'text-gray-700 hover:bg-gray-100' ?>">
                    <span class="material-icons-outlined text-xl">calendar_today</span>
                    Pilih Semester
                </a>
            </div>
        <?php endif; ?>

    </nav>
</aside>

<!-- Main Content -->
<main class="lg:ml-72 pt-16 min-h-screen">
    <div class="p-4 md:p-6 lg:p-8">

        <!-- Flash Messages -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center gap-3"
                id="alertSuccess">
                <span class="material-icons-outlined">check_circle</span>
                <span><?= $this->session->flashdata('success') ?></span>
                <button onclick="this.parentElement.remove()" class="ml-auto">
                    <span class="material-icons-outlined text-green-500">close</span>
                </button>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg flex items-center gap-3"
                id="alertError">
                <span class="material-icons-outlined">error</span>
                <span><?= $this->session->flashdata('error') ?></span>
                <button onclick="this.parentElement.remove()" class="ml-auto">
                    <span class="material-icons-outlined text-red-500">close</span>
                </button>
            </div>
        <?php endif; ?>