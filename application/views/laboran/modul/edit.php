<!-- Page Header -->
<div class="mb-6">
    <h1 class="text-xl font-medium text-gray-800"><?= $page_title ?></h1>
    <p class="text-sm text-gray-500">
        <a href="<?= base_url('dashboard') ?>" class="hover:text-brown-500">Dashboard</a>
        <span class="mx-2">/</span>
        <a href="<?= base_url('laboran/modul') ?>" class="hover:text-brown-500">Modul</a>
        <span class="mx-2">/</span>
        <span>Edit</span>
    </p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <form action="" method="POST" enctype="multipart/form-data">
                <!-- Info Pertemuan -->
                <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-500">Pertemuan</p>
                    <p class="font-medium text-gray-800"><?= htmlspecialchars($modul->nama_matkul) ?> - Pertemuan
                        <?= $modul->pertemuan_ke ?></p>
                    <p class="text-xs text-gray-500"><?= $modul->nama_semester ?> <?= $modul->tahun_ajaran ?></p>
                </div>

                <div>
                    <label for="judul_modul" class="block text-sm font-medium text-gray-700 mb-1">Judul Modul</label>
                    <input type="text" id="judul_modul" name="judul_modul" required
                        value="<?= htmlspecialchars($modul->judul_modul) ?>"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-400 focus:border-brown-400 outline-none">
                </div>

                <div class="mt-4">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="2"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-400 focus:border-brown-400 outline-none"><?= htmlspecialchars($modul->deskripsi ?? '') ?></textarea>
                </div>

                <div class="mt-4">
                    <label for="tipe_file" class="block text-sm font-medium text-gray-700 mb-1">Tipe File</label>
                    <select id="tipe_file" name="tipe_file" onchange="toggleFileInput()"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-400 focus:border-brown-400 outline-none">
                        <option value="pdf" <?= $modul->tipe_file == 'pdf' ? 'selected' : '' ?>>PDF</option>
                        <option value="video" <?= $modul->tipe_file == 'video' ? 'selected' : '' ?>>Video</option>
                        <option value="link" <?= $modul->tipe_file == 'link' ? 'selected' : '' ?>>Link</option>
                        <option value="lainnya" <?= $modul->tipe_file == 'lainnya' ? 'selected' : '' ?>>Lainnya</option>
                    </select>
                </div>

                <?php if ($modul->file_modul): ?>
                    <div class="mt-4 p-3 bg-gray-50 rounded-lg flex items-center gap-3">
                        <span class="material-icons-outlined text-gray-500">description</span>
                        <code
                            class="text-sm text-gray-600 flex-1 truncate"><?= htmlspecialchars($modul->file_modul) ?></code>
                    </div>
                <?php endif; ?>

                <div id="file_container" class="mt-4 <?= $modul->tipe_file == 'link' ? 'hidden' : '' ?>">
                    <label for="file_modul" class="block text-sm font-medium text-gray-700 mb-1">Upload File Baru
                        (Opsional)</label>
                    <input type="file" id="file_modul" name="file_modul"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg">
                </div>

                <div id="link_container" class="mt-4 <?= $modul->tipe_file != 'link' ? 'hidden' : '' ?>">
                    <label for="link_external" class="block text-sm font-medium text-gray-700 mb-1">Link
                        External</label>
                    <input type="url" id="link_external" name="link_external"
                        value="<?= htmlspecialchars($modul->link_external ?? '') ?>"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-400 focus:border-brown-400 outline-none">
                </div>

                <div class="mt-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_visible" value="1" <?= $modul->is_visible ? 'checked' : '' ?>
                            class="w-4 h-4 text-brown-500 border-gray-300 rounded focus:ring-brown-400">
                        <span class="text-sm text-gray-700">Tampilkan ke mahasiswa</span>
                    </label>
                </div>

                <div class="flex gap-3 mt-6 pt-6 border-t border-gray-200">
                    <button type="submit"
                        class="px-5 py-2.5 bg-brown-500 hover:bg-brown-600 text-white rounded-lg transition">
                        Simpan Perubahan
                    </button>
                    <a href="<?= base_url('laboran/modul') ?>"
                        class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="bg-gray-50 rounded-xl p-5 h-fit">
        <h3 class="font-medium text-gray-800 mb-3">Statistik</h3>
        <div class="space-y-2 text-sm">
            <div class="flex justify-between">
                <span class="text-gray-500">Downloads:</span>
                <span class="font-medium text-gray-800"><?= $modul->download_count ?></span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Diupload:</span>
                <span class="text-gray-700"><?= date('d M Y', strtotime($modul->created_at)) ?></span>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleFileInput() {
        const tipe = document.getElementById('tipe_file').value;
        document.getElementById('file_container').classList.toggle('hidden', tipe === 'link');
        document.getElementById('link_container').classList.toggle('hidden', tipe !== 'link');
    }
</script>