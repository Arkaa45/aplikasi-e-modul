<!-- Page Header -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-xl font-medium text-gray-800"><?= $page_title ?></h1>
        <p class="text-sm text-gray-500">Kelola daftar mata kuliah praktikum</p>
    </div>
    <a href="<?= base_url('admin/matkul/create') ?>"
        class="inline-flex items-center gap-2 px-4 py-2 bg-brown-500 hover:bg-brown-600 text-white rounded-lg transition">
        <span class="material-icons-outlined text-lg">add</span>
        Tambah Mata Kuliah
    </a>
</div>

<!-- Matkul Table -->
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <?php if (!empty($matkuls)): ?>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKS</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status
                        </th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php $no = 1;
                    foreach ($matkuls as $matkul): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-4 text-sm text-gray-600"><?= $no++ ?></td>
                            <td class="px-5 py-4">
                                <code
                                    class="px-2 py-1 bg-gray-100 text-gray-700 text-sm rounded"><?= htmlspecialchars($matkul->kode_matkul) ?></code>
                            </td>
                            <td class="px-5 py-4">
                                <p class="font-medium text-gray-800"><?= htmlspecialchars($matkul->nama_matkul) ?></p>
                                <?php if ($matkul->deskripsi): ?>
                                    <p class="text-xs text-gray-500 truncate max-w-xs"><?= htmlspecialchars($matkul->deskripsi) ?>
                                    </p>
                                <?php endif; ?>
                            </td>
                            <td class="px-5 py-4">
                                <span class="px-2 py-1 bg-gray-100 text-gray-700 text-sm rounded"><?= $matkul->sks ?> SKS</span>
                            </td>
                            <td class="px-5 py-4">
                                <?php if ($matkul->is_active): ?>
                                    <span class="inline-flex items-center gap-1 text-green-600 text-xs">
                                        <span class="material-icons-outlined text-sm">check_circle</span> Aktif
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1 text-gray-400 text-xs">
                                        <span class="material-icons-outlined text-sm">cancel</span> Nonaktif
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-1">
                                    <a href="<?= base_url('admin/matkul/edit/' . $matkul->id) ?>"
                                        class="p-2 hover:bg-gray-100 rounded-full">
                                        <span class="material-icons-outlined text-gray-500 text-lg">edit</span>
                                    </a>
                                    <a href="<?= base_url('admin/matkul/delete/' . $matkul->id) ?>"
                                        class="p-2 hover:bg-red-50 rounded-full" data-confirm-delete>
                                        <span class="material-icons-outlined text-red-500 text-lg">delete</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="p-12 text-center">
            <span class="material-icons-outlined text-5xl text-gray-300 mb-3">menu_book</span>
            <p class="text-gray-600 font-medium">Belum ada mata kuliah</p>
            <a href="<?= base_url('admin/matkul/create') ?>"
                class="inline-flex items-center gap-2 px-4 py-2 bg-brown-500 text-white rounded-lg mt-4">
                <span class="material-icons-outlined text-lg">add</span>
                Tambah Mata Kuliah
            </a>
        </div>
    <?php endif; ?>
</div>