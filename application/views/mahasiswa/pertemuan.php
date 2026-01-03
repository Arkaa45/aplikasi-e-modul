<!-- Page Header -->
<div class="mb-6">
    <h1 class="text-xl font-medium text-gray-800"><?= $page_title ?></h1>
    <p class="text-sm text-gray-500">
        <a href="<?= base_url('dashboard') ?>" class="hover:text-brown-500">Dashboard</a>
        <span class="mx-2">/</span>
        <a href="<?= base_url('mahasiswa/matkul/' . $semester->id) ?>" class="hover:text-brown-500">Mata Kuliah</a>
        <span class="mx-2">/</span>
        <span>Pertemuan</span>
    </p>
</div>

<!-- Course Info -->
<div class="mb-6 p-5 bg-brown-500 text-white rounded-xl">
    <div class="flex items-center gap-4">
        <span class="material-icons-outlined text-4xl opacity-80">menu_book</span>
        <div>
            <h2 class="text-lg font-medium"><?= htmlspecialchars($matkul->nama_matkul) ?></h2>
            <p class="text-sm opacity-80"><?= $matkul->kode_matkul ?> • <?= $semester->nama_semester ?>
                <?= $semester->tahun_ajaran ?></p>
        </div>
    </div>
</div>

<!-- Pertemuan List -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    <?php if (!empty($pertemuan)): ?>
        <?php foreach ($pertemuan as $p): ?>
            <a href="<?= base_url('mahasiswa/modul/' . $p->id) ?>"
                class="block bg-white rounded-xl border border-gray-200 p-5 hover:border-brown-300 hover:shadow-md transition card-hover">
                <div class="flex items-start gap-3">
                    <div
                        class="w-10 h-10 rounded-lg bg-brown-100 flex items-center justify-center text-brown-700 font-semibold">
                        <?= $p->pertemuan_ke ?>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-medium text-gray-800"><?= htmlspecialchars($p->judul) ?></h3>
                        <?php if ($p->tanggal): ?>
                            <p class="text-xs text-gray-500 mt-1">
                                <span class="material-icons-outlined text-xs align-middle">calendar_today</span>
                                <?= date('d M Y', strtotime($p->tanggal)) ?>
                            </p>
                        <?php endif; ?>
                        <span class="inline-flex items-center gap-1 mt-2 px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded">
                            <span class="material-icons-outlined text-xs">description</span>
                            <?= $p->modul_count ?> Modul
                        </span>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-span-full bg-white rounded-xl border border-gray-200 p-12 text-center">
            <span class="material-icons-outlined text-5xl text-gray-300 mb-3">event</span>
            <p class="text-gray-500">Belum ada pertemuan</p>
            <a href="<?= base_url('mahasiswa/matkul/' . $semester->id) ?>"
                class="inline-flex items-center gap-2 px-4 py-2 bg-brown-500 text-white rounded-lg mt-4">
                <span class="material-icons-outlined text-lg">arrow_back</span>
                Kembali
            </a>
        </div>
    <?php endif; ?>
</div>