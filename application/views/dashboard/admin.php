<!-- Page Header -->
<div class="mb-6">
    <h1 class="text-xl font-medium text-gray-800">Dashboard Admin</h1>
    <p class="text-sm text-gray-500">
        <?php if (isset($current_semester) && $current_semester): ?>
            Semester Aktif: <?= $current_semester->nama_semester ?>     <?= $current_semester->tahun_ajaran ?>
        <?php else: ?>
            Belum ada semester aktif
        <?php endif; ?>
    </p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-gray-200 p-5 card-hover">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-brown-100 flex items-center justify-center">
                <span class="material-icons-outlined text-brown-600">people</span>
            </div>
            <div>
                <p class="text-2xl font-semibold text-gray-800"><?= $total_users ?? 0 ?></p>
                <p class="text-sm text-gray-500">Total Pengguna</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-5 card-hover">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                <span class="material-icons-outlined text-blue-600">school</span>
            </div>
            <div>
                <p class="text-2xl font-semibold text-gray-800"><?= $total_mahasiswa ?? 0 ?></p>
                <p class="text-sm text-gray-500">Mahasiswa</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-5 card-hover">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                <span class="material-icons-outlined text-green-600">badge</span>
            </div>
            <div>
                <p class="text-2xl font-semibold text-gray-800"><?= $total_laboran ?? 0 ?></p>
                <p class="text-sm text-gray-500">Laboran</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-5 card-hover">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center">
                <span class="material-icons-outlined text-amber-600">description</span>
            </div>
            <div>
                <p class="text-2xl font-semibold text-gray-800"><?= $total_modul ?? 0 ?></p>
                <p class="text-sm text-gray-500">Total Modul</p>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions & Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Quick Actions -->
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="font-medium text-gray-800 flex items-center gap-2">
                <span class="material-icons-outlined text-lg">bolt</span>
                Aksi Cepat
            </h2>
        </div>
        <div class="p-5 space-y-3">
            <a href="<?= base_url('admin/users/create') ?>"
                class="flex items-center gap-3 px-4 py-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition">
                <span class="material-icons-outlined text-gray-500">person_add</span>
                <span class="text-sm text-gray-700">Tambah User Baru</span>
            </a>
            <a href="<?= base_url('admin/semester/create') ?>"
                class="flex items-center gap-3 px-4 py-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition">
                <span class="material-icons-outlined text-gray-500">calendar_add_on</span>
                <span class="text-sm text-gray-700">Tambah Semester</span>
            </a>
            <a href="<?= base_url('admin/matkul/create') ?>"
                class="flex items-center gap-3 px-4 py-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition">
                <span class="material-icons-outlined text-gray-500">library_add</span>
                <span class="text-sm text-gray-700">Tambah Mata Kuliah</span>
            </a>
            <a href="<?= base_url('admin/activity') ?>"
                class="flex items-center gap-3 px-4 py-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition">
                <span class="material-icons-outlined text-gray-500">history</span>
                <span class="text-sm text-gray-700">Lihat Log Aktivitas</span>
            </a>
        </div>
    </div>

    <!-- Recent Moduls -->
    <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 flex justify-between items-center">
            <h2 class="font-medium text-gray-800 flex items-center gap-2">
                <span class="material-icons-outlined text-lg">schedule</span>
                Modul Terbaru
            </h2>
        </div>
        <?php if (!empty($recent_moduls)): ?>
            <div class="divide-y divide-gray-100">
                <?php foreach ($recent_moduls as $modul): ?>
                    <div class="px-5 py-4 hover:bg-gray-50">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center flex-shrink-0">
                                <span class="material-icons-outlined text-red-600">picture_as_pdf</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-800 truncate">
                                    <?= htmlspecialchars($modul->judul_modul) ?></p>
                                <p class="text-xs text-gray-500"><?= htmlspecialchars($modul->nama_matkul) ?></p>
                            </div>
                            <div class="text-right">
                                <span class="text-xs text-gray-400"><?= date('d M Y', strtotime($modul->created_at)) ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="p-10 text-center">
                <span class="material-icons-outlined text-5xl text-gray-300 mb-3">inbox</span>
                <p class="text-gray-500">Belum ada modul</p>
            </div>
        <?php endif; ?>
    </div>
</div>