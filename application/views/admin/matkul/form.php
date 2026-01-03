<!-- Page Header -->
<div class="mb-6">
    <h1 class="text-xl font-medium text-gray-800"><?= $page_title ?></h1>
    <p class="text-sm text-gray-500">
        <a href="<?= base_url('dashboard') ?>" class="hover:text-brown-500">Dashboard</a>
        <span class="mx-2">/</span>
        <a href="<?= base_url('admin/matkul') ?>" class="hover:text-brown-500">Mata Kuliah</a>
        <span class="mx-2">/</span>
        <span><?= $edit_mode ? 'Edit' : 'Tambah' ?></span>
    </p>
</div>

<div class="max-w-2xl">
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <form action="" method="POST">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="kode_matkul" class="block text-sm font-medium text-gray-700 mb-1">
                        Kode <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="kode_matkul" name="kode_matkul" required
                           placeholder="PBD01"
                           value="<?= htmlspecialchars($matkul_data->kode_matkul ?? '') ?>"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-400 focus:border-brown-400 outline-none">
                </div>
                
                <div class="md:col-span-2">
                    <label for="nama_matkul" class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Mata Kuliah <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nama_matkul" name="nama_matkul" required
                           placeholder="Praktikum Basis Data"
                           value="<?= htmlspecialchars($matkul_data->nama_matkul ?? '') ?>"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-400 focus:border-brown-400 outline-none">
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                <div>
                    <label for="sks" class="block text-sm font-medium text-gray-700 mb-1">
                        SKS <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="sks" name="sks" required min="1" max="6"
                           value="<?= $matkul_data->sks ?? 1 ?>"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-400 focus:border-brown-400 outline-none">
                </div>
            </div>
            
            <div class="mt-4">
                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="3"
                          placeholder="Deskripsi singkat mata kuliah"
                          class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-400 focus:border-brown-400 outline-none"><?= htmlspecialchars($matkul_data->deskripsi ?? '') ?></textarea>
            </div>
            
            <div class="mt-4">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" <?= ($matkul_data->is_active ?? 1) ? 'checked' : '' ?>
                           class="w-4 h-4 text-brown-500 border-gray-300 rounded focus:ring-brown-400">
                    <span class="text-sm text-gray-700">Mata Kuliah Aktif</span>
                </label>
            </div>
            
            <div class="flex gap-3 mt-6 pt-6 border-t border-gray-200">
                <button type="submit" class="px-5 py-2.5 bg-brown-500 hover:bg-brown-600 text-white rounded-lg transition">
                    <?= $edit_mode ? 'Simpan Perubahan' : 'Tambah Mata Kuliah' ?>
                </button>
                <a href="<?= base_url('admin/matkul') ?>" class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>