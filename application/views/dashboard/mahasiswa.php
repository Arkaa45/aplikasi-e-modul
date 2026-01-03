<!-- Welcome Header -->
<div class="mb-6">
    <h1 class="text-xl font-medium text-gray-800">Selamat Datang, <?= htmlspecialchars($user['nama']) ?>!</h1>
    <p class="text-sm text-gray-500">Akses modul praktikum Anda kapan saja</p>
</div>

<!-- Current Semester Badge -->
<?php if (isset($current_semester) && $current_semester): ?>
    <div class="mb-6 inline-flex items-center gap-2 px-4 py-2 bg-brown-100 text-brown-700 rounded-full text-sm">
        <span class="material-icons-outlined text-lg">calendar_today</span>
        Semester Aktif: <?= $current_semester->nama_semester ?>     <?= $current_semester->tahun_ajaran ?>
    </div>
<?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- My Courses -->
    <div class="lg:col-span-2">
        <h2 class="text-sm font-medium text-gray-600 mb-4">Mata Kuliah Praktikum Saya</h2>

        <?php if (!empty($my_matkul)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php foreach ($my_matkul as $matkul): ?>
                    <a href="<?= base_url('mahasiswa/pertemuan/' . $matkul->id) ?>"
                        class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition card-hover">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-lg bg-brown-400 flex items-center justify-center flex-shrink-0">
                                <span class="material-icons-outlined text-white">menu_book</span>
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-800"><?= htmlspecialchars($matkul->nama_matkul) ?></h3>
                                <p class="text-sm text-gray-500"><?= $matkul->kode_matkul ?></p>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="bg-white rounded-xl border border-gray-200 p-10 text-center">
                <span class="material-icons-outlined text-5xl text-gray-300 mb-3">menu_book</span>
                <p class="text-gray-600 font-medium">Belum terdaftar di mata kuliah</p>
                <p class="text-gray-500 text-sm">Hubungi admin untuk pendaftaran</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Semester History -->
    <div>
        <h2 class="text-sm font-medium text-gray-600 mb-4">Riwayat Semester</h2>
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <?php if (!empty($accessible_semesters)): ?>
                <div class="divide-y divide-gray-100">
                    <?php foreach ($accessible_semesters as $semester): ?>
                        <a href="<?= base_url('mahasiswa/matkul/' . $semester->id) ?>"
                            class="block px-5 py-4 hover:bg-gray-50 transition">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-medium text-gray-800"><?= $semester->nama_semester ?></p>
                                    <p class="text-sm text-gray-500"><?= $semester->tahun_ajaran ?></p>
                                </div>
                                <?php if ($semester->is_active): ?>
                                    <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full">Aktif</span>
                                <?php else: ?>
                                    <span class="material-icons-outlined text-gray-400">chevron_right</span>
                                <?php endif; ?>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="p-8 text-center">
                    <span class="material-icons-outlined text-4xl text-gray-300 mb-2">calendar_today</span>
                    <p class="text-gray-500 text-sm">Tidak ada semester</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Info Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
    <div class="bg-cream-100 rounded-xl p-5 text-center">
        <span class="material-icons-outlined text-3xl text-brown-500 mb-2">smartphone</span>
        <h3 class="font-medium text-gray-800">Akses Mobile</h3>
        <p class="text-sm text-gray-600">Buka dari smartphone</p>
    </div>
    <div class="bg-cream-100 rounded-xl p-5 text-center">
        <span class="material-icons-outlined text-3xl text-brown-500 mb-2">download</span>
        <h3 class="font-medium text-gray-800">Download Offline</h3>
        <p class="text-sm text-gray-600">Unduh untuk belajar offline</p>
    </div>
    <div class="bg-cream-100 rounded-xl p-5 text-center">
        <span class="material-icons-outlined text-3xl text-brown-500 mb-2">history</span>
        <h3 class="font-medium text-gray-800">Akses Riwayat</h3>
        <p class="text-sm text-gray-600">Lihat semester sebelumnya</p>
    </div>
</div>