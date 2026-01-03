<!-- Page Header -->
<div class="mb-6">
    <h1 class="text-xl font-medium text-gray-800"><?= $page_title ?></h1>
</div>

<!-- Info -->
<div class="mb-6 p-4 bg-blue-50 border border-blue-200 text-blue-700 rounded-lg flex items-center gap-3">
    <span class="material-icons-outlined">info</span>
    <span class="text-sm">Anda hanya dapat mengakses modul dari semester yang sudah berjalan.</span>
</div>

<!-- Semester Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    <?php if (!empty($semesters)): ?>
        <?php foreach ($semesters as $semester): ?>
            <a href="<?= base_url('mahasiswa/matkul/' . $semester->id) ?>"
                class="block bg-white rounded-xl border <?= $semester->is_active ? 'border-green-300 ring-2 ring-green-100' : 'border-gray-200' ?> p-5 hover:shadow-md transition card-hover">
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

                <p class="text-sm text-gray-500">
                    <span class="material-icons-outlined text-sm align-middle">date_range</span>
                    <?= date('d M Y', strtotime($semester->tanggal_mulai)) ?> -
                    <?= date('d M Y', strtotime($semester->tanggal_selesai)) ?>
                </p>
            </a>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-span-full bg-white rounded-xl border border-gray-200 p-12 text-center">
            <span class="material-icons-outlined text-5xl text-gray-300 mb-3">calendar_month</span>
            <p class="text-gray-500">Tidak ada semester tersedia</p>
        </div>
    <?php endif; ?>
</div>