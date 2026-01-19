<!-- Page Header -->
<div class="mb-6">
    <h1 class="text-xl font-medium text-gray-800">
        <?= $page_title ?>
    </h1>
    <p class="text-sm text-gray-500">
        <a href="<?= base_url('admin/semester') ?>" class="hover:text-brown-500">Semester</a>
        <span class="mx-2">/</span>
        <a href="<?= base_url('admin/semester/detail/' . $semester->id) ?>" class="hover:text-brown-500">
            <?= $semester->nama_semester ?>
            <?= $semester->tahun_ajaran ?>
        </a>
        <span class="mx-2">/</span>
        <span>Import Mahasiswa</span>
    </p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Upload Form -->
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="font-medium text-gray-800 flex items-center gap-2">
                <span class="material-icons-outlined">upload_file</span>
                Upload File CSV
            </h2>
        </div>
        <div class="p-5">
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">File CSV</label>
                    <input type="file" name="csv_file" accept=".csv" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-500 focus:border-transparent">
                </div>

                <div class="bg-gray-50 rounded-lg p-4 mb-4">
                    <p class="text-sm text-gray-600 mb-2">
                        <strong>Catatan:</strong>
                    </p>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li>• Password default: <code class="bg-gray-200 px-1 rounded">password123</code></li>
                        <li>• Mahasiswa yang sudah ada akan otomatis ditambahkan ke semester</li>
                        <li>• Email yang sudah terdaftar dengan role berbeda akan dilewati</li>
                    </ul>
                </div>

                <button type="submit"
                    class="w-full px-4 py-3 bg-brown-500 hover:bg-brown-600 text-white rounded-lg transition flex items-center justify-center gap-2">
                    <span class="material-icons-outlined">upload</span>
                    Import Mahasiswa
                </button>
            </form>
        </div>
    </div>

    <!-- Format Info -->
    <div class="bg-cream-100 rounded-xl p-5 h-fit">
        <h3 class="font-medium text-gray-800 mb-3 flex items-center gap-2">
            <span class="material-icons-outlined text-brown-500">info</span>
            Format CSV
        </h3>
        <p class="text-sm text-gray-600 mb-3">File CSV harus memiliki header berikut:</p>
        <div class="bg-white rounded-lg p-3 font-mono text-sm text-gray-700 overflow-x-auto">
            nama,email,nim,prodi,angkatan
        </div>
        <p class="text-sm text-gray-600 mt-3 mb-2">Contoh:</p>
        <div class="bg-white rounded-lg p-3 font-mono text-xs text-gray-700 overflow-x-auto">
            <div>nama,email,nim,prodi,angkatan</div>
            <div>Andi Pratama,andi@student.ac.id,2024001001,Teknik Informatika,2024</div>
            <div>Budi Setiawan,budi@student.ac.id,2024001002,Sistem Informasi,2024</div>
        </div>
        <a href="<?= base_url('uploads/dummy_mahasiswa.csv') ?>"
            class="inline-flex items-center gap-2 mt-4 text-sm text-brown-600 hover:text-brown-700">
            <span class="material-icons-outlined text-lg">download</span>
            Download Template CSV
        </a>
    </div>
</div>

<div class="mt-6">
    <a href="<?= base_url('admin/semester/mahasiswa/' . $semester->id) ?>"
        class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
        <span class="material-icons-outlined">arrow_back</span>
        Kembali
    </a>
</div>