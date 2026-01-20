<!-- Page Header -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-xl font-medium text-gray-800"><?= $page_title ?></h1>
        <p class="text-sm text-gray-500">Kelola daftar mata praktikum</p>
    </div>
    <a href="<?= base_url('admin/matkum/create') ?>"
        class="inline-flex items-center gap-2 px-4 py-2.5 bg-brown-500 hover:bg-brown-600 text-white rounded-lg transition">
        <span class="material-icons-outlined text-lg">add</span>
        Tambah Mata Praktikum
    </a>
</div>

<!-- Matkum List -->
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="px-5 py-4 border-b border-gray-100">
        <h2 class="font-medium text-gray-800">Daftar Mata Praktikum</h2>
    </div>
    <?php if (!empty($matkums)): ?>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKS</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Laboran
                        </th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status
                        </th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php $no = 1;
                    foreach ($matkums as $matkum): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-4 text-sm text-gray-600"><?= $no++ ?></td>
                            <td class="px-5 py-4">
                                <code
                                    class="px-2 py-1 bg-gray-100 text-gray-700 text-sm rounded"><?= htmlspecialchars($matkum->kode_matkul) ?></code>
                            </td>
                            <td class="px-5 py-4">
                                <a href="<?= base_url('admin/matkum/detail/' . $matkum->id) ?>"
                                    class="font-medium text-gray-800 hover:text-brown-600">
                                    <?= htmlspecialchars($matkum->nama_matkul) ?>
                                </a>
                                <?php if ($matkum->deskripsi): ?>
                                    <p class="text-xs text-gray-500 mt-1">
                                        <?= htmlspecialchars(substr($matkum->deskripsi, 0, 50)) ?>
                                        <?= strlen($matkum->deskripsi) > 50 ? '...' : '' ?>
                                    </p>
                                <?php endif; ?>
                            </td>
                            <td class="px-5 py-4">
                                <span class="px-2 py-1 bg-gray-100 text-gray-700 text-sm rounded"><?= $matkum->sks ?> SKS</span>
                            </td>
                            <td class="px-5 py-4">
                                <?php if ($matkum->laboran_count > 0): ?>
                                    <div class="flex flex-wrap gap-1">
                                        <?php foreach ($matkum->laborans as $lab): ?>
                                            <span
                                                class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded"><?= htmlspecialchars($lab->nama) ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <span class="text-gray-400 text-sm">Belum ada</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-5 py-4">
                                <?php if ($matkum->is_active): ?>
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
                                    <a href="<?= base_url('admin/matkum/detail/' . $matkum->id) ?>"
                                        class="p-2 hover:bg-blue-50 rounded-full" title="Detail">
                                        <span class="material-icons-outlined text-blue-600 text-lg">visibility</span>
                                    </a>
                                    <a href="<?= base_url('admin/assign_laboran/' . $matkum->id) ?>"
                                        class="p-2 hover:bg-green-50 rounded-full" title="Assign Laboran">
                                        <span class="material-icons-outlined text-green-600 text-lg">person_add</span>
                                    </a>
                                    <a href="<?= base_url('admin/assign_mahasiswa/' . $matkum->id) ?>"
                                        class="p-2 hover:bg-blue-50 rounded-full" title="Assign Mahasiswa">
                                        <span class="material-icons-outlined text-blue-600 text-lg">school</span>
                                    </a>
                                    <a href="<?= base_url('admin/matkum/edit/' . $matkum->id) ?>"
                                        class="p-2 hover:bg-gray-100 rounded-full" title="Edit">
                                        <span class="material-icons-outlined text-gray-500 text-lg">edit</span>
                                    </a>
                                    <a href="<?= base_url('admin/matkum/delete/' . $matkum->id) ?>"
                                        class="p-2 hover:bg-red-50 rounded-full" title="Hapus" data-confirm-delete>
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
            <p class="text-gray-600 font-medium">Belum ada mata praktikum</p>
            <p class="text-gray-500 text-sm mb-4">Klik tombol di bawah untuk menambah mata praktikum baru</p>
            <a href="<?= base_url('admin/matkum/create') ?>"
                class="inline-flex items-center gap-2 px-4 py-2 bg-brown-500 hover:bg-brown-600 text-white rounded-lg transition">
                <span class="material-icons-outlined text-lg">add</span>
                Tambah Mata Praktikum
            </a>
        </div>
    <?php endif; ?>
</div>