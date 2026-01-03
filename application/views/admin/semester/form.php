<!-- Page Header -->
<div class="mb-6">
    <h1 class="text-xl font-medium text-gray-800"><?= $page_title ?></h1>
    <p class="text-sm text-gray-500">
        <a href="<?= base_url('dashboard') ?>" class="hover:text-brown-500">Dashboard</a>
        <span class="mx-2">/</span>
        <a href="<?= base_url('admin/semester') ?>" class="hover:text-brown-500">Semester</a>
        <span class="mx-2">/</span>
        <span><?= $edit_mode ? 'Edit' : 'Tambah' ?></span>
    </p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Form -->
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <form action="" method="POST">
            <div class="space-y-4">
                <div>
                    <label for="nama_semester" class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Semester <span class="text-red-500">*</span>
                    </label>
                    <select id="nama_semester" name="nama_semester" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-400 focus:border-brown-400 outline-none">
                        <option value="">Pilih</option>
                        <option value="Ganjil" <?= ($semester_data->nama_semester ?? '') == 'Ganjil' ? 'selected' : '' ?>>
                            Ganjil</option>
                        <option value="Genap" <?= ($semester_data->nama_semester ?? '') == 'Genap' ? 'selected' : '' ?>>
                            Genap</option>
                    </select>
                </div>

                <div>
                    <label for="tahun_ajaran" class="block text-sm font-medium text-gray-700 mb-1">
                        Tahun Ajaran <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="tahun_ajaran" name="tahun_ajaran" required placeholder="Contoh: 2024/2025"
                        value="<?= htmlspecialchars($semester_data->tahun_ajaran ?? '') ?>"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-400 focus:border-brown-400 outline-none">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 mb-1">
                            Tanggal Mulai <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="tanggal_mulai" name="tanggal_mulai" required
                            value="<?= $semester_data->tanggal_mulai ?? '' ?>"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-400 focus:border-brown-400 outline-none">
                    </div>
                    <div>
                        <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700 mb-1">
                            Tanggal Selesai <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="tanggal_selesai" name="tanggal_selesai" required
                            value="<?= $semester_data->tanggal_selesai ?? '' ?>"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-400 focus:border-brown-400 outline-none">
                    </div>
                </div>
            </div>

            <div class="flex gap-3 mt-6 pt-6 border-t border-gray-200">
                <button type="submit"
                    class="px-5 py-2.5 bg-brown-500 hover:bg-brown-600 text-white rounded-lg transition">
                    <?= $edit_mode ? 'Simpan Perubahan' : 'Tambah Semester' ?>
                </button>
                <a href="<?= base_url('admin/semester') ?>"
                    class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    Kembali
                </a>
            </div>
        </form>
    </div>

    <!-- Info -->
    <div class="bg-cream-100 rounded-xl p-5 h-fit">
        <h3 class="font-medium text-gray-800 mb-3 flex items-center gap-2">
            <span class="material-icons-outlined text-brown-500">info</span>
            Informasi
        </h3>
        <ul class="text-sm text-gray-600 space-y-2">
            <li>• Semester aktif menjadi default untuk mahasiswa</li>
            <li>• Hanya satu semester yang bisa aktif</li>
            <li>• Mahasiswa hanya bisa akses semester yang sudah berjalan</li>
        </ul>
    </div>
</div>