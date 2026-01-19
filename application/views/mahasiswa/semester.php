<!-- Page Header -->
<div class="mb-6">
    <h1 class="text-xl font-medium text-gray-800"><?= $page_title ?></h1>
    <p class="text-sm text-gray-500">
        <a href="<?= base_url('mahasiswa') ?>" class="hover:text-brown-500">Dashboard</a>
        <span class="mx-2">/</span>
        <span><?= $semester->nama_semester ?> <?= $semester->tahun_ajaran ?></span>
    </p>
</div>

<!-- Mata Praktikum List -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    <?php if (!empty($matkums)): ?>
        <?php foreach ($matkums as $matkum): ?>
            <a href="<?= base_url('mahasiswa/matkum/' . $matkum->id . '/' . $semester->id) ?>"
                class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition card-hover">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-lg bg-brown-400 flex items-center justify-center flex-shrink-0">
                        <span class="material-icons-outlined text-white">menu_book</span>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-800"><?= htmlspecialchars($matkum->nama_matkul) ?></h3>
                        <p class="text-sm text-gray-500"><?= $matkum->kode_matkul ?></p>
                    </div>
                </div>
                <div class="mt-4 flex items-center justify-between">
                    <span class="text-sm text-gray-500">Lihat konten</span>
                    <span class="material-icons-outlined text-gray-400">arrow_forward</span>
                </div>
            </a>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-span-full bg-white rounded-xl border border-gray-200 p-12 text-center">
            <span class="material-icons-outlined text-5xl text-gray-300 mb-3">menu_book</span>
            <p class="text-gray-600 font-medium">Tidak ada mata praktikum di semester ini</p>
        </div>
    <?php endif; ?>
</div>

<div class="mt-6">
    <a href="<?= base_url('mahasiswa') ?>"
        class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
        <span class="material-icons-outlined">arrow_back</span>
        Kembali
    </a>
</div>