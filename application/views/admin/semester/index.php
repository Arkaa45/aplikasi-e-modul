<!-- Page Header -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-xl font-medium text-gray-800"><?= $page_title ?></h1>
        <p class="text-sm text-gray-500">Kelola periode semester akademik</p>
    </div>
    <a href="<?= base_url('admin/semester/create') ?>"
        class="inline-flex items-center gap-2 px-4 py-2 bg-brown-500 hover:bg-brown-600 text-white rounded-lg transition">
        <span class="material-icons-outlined text-lg">add</span>
        Tambah Semester
    </a>
</div>

<!-- Semester Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    <?php if (!empty($semesters)): ?>
        <?php foreach ($semesters as $semester): ?>
            <div
                class="bg-white rounded-xl border <?= $semester->is_active ? 'border-green-300 ring-2 ring-green-100' : 'border-gray-200' ?> overflow-hidden card-hover">
                <div class="p-5">
                    <?php if ($semester->is_active): ?>
                        <span
                            class="inline-flex items-center gap-1 px-2 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full mb-3">
                            <span class="material-icons-outlined text-sm">check_circle</span> Aktif
                        </span>
                    <?php endif; ?>

                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-12 h-12 rounded-lg bg-brown-100 flex items-center justify-center">
                            <span class="material-icons-outlined text-brown-600">calendar_month</span>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800"><?= htmlspecialchars($semester->nama_semester) ?></h3>
                            <p class="text-lg font-semibold text-brown-600"><?= htmlspecialchars($semester->tahun_ajaran) ?></p>
                        </div>
                    </div>

                    <p class="text-sm text-gray-500 mb-4">
                        <span class="material-icons-outlined text-sm align-middle">date_range</span>
                        <?= date('d M Y', strtotime($semester->tanggal_mulai)) ?> -
                        <?= date('d M Y', strtotime($semester->tanggal_selesai)) ?>
                    </p>

                    <div class="flex gap-2">
                        <?php if (!$semester->is_active): ?>
                            <a href="<?= base_url('admin/semester/activate/' . $semester->id) ?>"
                                class="flex-1 px-3 py-2 bg-green-500 hover:bg-green-600 text-white text-sm text-center rounded-lg transition">
                                Aktifkan
                            </a>
                        <?php endif; ?>
                        <a href="<?= base_url('admin/semester/edit/' . $semester->id) ?>"
                            class="p-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                            <span class="material-icons-outlined text-gray-500">edit</span>
                        </a>
                        <a href="<?= base_url('admin/semester/delete/' . $semester->id) ?>"
                            class="p-2 border border-gray-300 rounded-lg hover:bg-red-50" data-confirm-delete>
                            <span class="material-icons-outlined text-red-500">delete</span>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-span-full bg-white rounded-xl border border-gray-200 p-12 text-center">
            <span class="material-icons-outlined text-5xl text-gray-300 mb-3">calendar_month</span>
            <p class="text-gray-600 font-medium">Belum ada semester</p>
            <p class="text-gray-500 text-sm mb-4">Tambahkan semester untuk memulai</p>
            <a href="<?= base_url('admin/semester/create') ?>"
                class="inline-flex items-center gap-2 px-4 py-2 bg-brown-500 text-white rounded-lg">
                <span class="material-icons-outlined text-lg">add</span>
                Tambah Semester
            </a>
        </div>
    <?php endif; ?>
</div>