<!-- Welcome Header -->
<div class="mb-6">
    <h1 class="text-xl font-medium text-gray-800">Selamat Datang,
        <?= htmlspecialchars($this->session->userdata('nama')) ?>!
    </h1>
    <p class="text-sm text-gray-500">Akses modul praktikum Anda kapan saja</p>
</div>

<!-- My Courses -->
<div class="mb-6">
    <h2 class="text-lg font-medium text-gray-800 mb-4"><?= $page_title ?></h2>

    <?php if (!empty($matkums)): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($matkums as $matkum): ?>
                <a href="<?= base_url('mahasiswa/matkum/' . $matkum->id) ?>"
                    class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition card-hover">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-lg bg-brown-400 flex items-center justify-center flex-shrink-0">
                            <span class="material-icons-outlined text-white">menu_book</span>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800"><?= htmlspecialchars($matkum->nama_matkul) ?></h3>
                            <p class="text-sm text-gray-500"><?= $matkum->kode_matkul ?> • <?= $matkum->sks ?> SKS</p>
                            <?php if ($matkum->deskripsi): ?>
                                <p class="text-xs text-gray-400 mt-1">
                                    <?= htmlspecialchars(substr($matkum->deskripsi, 0, 60)) ?>
                                    <?= strlen($matkum->deskripsi) > 60 ? '...' : '' ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="bg-white rounded-xl border border-gray-200 p-10 text-center">
            <span class="material-icons-outlined text-5xl text-gray-300 mb-3">menu_book</span>
            <p class="text-gray-600 font-medium">Belum terdaftar di mata praktikum</p>
            <p class="text-gray-500 text-sm">Hubungi admin untuk pendaftaran</p>
        </div>
    <?php endif; ?>
</div>

<!-- Info Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
    <div class="bg-cream-100 rounded-xl p-5 text-center">
        <span class="material-icons-outlined text-3xl text-brown-500 mb-2">smartphone</span>
        <h3 class="font-medium text-gray-800">Akses Mobile</h3>
        <p class="text-sm text-gray-600">Buka dari smartphone</p>
        <p class="text-sm text-gray-600">(SEGERA HADIR)</p> 
    </div>
    <div class="bg-cream-100 rounded-xl p-5 text-center">
        <span class="material-icons-outlined text-3xl text-brown-500 mb-2">download</span>
        <h3 class="font-medium text-gray-800">Download Offline</h3>
        <p class="text-sm text-gray-600">Unduh untuk belajar offline</p>
    </div>
    <div class="bg-cream-100 rounded-xl p-5 text-center">
        <span class="material-icons-outlined text-3xl text-brown-500 mb-2">visibility</span>
        <h3 class="font-medium text-gray-800">Lihat Konten</h3>
        <p class="text-sm text-gray-600">Akses RPS, Modul, dan Referensi</p>
    </div>
</div>