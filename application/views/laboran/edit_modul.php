<!-- Page Header -->
<div class="mb-6">
    <h1 class="text-xl font-medium text-gray-800">
        <?= $page_title ?>
    </h1>
    <p class="text-sm text-gray-500">Edit konten modul slot
        <?= $modul->slot_number ?>
    </p>
</div>

<div class="max-w-2xl">
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="font-medium text-gray-800 flex items-center gap-2">
                <span class="material-icons-outlined">edit</span>
                Edit Modul
            </h2>
        </div>
        <div class="p-5">
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Judul Modul *</label>
                    <input type="text" name="judul_modul" required value="<?= htmlspecialchars($modul->judul_modul) ?>"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-500 focus:border-transparent">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="deskripsi" rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-500 focus:border-transparent"><?= htmlspecialchars($modul->deskripsi ?? '') ?></textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipe File *</label>
                    <select name="tipe_file" id="modul_tipe" required onchange="toggleModulType()"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-500 focus:border-transparent">
                        <option value="pdf" <?= $modul->tipe_file == 'pdf' ? 'selected' : '' ?>>PDF</option>
                        <option value="video" <?= $modul->tipe_file == 'video' ? 'selected' : '' ?>>Video</option>
                        <option value="link" <?= $modul->tipe_file == 'link' ? 'selected' : '' ?>>Link External</option>
                        <option value="lainnya" <?= $modul->tipe_file == 'lainnya' ? 'selected' : '' ?>>Lainnya</option>
                    </select>
                </div>

                <div class="mb-4 <?= $modul->tipe_file == 'link' ? 'hidden' : '' ?>" id="modul_file_section">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Ganti File
                        <?php if ($modul->file_modul): ?>
                            <span class="text-gray-400 text-xs">(Kosongkan jika tidak ingin mengganti)</span>
                        <?php endif; ?>
                    </label>
                    <?php if ($modul->file_modul): ?>
                        <p class="text-sm text-gray-500 mb-2">
                            <span class="material-icons-outlined text-sm align-middle">attach_file</span>
                            File saat ini:
                            <?= $modul->file_modul ?>
                        </p>
                    <?php endif; ?>
                    <input type="file" name="file_modul" class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                </div>

                <div class="mb-4 <?= $modul->tipe_file != 'link' ? 'hidden' : '' ?>" id="modul_link_section">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Link URL</label>
                    <input type="url" name="link_external" value="<?= htmlspecialchars($modul->link_external ?? '') ?>"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-500 focus:border-transparent"
                        placeholder="https://...">
                </div>

                <div class="mb-4">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="is_visible" value="1" <?= $modul->is_visible ? 'checked' : '' ?>
                        class="rounded">
                        <span class="text-sm text-gray-700">Tampilkan ke mahasiswa</span>
                    </label>
                </div>

                <script>
                    function toggleModulType() {
                        const tipe = document.getElementById('modul_tipe').value;
                        document.getElementById('modul_file_section').classList.toggle('hidden', tipe === 'link');
                        document.getElementById('modul_link_section').classList.toggle('hidden', tipe !== 'link');
                    }
                </script>

                <div class="flex gap-3 mt-6">
                    <button type="submit"
                        class="flex-1 px-4 py-3 bg-brown-500 hover:bg-brown-600 text-white rounded-lg transition flex items-center justify-center gap-2">
                        <span class="material-icons-outlined">save</span>
                        Simpan Perubahan
                    </button>
                    <a href="<?= base_url('laboran/matkum/' . $modul->id_matkul) ?>"
                        class="px-4 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 flex items-center justify-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>