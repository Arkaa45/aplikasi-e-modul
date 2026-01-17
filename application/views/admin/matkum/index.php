<!-- Page Header -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-xl font-medium text-gray-800"><?= $page_title ?></h1>
        <p class="text-sm text-gray-500">Kelola daftar mata praktikum</p>
    </div>
</div>

<!-- Semester Selection -->
<div class="bg-white rounded-xl border border-gray-200 p-4 mb-6">
    <form method="GET" class="flex flex-wrap items-center gap-4">
        <span class="text-sm text-gray-600">Pilih Semester:</span>
        <select name="semester" onchange="this.form.submit()"
            class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-brown-400 outline-none">
            <option value="">-- Pilih Semester --</option>
            <?php foreach ($semesters as $sem): ?>
                <option value="<?= $sem->id ?>" <?= $semester_id == $sem->id ? 'selected' : '' ?>>
                    <?= $sem->nama_semester ?>     <?= $sem->tahun_ajaran ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if ($selected_semester): ?>
            <span class="px-3 py-1 bg-green-100 text-green-700 text-sm rounded-full">
                <?= $selected_semester->nama_semester ?>     <?= $selected_semester->tahun_ajaran ?>
            </span>
        <?php endif; ?>
    </form>
</div>

<?php if ($semester_id && $selected_semester): ?>
    <!-- Add Matkul Form -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="text-lg font-medium text-gray-800 mb-4 flex items-center gap-2">
                <span class="material-icons-outlined text-brown-500">add_circle</span>
                Tambah Mata Praktikum Baru
            </h2>
            <form action="" method="POST">
                <input type="hidden" name="semester_id" value="<?= $semester_id ?>">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="kode_matkul" class="block text-sm font-medium text-gray-700 mb-1">
                            Kode <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="kode_matkul" name="kode_matkul" required placeholder="PBD01"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-400 focus:border-brown-400 outline-none">
                    </div>
                    <div class="md:col-span-2">
                        <label for="nama_matkul" class="block text-sm font-medium text-gray-700 mb-1">
                            Nama Mata Praktikum <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nama_matkul" name="nama_matkul" required placeholder="Praktikum Basis Data"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-400 focus:border-brown-400 outline-none">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                    <div>
                        <label for="sks" class="block text-sm font-medium text-gray-700 mb-1">SKS</label>
                        <input type="number" id="sks" name="sks" value="1" min="1" max="6"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-400 focus:border-brown-400 outline-none">
                    </div>
                    <div class="md:col-span-2">
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <input type="text" id="deskripsi" name="deskripsi" placeholder="Deskripsi singkat"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-400 focus:border-brown-400 outline-none">
                    </div>
                </div>
                <div class="flex gap-3 mt-6">
                    <button type="submit"
                        class="px-5 py-2.5 bg-brown-500 hover:bg-brown-600 text-white rounded-lg transition flex items-center gap-2">
                        <span class="material-icons-outlined text-lg">add</span>
                        Tambah Mata Praktikum
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-cream-100 rounded-xl p-5 h-fit">
            <h3 class="font-medium text-gray-800 mb-3 flex items-center gap-2">
                <span class="material-icons-outlined text-brown-500">info</span>
                Informasi
            </h3>
            <ul class="text-sm text-gray-600 space-y-2">
                <li>• Mata praktikum ditambahkan per semester</li>
                <li>• Laboran dapat ditugaskan ke mata praktikum</li>
            </ul>
        </div>
    </div>

    <!-- Matkul List -->
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="font-medium text-gray-800">Daftar Mata Praktikum - <?= $selected_semester->nama_semester ?>
                <?= $selected_semester->tahun_ajaran ?>
            </h2>
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
                            <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status
                            </th>
                            <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php $no = 1;
                        foreach ($matkums as $matkul): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-5 py-4 text-sm text-gray-600"><?= $no++ ?></td>
                                <td class="px-5 py-4">
                                    <code
                                        class="px-2 py-1 bg-gray-100 text-gray-700 text-sm rounded"><?= htmlspecialchars($matkul->kode_matkul) ?></code>
                                </td>
                                <td class="px-5 py-4">
                                    <p class="font-medium text-gray-800"><?= htmlspecialchars($matkul->nama_matkul) ?></p>
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
                                        <a href="<?= base_url('admin/assign_laboran/' . $matkul->id) ?>"
                                            class="p-2 hover:bg-green-50 rounded-full" title="Assign Laboran">
                                            <span class="material-icons-outlined text-green-600 text-lg">person_add</span>
                                        </a>
                                        <a href="<?= base_url('admin/matkum/edit/' . $matkul->id . '?semester=' . $semester_id) ?>"
                                            class="p-2 hover:bg-gray-100 rounded-full">
                                            <span class="material-icons-outlined text-gray-500 text-lg">edit</span>
                                        </a>
                                        <a href="<?= base_url('admin/matkum/delete/' . $matkul->id . '?semester=' . $semester_id) ?>"
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
                <p class="text-gray-600 font-medium">Belum ada mata praktikum</p>
                <p class="text-gray-500 text-sm">Tambahkan mata praktikum menggunakan form di atas</p>
            </div>
        <?php endif; ?>
    </div>

<?php else: ?>
    <div class="bg-white rounded-xl border border-gray-200 p-12 text-center">
        <span class="material-icons-outlined text-5xl text-gray-300 mb-3">touch_app</span>
        <p class="text-gray-600 font-medium">Pilih Semester Terlebih Dahulu</p>
        <p class="text-gray-500 text-sm">Pilih semester untuk melihat dan mengelola mata praktikum</p>
    </div>
<?php endif; ?>