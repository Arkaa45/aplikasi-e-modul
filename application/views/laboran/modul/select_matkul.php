<!-- Page Header -->
<div class="mb-6">
    <h1 class="text-xl font-medium text-gray-800">
        <?= $page_title ?>
    </h1>
    <p class="text-sm text-gray-500">Pilih mata kuliah untuk mulai mengupload modul</p>
</div>

<?php if (!$current_semester): ?>
    <div class="p-4 bg-amber-50 border border-amber-200 text-amber-700 rounded-lg flex items-center gap-3">
        <span class="material-icons-outlined">warning</span>
        Belum ada semester aktif. Hubungi admin untuk mengaktifkan semester.
    </div>
<?php else: ?>

    <!-- Semester Badge -->
    <div class="mb-6 inline-flex items-center gap-2 px-4 py-2 bg-brown-100 text-brown-700 rounded-full text-sm">
        <span class="material-icons-outlined text-lg">calendar_today</span>
        Semester:
        <?= $current_semester->nama_semester ?>
        <?= $current_semester->tahun_ajaran ?>
    </div>

    <!-- Matkul Selection -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php if (!empty($my_matkul)): ?>
            <?php foreach ($my_matkul as $matkul): ?>
                <a href="<?= base_url('laboran/upload/' . $matkul->id) ?>"
                    class="block bg-white rounded-xl border border-gray-200 p-6 hover:border-brown-400 hover:shadow-md transition card-hover">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-xl bg-brown-400 flex items-center justify-center">
                            <span class="material-icons-outlined text-white text-2xl">menu_book</span>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800">
                                <?= htmlspecialchars($matkul->nama_matkul) ?>
                            </h3>
                            <p class="text-sm text-gray-500">
                                <?= $matkul->kode_matkul ?>
                            </p>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-span-full bg-white rounded-xl border border-gray-200 p-12 text-center">
                <span class="material-icons-outlined text-5xl text-gray-300 mb-3">menu_book</span>
                <p class="text-gray-600 font-medium">Belum ditugaskan ke mata kuliah</p>
                <p class="text-gray-500 text-sm">Hubungi admin untuk penugasan</p>
            </div>
        <?php endif; ?>
    </div>

<?php endif; ?>