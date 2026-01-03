<!-- Page Header -->
<div class="mb-6">
    <h1 class="text-xl font-medium text-gray-800"><?= $page_title ?></h1>
    <p class="text-sm text-gray-500">
        <a href="<?= base_url('dashboard') ?>" class="hover:text-brown-500">Dashboard</a>
        <span class="mx-2">/</span>
        <a href="<?= base_url('mahasiswa/semester') ?>" class="hover:text-brown-500">Semester</a>
        <span class="mx-2">/</span>
        <span>Mata Kuliah</span>
    </p>
</div>

<!-- Semester Info -->
<div class="mb-6 p-4 bg-cream-100 rounded-xl flex items-center gap-3">
    <span class="material-icons-outlined text-brown-500">calendar_today</span>
    <div>
        <p class="font-medium text-gray-800"><?= htmlspecialchars($semester->nama_semester) ?>
            <?= $semester->tahun_ajaran ?></p>
        <p class="text-sm text-gray-500"><?= date('d M Y', strtotime($semester->tanggal_mulai)) ?> -
            <?= date('d M Y', strtotime($semester->tanggal_selesai)) ?></p>
    </div>
    <?php if ($semester->is_active): ?>
        <span class="ml-auto px-3 py-1 bg-green-100 text-green-700 text-xs rounded-full">Aktif</span>
    <?php endif; ?>
</div>

<!-- Matkul Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    <?php if (!empty($matkuls)): ?>
        <?php foreach ($matkuls as $matkul): ?>
            <a href="<?= base_url('mahasiswa/pertemuan/' . $matkul->id . '?semester=' . $semester->id) ?>"
                class="block bg-white rounded-xl border border-gray-200 p-5 hover:border-brown-300 hover:shadow-md transition card-hover">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-lg bg-brown-400 flex items-center justify-center flex-shrink-0">
                        <span class="material-icons-outlined text-white">menu_book</span>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-800"><?= htmlspecialchars($matkul->nama_matkul) ?></h3>
                        <p class="text-sm text-gray-500"><?= $matkul->kode_matkul ?> • <?= $matkul->sks ?> SKS</p>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-span-full bg-white rounded-xl border border-gray-200 p-12 text-center">
            <span class="material-icons-outlined text-5xl text-gray-300 mb-3">menu_book</span>
            <p class="text-gray-600 font-medium">Tidak terdaftar di mata kuliah</p>
            <p class="text-gray-500 text-sm mb-4">Anda belum terdaftar di mata kuliah untuk semester ini</p>
            <a href="<?= base_url('mahasiswa/semester') ?>"
                class="inline-flex items-center gap-2 px-4 py-2 bg-brown-500 text-white rounded-lg">
                <span class="material-icons-outlined text-lg">arrow_back</span>
                Pilih Semester Lain
            </a>
        </div>
    <?php endif; ?>
</div>