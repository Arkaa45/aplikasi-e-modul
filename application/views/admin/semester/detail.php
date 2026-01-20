<!-- Page Header -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-xl font-medium text-gray-800">
            <?= $page_title ?>
        </h1>
        <p class="text-sm text-gray-500">
            <?= date('d M Y', strtotime($semester->tanggal_mulai)) ?> -
            <?= date('d M Y', strtotime($semester->tanggal_selesai)) ?>
        </p>
    </div>
    <div class="flex gap-2">
        <a href="<?= base_url('admin/semester/edit/' . $semester->id) ?>"
            class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
            <span class="material-icons-outlined text-lg">edit</span>
            Edit
        </a>
        <a href="<?= base_url('admin/semester') ?>"
            class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
            <span class="material-icons-outlined text-lg">arrow_back</span>
            Kembali
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Mata Praktikum Section -->
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 flex justify-between items-center">
            <h2 class="font-medium text-gray-800 flex items-center gap-2">
                <span class="material-icons-outlined">menu_book</span>
                Mata Praktikum (
                <?= count($matkums) ?>)
            </h2>
            <a href="<?= base_url('admin/semester/assign_matkum/' . $semester->id) ?>"
                class="text-sm text-brown-500 hover:text-brown-600 flex items-center gap-1">
                <span class="material-icons-outlined text-lg">add</span>
                Tambah
            </a>
        </div>
        <div class="divide-y divide-gray-100">
            <?php if (!empty($matkums)): ?>
                <?php foreach ($matkums as $matkum): ?>
                    <a href="<?= base_url('admin/matkum/detail/' . $matkum->id) ?>" class="block px-5 py-4 hover:bg-gray-50">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-800">
                                    <?= htmlspecialchars($matkum->nama_matkul) ?>
                                </p>
                                <p class="text-sm text-gray-500">
                                    <?= $matkum->kode_matkul ?>
                                </p>
                            </div>
                            <span class="material-icons-outlined text-gray-400">chevron_right</span>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="p-8 text-center">
                    <span class="material-icons-outlined text-4xl text-gray-300 mb-2">menu_book</span>
                    <p class="text-gray-500 text-sm">Belum ada mata praktikum</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Mahasiswa Section -->
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 flex justify-between items-center">
            <h2 class="font-medium text-gray-800 flex items-center gap-2">
                <span class="material-icons-outlined">people</span>
                Mahasiswa Terdaftar (
                <?= count($mahasiswas) ?>)
            </h2>
        </div>
        <div class="divide-y divide-gray-100 max-h-96 overflow-y-auto">
            <?php if (!empty($mahasiswas)): ?>
                <?php foreach (array_slice($mahasiswas, 0, 10) as $mhs): ?>
                    <div class="px-5 py-3 flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-sm font-medium">
                            <?= strtoupper(substr($mhs->nama, 0, 1)) ?>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-800 truncate">
                                <?= htmlspecialchars($mhs->nama) ?>
                            </p>
                            <p class="text-xs text-gray-500">
                                <?= $mhs->nim_nip ?> - <?= $mhs->prodi ?>
                                • <span class="text-brown-500 font-medium"><?= $mhs->matkum_count ?> Matkum</span>
                            </p>
                        </div>
                        <a href="<?= base_url('admin/semester/mahasiswa/' . $semester->id) ?>"
                            class="text-gray-400 hover:text-brown-500">
                            <span class="material-icons-outlined text-base">visibility</span>
                        </a>
                    </div>
                <?php endforeach; ?>
                <?php if (count($mahasiswas) > 10): ?>
                    <a href="<?= base_url('admin/semester/mahasiswa/' . $semester->id) ?>"
                        class="block px-5 py-3 text-center text-sm text-brown-500 hover:bg-gray-50">
                        Lihat semua
                        <?= count($mahasiswas) ?> mahasiswa
                    </a>
                <?php endif; ?>
            <?php else: ?>
                <div class="p-8 text-center">
                    <span class="material-icons-outlined text-4xl text-gray-300 mb-2">people</span>
                    <p class="text-gray-500 text-sm mb-3">Belum ada mahasiswa yang mengambil mata praktikum di semester ini
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>