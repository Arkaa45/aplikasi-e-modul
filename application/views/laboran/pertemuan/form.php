<!-- Page Header -->
<div class="mb-6">
    <h1 class="text-xl font-medium text-gray-800"><?= $page_title ?></h1>
    <p class="text-sm text-gray-500">
        <a href="<?= base_url('dashboard') ?>" class="hover:text-brown-500">Dashboard</a>
        <span class="mx-2">/</span>
        <a href="<?= base_url('laboran/pertemuan') ?>" class="hover:text-brown-500">Pertemuan</a>
        <span class="mx-2">/</span>
        <span><?= $edit_mode ? 'Edit' : 'Tambah' ?></span>
    </p>
</div>

<!-- Matkul Info -->
<div class="mb-6 p-4 bg-cream-100 rounded-xl flex items-center gap-3">
    <span class="material-icons-outlined text-brown-500">menu_book</span>
    <div>
        <p class="font-medium text-gray-800"><?= htmlspecialchars($selected_matkul->nama_matkul) ?></p>
        <p class="text-sm text-gray-500"><?= $current_semester->nama_semester ?> <?= $current_semester->tahun_ajaran ?>
        </p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Form -->
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <form action="" method="POST">
            <div class="space-y-4">
                <div>
                    <label for="pertemuan_ke" class="block text-sm font-medium text-gray-700 mb-1">
                        Pertemuan Ke <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="pertemuan_ke" name="pertemuan_ke" required min="1" max="16"
                        value="<?= $pertemuan_data->pertemuan_ke ?? '' ?>"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-400 focus:border-brown-400 outline-none">
                </div>

                <div>
                    <label for="judul" class="block text-sm font-medium text-gray-700 mb-1">
                        Judul Pertemuan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="judul" name="judul" required
                        value="<?= htmlspecialchars($pertemuan_data->judul ?? '') ?>"
                        placeholder="Contoh: Pengenalan MySQL"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-400 focus:border-brown-400 outline-none">
                </div>

                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="3"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-400 focus:border-brown-400 outline-none"><?= htmlspecialchars($pertemuan_data->deskripsi ?? '') ?></textarea>
                </div>
            </div>

            <div class="flex gap-3 mt-6 pt-6 border-t border-gray-200">
                <button type="submit"
                    class="px-5 py-2.5 bg-brown-500 hover:bg-brown-600 text-white rounded-lg transition">
                    <?= $edit_mode ? 'Simpan Perubahan' : 'Tambah Pertemuan' ?>
                </button>
                <a href="<?= base_url('laboran/pertemuan') ?>"
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
            <li>• Pertemuan akan terkait dengan semester aktif</li>
            <li>• Setelah membuat pertemuan, Anda bisa upload modul</li>
            <li>• Modul dapat diupload dari menu Upload Modul</li>
        </ul>
    </div>
</div>