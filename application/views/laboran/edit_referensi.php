<!-- Page Header -->
<div class="mb-6">
    <h1 class="text-xl font-medium text-gray-800">
        <?= $page_title ?>
    </h1>
    <p class="text-sm text-gray-500">Edit Referensi untuk
        <?= htmlspecialchars($matkum->nama_matkul) ?>
    </p>
</div>

<div class="max-w-2xl">
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="font-medium text-gray-800 flex items-center gap-2">
                <span class="material-icons-outlined">edit</span>
                Edit Referensi
            </h2>
        </div>
        <div class="p-5">
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Judul Referensi *</label>
                    <input type="text" name="judul" required value="<?= htmlspecialchars($referensi->judul) ?>"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-500 focus:border-transparent">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="deskripsi" rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-500 focus:border-transparent"><?= htmlspecialchars($referensi->deskripsi ?? '') ?></textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Referensi *</label>
                    <select name="tipe" id="ref_tipe" required onchange="toggleRefType()"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-500 focus:border-transparent">
                        <option value="file" <?= $referensi->tipe == 'file' ? 'selected' : '' ?>>File Upload</option>
                        <option value="link" <?= $referensi->tipe == 'link' ? 'selected' : '' ?>>Link External</option>
                    </select>
                </div>

                <div class="mb-4 <?= $referensi->tipe == 'link' ? 'hidden' : '' ?>" id="ref_file_section">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Ganti File
                        <span class="text-gray-400 text-xs">(Kosongkan jika tidak ingin mengganti)</span>
                    </label>
                    <?php if ($referensi->file_path): ?>
                        <p class="text-sm text-gray-500 mb-2">
                            <span class="material-icons-outlined text-sm align-middle">attach_file</span>
                            File saat ini:
                            <?= $referensi->file_path ?>
                        </p>
                    <?php endif; ?>
                    <input type="file" name="file" class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                    <p class="text-xs text-gray-400 mt-1">Format: PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, ZIP, RAR. Max:
                        50MB</p>
                </div>

                <div class="mb-4 <?= $referensi->tipe != 'link' ? 'hidden' : '' ?>" id="ref_link_section">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Link URL</label>
                    <input type="url" name="link_external"
                        value="<?= htmlspecialchars($referensi->link_external ?? '') ?>"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-500 focus:border-transparent"
                        placeholder="https://...">
                </div>

                <script>
                    function toggleRefType() {
                        const tipe = document.getElementById('ref_tipe').value;
                        document.getElementById('ref_file_section').classList.toggle('hidden', tipe === 'link');
                        document.getElementById('ref_link_section').classList.toggle('hidden', tipe !== 'link');
                    }
                </script>

                <div class="flex gap-3 mt-6">
                    <button type="submit"
                        class="flex-1 px-4 py-3 bg-brown-500 hover:bg-brown-600 text-white rounded-lg transition flex items-center justify-center gap-2">
                        <span class="material-icons-outlined">save</span>
                        Simpan Perubahan
                    </button>
                    <a href="<?= base_url('laboran/matkum/' . $matkum->id) ?>"
                        class="px-4 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 flex items-center justify-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>