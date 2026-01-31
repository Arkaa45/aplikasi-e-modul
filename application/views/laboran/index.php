<!-- Page Header -->
<div class="mb-6">
    <h1 class="text-xl font-medium text-gray-800">
        <?= $page_title ?>
    </h1>
    <p class="text-sm text-gray-500">Kelola konten mata praktikum yang ditugaskan kepada Anda</p>
</div>

<!-- Mata Praktikum Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    <?php if (!empty($my_matkum)): ?>
        <?php foreach ($my_matkum as $matkum): ?>
            <a href="<?= base_url('laboran/matkum/' . $matkum->id) ?>"
                class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition card-hover">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-lg bg-brown-400 flex items-center justify-center flex-shrink-0">
                        <span class="material-icons-outlined text-white">menu_book</span>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-800">
                            <?= htmlspecialchars($matkum->nama_matkul) ?>
                        </h3>
                        <p class="text-sm text-gray-500">
                            <?= $matkum->kode_matkul ?>
                        </p>
                    </div>
                </div>
                <div class="mt-4 flex items-center justify-between">
                    <span class="text-sm text-gray-500">Kelola konten</span>
                    <span class="material-icons-outlined text-gray-400">arrow_forward</span>
                </div>
            </a>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-span-full bg-white rounded-xl border border-gray-200 p-12 text-center">
            <span class="material-icons-outlined text-5xl text-gray-300 mb-3">menu_book</span>
            <p class="text-gray-600 font-medium">Belum ditugaskan ke mata praktikum</p>
            <p class="text-gray-500 text-sm">Hubungi admin untuk penugasan</p>
        </div>
    <?php endif; ?>
</div>