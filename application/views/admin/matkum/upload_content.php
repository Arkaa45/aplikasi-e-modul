<!-- Page Header -->
<div class="mb-6">
    <h1 class="text-xl font-medium text-gray-800">
        <?= $page_title ?>
    </h1>
    <p class="text-sm text-gray-500">
        <a href="<?= base_url('admin/matkum') ?>" class="hover:text-brown-500">Mata Praktikum</a>
        <span class="mx-2">/</span>
        <a href="<?= base_url('admin/matkum/detail/' . $matkum->id) ?>" class="hover:text-brown-500">
            <?= $matkum->nama_matkul ?>
        </a>
        <span class="mx-2">/</span>
        <span>Upload
            <?= ucfirst($type) ?>
        </span>
    </p>
</div>

<div class="max-w-2xl">
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="font-medium text-gray-800 flex items-center gap-2">
                <span class="material-icons-outlined">upload_file</span>
                Upload
                <?= ucfirst($type) ?>
            </h2>
        </div>
        <div class="p-5">
            <form method="POST" enctype="multipart/form-data">

                <?php if ($type == 'rps'): ?>
                    <!-- RPS Form -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Judul RPS *</label>
                        <input type="text" name="judul" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-500 focus:border-transparent"
                            placeholder="Contoh: RPS Semester Ganjil 2025">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">File RPS (PDF) *</label>
                        <input type="file" name="file" accept=".pdf" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                    </div>

                <?php elseif ($type == 'referensi'): ?>
                    <!-- Referensi Form -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Judul Referensi *</label>
                        <input type="text" name="judul" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-500 focus:border-transparent"
                            placeholder="Contoh: Buku Panduan Database">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                        <textarea name="deskripsi" rows="2"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-500 focus:border-transparent"></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipe *</label>
                        <select name="tipe" id="ref_tipe" required onchange="toggleRefType()"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-500 focus:border-transparent">
                            <option value="file">File Upload</option>
                            <option value="link">Link External</option>
                        </select>
                    </div>
                    <div class="mb-4" id="ref_file_section">
                        <label class="block text-sm font-medium text-gray-700 mb-2">File</label>
                        <input type="file" name="file" accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                    </div>
                    <div class="mb-4 hidden" id="ref_link_section">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Link URL</label>
                        <input type="url" name="link_external"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-500 focus:border-transparent"
                            placeholder="https://...">
                    </div>
                    <script>
                        function toggleRefType() {
                            const tipe = document.getElementById('ref_tipe').value;
                            document.getElementById('ref_file_section').classList.toggle('hidden', tipe === 'link');
                            document.getElementById('ref_link_section').classList.toggle('hidden', tipe === 'file');
                        }
                    </script>

                <?php elseif ($type == 'modul'): ?>
                    <!-- Modul Form -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Slot Modul *</label>
                        <select name="slot_number" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-500 focus:border-transparent">
                            <?php
                            $preselect = isset($_GET['slot']) ? (int) $_GET['slot'] : null;
                            foreach ($available_slots as $slot): ?>
                                <option value="<?= $slot ?>" <?= $slot == $preselect ? 'selected' : '' ?>>
                                    Slot
                                    <?= $slot ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Judul Modul *</label>
                        <input type="text" name="judul_modul" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-500 focus:border-transparent"
                            placeholder="Contoh: Modul 1 - Pengenalan Database">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                        <textarea name="deskripsi" rows="2"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-500 focus:border-transparent"></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipe File *</label>
                        <select name="tipe_file" id="modul_tipe" required onchange="toggleModulType()"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-500 focus:border-transparent">
                            <option value="pdf">PDF</option>
                            <option value="video">Video</option>
                            <option value="link">Link External</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="mb-4" id="modul_file_section">
                        <label class="block text-sm font-medium text-gray-700 mb-2">File Modul</label>
                        <input type="file" name="file_modul" accept=".pdf,.mp4,.webm,.doc,.docx,.ppt,.pptx,.zip,.rar"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                    </div>
                    <div class="mb-4 hidden" id="modul_link_section">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Link URL</label>
                        <input type="url" name="link_external"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-500 focus:border-transparent"
                            placeholder="https://...">
                    </div>
                    <div class="mb-4">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="is_visible" value="1" checked class="rounded">
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
                <?php endif; ?>

                <div class="flex gap-3 mt-6">
                    <button type="submit"
                        class="flex-1 px-4 py-3 bg-brown-500 hover:bg-brown-600 text-white rounded-lg transition flex items-center justify-center gap-2">
                        <span class="material-icons-outlined">upload</span>
                        Upload
                    </button>
                    <a href="<?= base_url('admin/matkum/detail/' . $matkum->id) ?>"
                        class="px-4 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 flex items-center justify-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>