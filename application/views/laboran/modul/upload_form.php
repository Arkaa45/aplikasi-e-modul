<!-- Page Header -->
<div class="mb-6">
    <h1 class="text-xl font-medium text-gray-800">
        <?= $page_title ?>
    </h1>
    <p class="text-sm text-gray-500">
        <a href="<?= base_url('dashboard') ?>" class="hover:text-brown-500">Dashboard</a>
        <span class="mx-2">/</span>
        <a href="<?= base_url('laboran/finish_upload') ?>" class="hover:text-brown-500">Upload Modul</a>
        <span class="mx-2">/</span>
        <span>
            <?= htmlspecialchars($selected_matkul->nama_matkul) ?>
        </span>
    </p>
</div>

<?php if (!$current_semester): ?>
    <div class="p-4 bg-amber-50 border border-amber-200 text-amber-700 rounded-lg flex items-center gap-3">
        <span class="material-icons-outlined">warning</span>
        Belum ada semester aktif.
    </div>
<?php else: ?>

    <!-- Matkul & Semester Info -->
    <div class="mb-6 p-4 bg-brown-500 text-white rounded-xl flex items-center justify-between">
        <div class="flex items-center gap-4">
            <span class="material-icons-outlined text-3xl opacity-80">menu_book</span>
            <div>
                <p class="font-medium">
                    <?= htmlspecialchars($selected_matkul->nama_matkul) ?>
                </p>
                <p class="text-sm opacity-80">
                    <?= $selected_matkul->kode_matkul ?> •
                    <?= $current_semester->nama_semester ?>
                    <?= $current_semester->tahun_ajaran ?>
                </p>
            </div>
        </div>
        <a href="<?= base_url('laboran/finish_upload') ?>"
            class="px-4 py-2 bg-white text-brown-600 rounded-lg text-sm font-medium hover:bg-gray-100 transition">
            Ganti Matkul
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Upload Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-lg font-medium text-gray-800 mb-4 flex items-center gap-2">
                    <span class="material-icons-outlined text-brown-500">upload_file</span>
                    Form Upload Modul
                </h2>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="pertemuan_id" class="block text-sm font-medium text-gray-700 mb-1">
                                Pertemuan <span class="text-red-500">*</span>
                            </label>
                            <select id="pertemuan_id" name="pertemuan_id" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-400 focus:border-brown-400 outline-none">
                                <option value="">Pilih Pertemuan</option>
                                <?php foreach ($pertemuan as $p): ?>
                                    <option value="<?= $p->id ?>">Pertemuan
                                        <?= $p->pertemuan_ke ?>:
                                        <?= htmlspecialchars($p->judul) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (empty($pertemuan)): ?>
                                <p class="text-xs text-amber-600 mt-1">
                                    <span class="material-icons-outlined text-xs align-middle">warning</span>
                                    Belum ada pertemuan. <a href="<?= base_url('laboran/pertemuan/create') ?>"
                                        class="underline">Tambah pertemuan</a>
                                </p>
                            <?php endif; ?>
                        </div>

                        <div>
                            <label for="tipe_file" class="block text-sm font-medium text-gray-700 mb-1">Tipe File</label>
                            <select id="tipe_file" name="tipe_file" onchange="toggleFileInput()"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-400 focus:border-brown-400 outline-none">
                                <option value="pdf">PDF</option>
                                <option value="video">Video</option>
                                <option value="link">Link External</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-4">
                        <label for="judul_modul" class="block text-sm font-medium text-gray-700 mb-1">
                            Judul Modul <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="judul_modul" name="judul_modul" required
                            placeholder="Contoh: Modul 1: Pengenalan MySQL"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-400 focus:border-brown-400 outline-none">
                    </div>

                    <div class="mt-4">
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea id="deskripsi" name="deskripsi" rows="2"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-400 focus:border-brown-400 outline-none"></textarea>
                    </div>

                    <div id="file_container" class="mt-4">
                        <label for="file_modul" class="block text-sm font-medium text-gray-700 mb-1">File Modul</label>
                        <input type="file" id="file_modul" name="file_modul"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-brown-100 file:text-brown-700">
                        <p class="text-xs text-gray-500 mt-1">PDF, DOC, DOCX, PPT, PPTX, MP4, ZIP (Max: 50MB)</p>
                    </div>

                    <div id="link_container" class="mt-4 hidden">
                        <label for="link_external" class="block text-sm font-medium text-gray-700 mb-1">Link
                            External</label>
                        <input type="url" id="link_external" name="link_external" placeholder="https://example.com/video"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-400 focus:border-brown-400 outline-none">
                    </div>

                    <div class="mt-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_visible" value="1" checked
                                class="w-4 h-4 text-brown-500 border-gray-300 rounded focus:ring-brown-400">
                            <span class="text-sm text-gray-700">Langsung tampilkan ke mahasiswa</span>
                        </label>
                    </div>

                    <div class="flex gap-3 mt-6 pt-6 border-t border-gray-200">
                        <button type="submit"
                            class="px-5 py-2.5 bg-brown-500 hover:bg-brown-600 text-white rounded-lg transition flex items-center gap-2">
                            <span class="material-icons-outlined text-lg">upload</span>
                            Upload Modul
                        </button>
                        <a href="<?= base_url('laboran/finish_upload') ?>"
                            class="px-5 py-2.5 bg-gray-700 hover:bg-gray-800 text-white rounded-lg transition">
                            Selesai
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-4">
            <div class="bg-cream-100 rounded-xl p-5">
                <h3 class="font-medium text-gray-800 mb-3 flex items-center gap-2">
                    <span class="material-icons-outlined text-brown-500">info</span>
                    Tips
                </h3>
                <ul class="text-sm text-gray-600 space-y-2">
                    <li>• Setelah upload, Anda bisa langsung menambahkan modul lain</li>
                    <li>• Klik "Selesai" untuk kembali ke daftar modul</li>
                    <li>• Modul bisa disembunyikan untuk draft</li>
                </ul>
            </div>

            <!-- Pertemuan Quick List -->
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="px-5 py-3 border-b border-gray-100">
                    <h3 class="font-medium text-gray-800 text-sm">Pertemuan Tersedia</h3>
                </div>
                <?php if (!empty($pertemuan)): ?>
                    <div class="divide-y divide-gray-100 max-h-64 overflow-y-auto">
                        <?php foreach ($pertemuan as $p): ?>
                            <div class="px-5 py-2.5 text-sm">
                                <span class="font-medium text-gray-700">Pertemuan
                                    <?= $p->pertemuan_ke ?>
                                </span>
                                <span class="text-gray-500">:
                                    <?= htmlspecialchars($p->judul) ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="p-5 text-center text-gray-500 text-sm">
                        <p>Belum ada pertemuan</p>
                        <a href="<?= base_url('laboran/pertemuan/create') ?>" class="text-brown-500 underline">Tambah</a>
                    </div>
                <?php endif; ?>
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

<?php endif; ?>