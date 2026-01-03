<!-- Page Header -->
<div class="mb-6">
    <h1 class="text-xl font-medium text-gray-800">Dashboard Laboran</h1>
    <p class="text-sm text-gray-500">
        <?php if (isset($current_semester) && $current_semester): ?>
            Semester: <?= $current_semester->nama_semester ?>     <?= $current_semester->tahun_ajaran ?>
        <?php endif; ?>
    </p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- My Mata Kuliah -->
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="font-medium text-gray-800 flex items-center gap-2">
                <span class="material-icons-outlined text-lg">menu_book</span>
                Mata Kuliah Saya
            </h2>
        </div>
        <div class="p-5">
            <?php if (!empty($my_matkul)): ?>
                <div class="space-y-3">
                    <?php foreach ($my_matkul as $matkul): ?>
                        <a href="<?= base_url('laboran/modul?matkul=' . $matkul->id) ?>"
                            class="block p-4 rounded-lg border border-gray-200 hover:border-brown-300 hover:bg-cream-50 transition">
                            <p class="font-medium text-gray-800"><?= htmlspecialchars($matkul->nama_matkul) ?></p>
                            <p class="text-sm text-gray-500"><?= $matkul->kode_matkul ?></p>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-8">
                    <span class="material-icons-outlined text-5xl text-gray-300 mb-3">menu_book</span>
                    <p class="text-gray-500">Belum ditugaskan ke mata kuliah</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="space-y-6">
        <div class="grid grid-cols-2 gap-4">
            <a href="<?= base_url('laboran/upload') ?>"
                class="bg-brown-500 hover:bg-brown-600 text-white rounded-xl p-6 text-center transition">
                <span class="material-icons-outlined text-4xl mb-2">upload_file</span>
                <p class="font-medium">Upload Modul</p>
            </a>
            <a href="<?= base_url('laboran/pertemuan') ?>"
                class="bg-gray-700 hover:bg-gray-800 text-white rounded-xl p-6 text-center transition">
                <span class="material-icons-outlined text-4xl mb-2">event</span>
                <p class="font-medium">Kelola Pertemuan</p>
            </a>
        </div>

        <!-- Recent Uploads -->
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h2 class="font-medium text-gray-800">Upload Terbaru</h2>
            </div>
            <?php if (!empty($my_moduls)): ?>
                <div class="divide-y divide-gray-100">
                    <?php foreach (array_slice($my_moduls, 0, 4) as $modul): ?>
                        <div class="px-5 py-3 flex items-center gap-3 hover:bg-gray-50">
                            <span class="material-icons-outlined text-gray-400">description</span>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-700 truncate">
                                    <?= htmlspecialchars($modul->judul_modul) ?></p>
                                <p class="text-xs text-gray-500">Pertemuan <?= $modul->pertemuan_ke ?></p>
                            </div>
                            <a href="<?= base_url('laboran/modul/edit/' . $modul->id) ?>"
                                class="text-brown-500 hover:text-brown-600">
                                <span class="material-icons-outlined text-lg">edit</span>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="p-8 text-center">
                    <span class="material-icons-outlined text-4xl text-gray-300 mb-2">cloud_upload</span>
                    <p class="text-gray-500 text-sm">Belum ada upload</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>