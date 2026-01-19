<!-- Page Header -->
<div class="mb-6">
    <h1 class="text-xl font-medium text-gray-800">
        <?= $page_title ?>
    </h1>
    <p class="text-sm text-gray-500">
        <a href="<?= base_url('admin/semester') ?>" class="hover:text-brown-500">Semester</a>
        <span class="mx-2">/</span>
        <a href="<?= base_url('admin/semester/detail/' . $semester->id) ?>" class="hover:text-brown-500">
            <?= $semester->nama_semester ?>
            <?= $semester->tahun_ajaran ?>
        </a>
        <span class="mx-2">/</span>
        <span>Mahasiswa</span>
    </p>
</div>

<div class="flex gap-4 mb-6">
    <a href="<?= base_url('admin/semester/import_mahasiswa/' . $semester->id) ?>"
        class="inline-flex items-center gap-2 px-4 py-2 bg-brown-500 hover:bg-brown-600 text-white rounded-lg transition">
        <span class="material-icons-outlined text-lg">upload_file</span>
        Import dari CSV
    </a>
</div>

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="px-5 py-4 border-b border-gray-100">
        <h2 class="font-medium text-gray-800">Mahasiswa Terdaftar (
            <?= count($mahasiswas) ?>)
        </h2>
    </div>

    <?php if (!empty($mahasiswas)): ?>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIM</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Prodi</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Angkatan</th>
                        <th class="px-5 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php foreach ($mahasiswas as $mhs): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-sm font-medium">
                                        <?= strtoupper(substr($mhs->nama, 0, 1)) ?>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">
                                            <?= htmlspecialchars($mhs->nama) ?>
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            <?= $mhs->email ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-600">
                                <?= $mhs->nim_nip ?>
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-600">
                                <?= $mhs->prodi ?>
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-600">
                                <?= $mhs->angkatan ?>
                            </td>
                            <td class="px-5 py-4 text-center">
                                <form method="POST" class="inline"
                                    onsubmit="return confirm('Hapus mahasiswa dari semester ini?')">
                                    <input type="hidden" name="action" value="remove">
                                    <input type="hidden" name="user_id" value="<?= $mhs->id ?>">
                                    <button type="submit" class="text-red-500 hover:text-red-600">
                                        <span class="material-icons-outlined">delete</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="p-12 text-center">
            <span class="material-icons-outlined text-5xl text-gray-300 mb-3">people</span>
            <p class="text-gray-600 font-medium">Belum ada mahasiswa</p>
            <p class="text-gray-500 text-sm mb-4">Import mahasiswa dari file CSV</p>
        </div>
    <?php endif; ?>
</div>

<div class="mt-6">
    <a href="<?= base_url('admin/semester/detail/' . $semester->id) ?>"
        class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
        <span class="material-icons-outlined">arrow_back</span>
        Kembali
    </a>
</div>