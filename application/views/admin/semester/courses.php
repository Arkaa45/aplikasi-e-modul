<!-- Page Header -->
<div class="mb-6">
    <h1 class="text-xl font-medium text-gray-800">
        <?= $page_title ?>
    </h1>
    <p class="text-sm text-gray-500">
        <a href="<?= base_url('dashboard') ?>" class="hover:text-brown-500">Dashboard</a>
        <span class="mx-2">/</span>
        <a href="<?= base_url('admin/semester') ?>" class="hover:text-brown-500">Semester</a>
        <span class="mx-2">/</span>
        <span>Mata Kuliah</span>
    </p>
</div>

<!-- Semester Info -->
<div class="mb-6 p-4 bg-brown-100 rounded-xl flex items-center gap-3">
    <span class="material-icons-outlined text-brown-600">calendar_month</span>
    <div>
        <p class="font-medium text-gray-800">
            <?= $semester->nama_semester ?>
            <?= $semester->tahun_ajaran ?>
        </p>
        <p class="text-sm text-gray-500">Tambahkan mata kuliah praktikum untuk semester ini</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Add Matkul Form -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="text-lg font-medium text-gray-800 mb-4 flex items-center gap-2">
                <span class="material-icons-outlined text-brown-500">add_circle</span>
                Tambah Mata Kuliah Baru
            </h2>
            <form action="" method="POST">
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
                            Nama Mata Kuliah <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nama_matkul" name="nama_matkul" required
                            placeholder="Praktikum Basis Data"
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
                        Tambah Mata Kuliah
                    </button>
                </div>
            </form>
        </div>

        <!-- Daftar Matkul yang Sudah Ada -->
        <div class="bg-white rounded-xl border border-gray-200 mt-6 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h2 class="font-medium text-gray-800">Daftar Mata Kuliah</h2>
            </div>
            <?php if (!empty($matkuls)): ?>
                <div class="divide-y divide-gray-100">
                    <?php foreach ($matkuls as $matkul): ?>
                        <div class="px-5 py-3 flex items-center gap-3">
                            <span class="material-icons-outlined text-gray-400">menu_book</span>
                            <div class="flex-1">
                                <p class="font-medium text-gray-800">
                                    <?= htmlspecialchars($matkul->nama_matkul) ?>
                                </p>
                                <p class="text-xs text-gray-500">
                                    <?= $matkul->kode_matkul ?> •
                                    <?= $matkul->sks ?> SKS
                                </p>
                            </div>
                            <?php if ($matkul->is_active): ?>
                                <span class="text-green-500 text-xs">Aktif</span>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="p-8 text-center text-gray-500">
                    <span class="material-icons-outlined text-4xl text-gray-300 mb-2">menu_book</span>
                    <p>Belum ada mata kuliah</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-4">
        <div class="bg-cream-100 rounded-xl p-5">
            <h3 class="font-medium text-gray-800 mb-3 flex items-center gap-2">
                <span class="material-icons-outlined text-brown-500">info</span>
                Informasi
            </h3>
            <ul class="text-sm text-gray-600 space-y-2">
                <li>• Tambahkan mata kuliah praktikum yang akan digunakan dalam semester ini</li>
                <li>• Setelah selesai, klik tombol "Selesai" untuk kembali ke daftar semester</li>
            </ul>
        </div>

        <a href="<?= base_url('admin/semester') ?>"
            class="block w-full px-5 py-3 bg-gray-700 hover:bg-gray-800 text-white text-center rounded-lg transition">
            <span class="material-icons-outlined align-middle mr-1">check</span>
            Selesai
        </a>
    </div>
</div>