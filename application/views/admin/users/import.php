<!-- Page Header -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-xl font-medium text-gray-800"><?= $page_title ?></h1>
        <p class="text-sm text-gray-500">Import data mahasiswa dari file CSV atau paste data langsung</p>
    </div>
    <a href="<?= base_url('admin/users') ?>"
        class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 hover:bg-gray-50 text-gray-700 rounded-lg transition">
        <span class="material-icons-outlined text-lg">arrow_back</span>
        Kembali
    </a>
</div>

<!-- Flash Messages -->
<?php if ($this->session->flashdata('success')): ?>
    <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center gap-3">
        <span class="material-icons-outlined text-green-600">check_circle</span>
        <p class="text-green-700"><?= $this->session->flashdata('success') ?></p>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg flex items-center gap-3">
        <span class="material-icons-outlined text-red-600">error</span>
        <p class="text-red-700"><?= $this->session->flashdata('error') ?></p>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('import_errors')): ?>
    <div class="mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
        <div class="flex items-center gap-3 mb-3">
            <span class="material-icons-outlined text-yellow-600">warning</span>
            <p class="text-yellow-700 font-medium">Detail Error Import:</p>
        </div>
        <ul class="list-disc list-inside text-sm text-yellow-700 space-y-1 max-h-48 overflow-y-auto">
            <?php foreach ($this->session->flashdata('import_errors') as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<!-- Tab Navigation -->
<div class="mb-6">
    <div class="border-b border-gray-200">
        <nav class="flex gap-4" id="import-tabs">
            <button type="button" onclick="switchTab('paste')" id="tab-paste"
                class="tab-btn active px-4 py-2 text-sm font-medium border-b-2 border-brown-500 text-brown-600">
                <span class="material-icons-outlined text-lg align-middle mr-1">content_paste</span>
                Paste Data
            </button>
            <button type="button" onclick="switchTab('file')" id="tab-file"
                class="tab-btn px-4 py-2 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700">
                <span class="material-icons-outlined text-lg align-middle mr-1">upload_file</span>
                Upload CSV
            </button>
        </nav>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Paste Data Form (Default) -->
    <div id="panel-paste" class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="font-medium text-gray-800 flex items-center gap-2">
                <span class="material-icons-outlined text-lg">content_paste</span>
                Paste Data Mahasiswa
            </h2>
        </div>
        <div class="p-5">
            <form action="<?= base_url('admin/users/import') ?>" method="POST">
                <input type="hidden" name="import_type" value="paste">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Data CSV</label>
                    <textarea name="csv_data" rows="12"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm font-mono focus:ring-2 focus:ring-brown-400 focus:border-brown-400 outline-none"
                        placeholder="nama,email,nim_nip,prodi,angkatan
Ahmad Fauzi,ahmad@student.ac.id,2023001001,Teknik Informatika,2023
Siti Aminah,siti@student.ac.id,2023001002,Sistem Informasi,2023" required></textarea>
                    <p class="mt-2 text-xs text-gray-500">Paste data CSV langsung ke text area di atas. Baris pertama
                        adalah header.</p>
                </div>

                <button type="submit"
                    class="w-full px-4 py-3 bg-brown-500 hover:bg-brown-600 text-white rounded-lg transition flex items-center justify-center gap-2">
                    <span class="material-icons-outlined text-lg">cloud_upload</span>
                    Import Data
                </button>
            </form>
        </div>
    </div>

    <!-- Upload CSV Form (Hidden by default) -->
    <div id="panel-file" class="bg-white rounded-xl border border-gray-200 overflow-hidden hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="font-medium text-gray-800 flex items-center gap-2">
                <span class="material-icons-outlined text-lg">upload_file</span>
                Upload File CSV
            </h2>
        </div>
        <div class="p-5">
            <form action="<?= base_url('admin/users/import') ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="import_type" value="file">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">File CSV</label>
                    <div class="relative">
                        <input type="file" name="csv_file" accept=".csv" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                            file:rounded-lg file:border-0 file:text-sm file:font-medium
                            file:bg-brown-50 file:text-brown-700 hover:file:bg-brown-100
                            cursor-pointer border border-gray-300 rounded-lg">
                    </div>
                    <p class="mt-2 text-xs text-gray-500">Format file: CSV (.csv). Maksimal ukuran file: 5MB</p>
                </div>

                <button type="submit"
                    class="w-full px-4 py-3 bg-brown-500 hover:bg-brown-600 text-white rounded-lg transition flex items-center justify-center gap-2">
                    <span class="material-icons-outlined text-lg">cloud_upload</span>
                    Import Data
                </button>
            </form>
        </div>
    </div>

    <!-- Instructions -->
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="font-medium text-gray-800 flex items-center gap-2">
                <span class="material-icons-outlined text-lg">info</span>
                Petunjuk Import
            </h2>
        </div>
        <div class="p-5">
            <div class="mb-4">
                <a href="<?= base_url('admin/users/download_template') ?>"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg transition">
                    <span class="material-icons-outlined text-lg">download</span>
                    Download Template CSV
                </a>
            </div>

            <div class="text-sm text-gray-600 space-y-3">
                <p class="font-medium text-gray-700">Format Kolom:</p>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-2 text-left font-medium text-gray-600">Kolom</th>
                                <th class="px-3 py-2 text-left font-medium text-gray-600">Wajib</th>
                                <th class="px-3 py-2 text-left font-medium text-gray-600">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr>
                                <td class="px-3 py-2 font-mono">nama</td>
                                <td class="px-3 py-2"><span class="text-green-600">✓</span></td>
                                <td class="px-3 py-2">Nama lengkap mahasiswa</td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 font-mono">email</td>
                                <td class="px-3 py-2"><span class="text-green-600">✓</span></td>
                                <td class="px-3 py-2">Email (harus unik)</td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 font-mono">nim_nip</td>
                                <td class="px-3 py-2"><span class="text-green-600">✓</span></td>
                                <td class="px-3 py-2">NIM mahasiswa (jadi password)</td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 font-mono">prodi</td>
                                <td class="px-3 py-2"><span class="text-gray-400">-</span></td>
                                <td class="px-3 py-2">Program studi</td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 font-mono">angkatan</td>
                                <td class="px-3 py-2"><span class="text-gray-400">-</span></td>
                                <td class="px-3 py-2">Tahun angkatan</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 p-3 bg-amber-50 border border-amber-200 rounded-lg">
                    <p class="flex items-start gap-2">
                        <span class="material-icons-outlined text-amber-600 text-sm mt-0.5">info</span>
                        <span class="text-amber-700">
                            <strong>Password default</strong> = NIM/NIP mahasiswa
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CSV Preview Example -->
<div class="mt-6 bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="px-5 py-4 border-b border-gray-100">
        <h2 class="font-medium text-gray-800 flex items-center gap-2">
            <span class="material-icons-outlined text-lg">table_chart</span>
            Contoh Format Data
        </h2>
    </div>
    <div class="p-5">
        <div class="overflow-x-auto">
            <pre id="example-data"
                class="text-sm text-gray-600 bg-gray-50 p-4 rounded-lg overflow-x-auto cursor-pointer hover:bg-gray-100 transition"
                onclick="copyExample()">nama,email,nim_nip,prodi,angkatan
Ahmad Fauzi,ahmad@student.ac.id,2023001001,Teknik Informatika,2023
Siti Aminah,siti@student.ac.id,2023001002,Sistem Informasi,2023
Budi Santoso,budi@student.ac.id,2023001003,Teknik Informatika,2023</pre>
            <p class="text-xs text-gray-500 mt-2">Klik untuk menyalin contoh ke clipboard</p>
        </div>
    </div>
</div>

<script>
    function switchTab(tab) {
        // Hide all panels
        document.getElementById('panel-paste').classList.add('hidden');
        document.getElementById('panel-file').classList.add('hidden');

        // Remove active class from all tabs
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('border-brown-500', 'text-brown-600');
            btn.classList.add('border-transparent', 'text-gray-500');
        });

        // Show selected panel and activate tab
        document.getElementById('panel-' + tab).classList.remove('hidden');
        const activeTab = document.getElementById('tab-' + tab);
        activeTab.classList.remove('border-transparent', 'text-gray-500');
        activeTab.classList.add('border-brown-500', 'text-brown-600');
    }

    function copyExample() {
        const text = document.getElementById('example-data').textContent;
        navigator.clipboard.writeText(text).then(() => {
            alert('Contoh data berhasil disalin! Paste ke text area untuk menggunakannya.');
        });
    }
</script>