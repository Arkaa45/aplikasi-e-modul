<!-- Page Header -->
<div class="mb-6">
    <h1 class="text-xl font-medium text-gray-800">
        <?= $page_title ?>
    </h1>
    <p class="text-sm text-gray-500">Edit RPS untuk
        <?= htmlspecialchars($matkum->nama_matkul) ?>
    </p>
</div>

<div class="max-w-2xl">
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="font-medium text-gray-800 flex items-center gap-2">
                <span class="material-icons-outlined">edit</span>
                Edit RPS
            </h2>
        </div>
        <div class="p-5">
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Judul RPS *</label>
                    <input type="text" name="judul" required value="<?= htmlspecialchars($rps->judul) ?>"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-500 focus:border-transparent">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Ganti File
                        <span class="text-gray-400 text-xs">(Kosongkan jika tidak ingin mengganti)</span>
                    </label>
                    <?php if ($rps->file_path): ?>
                        <p class="text-sm text-gray-500 mb-2">
                            <span class="material-icons-outlined text-sm align-middle">attach_file</span>
                            File saat ini:
                            <?= $rps->file_path ?>
                        </p>
                    <?php endif; ?>
                    <input type="file" name="file" accept=".pdf,.doc,.docx"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                    <p class="text-xs text-gray-400 mt-1">Format: PDF, DOC, DOCX. Max: 50MB</p>
                </div>

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