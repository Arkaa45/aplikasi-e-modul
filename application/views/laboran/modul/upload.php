<!-- Page Header -->
<div class="mb-6">
    <h1 class="text-xl font-medium text-gray-800"><?= $page_title ?></h1>
    <p class="text-sm text-gray-500">
        <a href="<?= base_url('dashboard') ?>" class="hover:text-brown-500">Dashboard</a>
        <span class="mx-2">/</span>
        <span>Upload Modul</span>
    </p>
</div>

<?php if (!$current_semester): ?>
    <div class="p-4 bg-amber-50 border border-amber-200 text-amber-700 rounded-lg flex items-center gap-3">
        <span class="material-icons-outlined">warning</span>
        Belum ada semester aktif. Hubungi admin untuk mengaktifkan semester.
    </div>
<?php else: ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="matkul_id" class="block text-sm font-medium text-gray-700 mb-1">
                                Mata Kuliah <span class="text-red-500">*</span>
                            </label>
                            <select id="matkul_id" name="matkul_id" required onchange="loadPertemuan()"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-400 focus:border-brown-400 outline-none">
                                <option value="">Pilih Mata Kuliah</option>
                                <?php foreach ($my_matkul as $matkul): ?>
                                    <option value="<?= $matkul->id ?>"><?= htmlspecialchars($matkul->nama_matkul) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div>
                            <label for="pertemuan_id" class="block text-sm font-medium text-gray-700 mb-1">
                                Pertemuan <span class="text-red-500">*</span>
                            </label>
                            <select id="pertemuan_id" name="pertemuan_id" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-400 focus:border-brown-400 outline-none">
                                <option value="">Pilih Pertemuan</option>
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

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
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
                            class="px-5 py-2.5 bg-brown-500 hover:bg-brown-600 text-white rounded-lg transition">
                            Upload Modul
                        </button>
                        <a href="<?= base_url('laboran/modul') ?>"
                            class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Info -->
        <div class="space-y-4">
            <div class="bg-cream-100 rounded-xl p-5">
                <h3 class="font-medium text-gray-800 mb-3 flex items-center gap-2">
                    <span class="material-icons-outlined text-brown-500">calendar_month</span>
                    Semester Aktif
                </h3>
                <p class="text-lg font-semibold text-brown-600"><?= $current_semester->nama_semester ?>
                    <?= $current_semester->tahun_ajaran ?></p>
            </div>

            <div class="bg-gray-50 rounded-xl p-5">
                <h3 class="font-medium text-gray-800 mb-3 flex items-center gap-2">
                    <span class="material-icons-outlined text-gray-500">info</span>
                    Tips
                </h3>
                <ul class="text-sm text-gray-600 space-y-1">
                    <li>• Pilih mata kuliah dan pertemuan</li>
                    <li>• Upload file atau tambah link</li>
                    <li>• Modul bisa disembunyikan untuk draft</li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        const pertemuanData = <?= json_encode($pertemuan_by_matkul) ?>;

        function loadPertemuan() {
            const matkulId = document.getElementById('matkul_id').value;
            const pertemuanSelect = document.getElementById('pertemuan_id');
            pertemuanSelect.innerHTML = '<option value="">Pilih Pertemuan</option>';

            if (matkulId && pertemuanData[matkulId]) {
                pertemuanData[matkulId].forEach(p => {
                    const opt = document.createElement('option');
                    opt.value = p.id;
                    opt.textContent = 'Pertemuan ' + p.pertemuan_ke + ': ' + p.judul;
                    pertemuanSelect.appendChild(opt);
                });
            }
        }

        function toggleFileInput() {
            const tipe = document.getElementById('tipe_file').value;
            document.getElementById('file_container').classList.toggle('hidden', tipe === 'link');
            document.getElementById('link_container').classList.toggle('hidden', tipe !== 'link');
        }
    </script>

<?php endif; ?>