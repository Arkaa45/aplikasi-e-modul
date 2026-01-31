<!-- Page Header -->
<div class="mb-6">
    <h1 class="text-xl font-medium text-gray-800">
        <?= $page_title ?>
    </h1>
    <p class="text-sm text-gray-500">Kelola mahasiswa yang dapat mengakses mata praktikum ini</p>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-gray-200 p-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                <span class="material-icons-outlined text-blue-600">school</span>
            </div>
            <div>
                <p class="text-2xl font-semibold text-gray-800">
                    <?= count($assigned_mahasiswa) ?>
                </p>
                <p class="text-sm text-gray-500">Mahasiswa Terdaftar</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center">
                <span class="material-icons-outlined text-gray-600">groups</span>
            </div>
            <div>
                <p class="text-2xl font-semibold text-gray-800">
                    <?= count($all_mahasiswa) ?>
                </p>
                <p class="text-sm text-gray-500">Total Mahasiswa di Sistem</p>
            </div>
        </div>
    </div>
</div>

<!-- Filter & Search Bar -->
<div class="bg-white rounded-xl border border-gray-200 p-4 mb-4">
    <div class="flex flex-col md:flex-row gap-4">
        <!-- Search Input -->
        <div class="flex-1 relative">
            <span class="material-icons-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
            <input type="text" id="searchInput" placeholder="Cari nama atau NIM mahasiswa..."
                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-500 focus:border-brown-500 transition">
        </div>
        <!-- Filter Angkatan -->
        <div class="md:w-48">
            <select id="filterAngkatan"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-500 focus:border-brown-500 transition bg-white">
                <option value="">Semua Angkatan</option>
                <?php foreach ($angkatan_list as $ank): ?>
                    <option value="<?= $ank->angkatan ?>"><?= $ank->angkatan ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <!-- Filter Status -->
        <div class="md:w-48">
            <select id="filterStatus"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-500 focus:border-brown-500 transition bg-white">
                <option value="">Semua Status</option>
                <option value="assigned">Sudah Terdaftar</option>
                <option value="unassigned">Belum Terdaftar</option>
            </select>
        </div>
    </div>
    <!-- Filter Info -->
    <div id="filterInfo" class="mt-3 text-sm text-gray-500 hidden">
        Menampilkan <span id="filteredCount" class="font-medium text-gray-700">0</span> dari
        <span class="font-medium text-gray-700"><?= count($all_mahasiswa) ?></span> mahasiswa
    </div>
</div>

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
        <h2 class="font-medium text-gray-800">Daftar Mahasiswa</h2>
        <div class="text-sm text-gray-500">
            <span class="text-green-600 font-medium">
                <?= count($assigned_mahasiswa) ?>
            </span> terdaftar dari
            <span class="font-medium">
                <?= count($all_mahasiswa) ?>
            </span> mahasiswa
        </div>
    </div>
    <div class="divide-y divide-gray-100" id="mahasiswaList">
        <?php if (!empty($all_mahasiswa)): ?>
            <?php foreach ($all_mahasiswa as $mhs): ?>
                <?php $is_assigned = in_array($mhs->id, $assigned_ids); ?>
                <div class="mahasiswa-row px-5 py-4 flex items-center justify-between hover:bg-gray-50"
                    data-nama="<?= htmlspecialchars($mhs->nama) ?>" data-nim="<?= htmlspecialchars($mhs->nim_nip) ?>"
                    data-angkatan="<?= $mhs->angkatan ?? '' ?>" data-status="<?= $is_assigned ? 'assigned' : 'unassigned' ?>">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-full <?= $is_assigned ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-500' ?> flex items-center justify-center font-medium">
                            <?= strtoupper(substr($mhs->nama, 0, 1)) ?>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">
                                <?= htmlspecialchars($mhs->nama) ?>
                            </p>
                            <p class="text-sm text-gray-500">
                                <?= $mhs->nim_nip ?> •
                                <?= $mhs->prodi ?? '-' ?> • Angkatan
                                <?= $mhs->angkatan ?? '-' ?>
                            </p>
                        </div>
                        <?php if ($is_assigned): ?>
                            <span class="ml-2 px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full">Terdaftar</span>
                        <?php endif; ?>
                    </div>
                    <form method="POST" class="inline">
                        <input type="hidden" name="mahasiswa_id" value="<?= $mhs->id ?>">
                        <?php if ($is_assigned): ?>
                            <input type="hidden" name="action" value="remove">
                            <button type="submit"
                                class="px-4 py-2 bg-red-100 text-red-600 text-sm rounded-lg hover:bg-red-200 transition">
                                Hapus
                            </button>
                        <?php else: ?>
                            <input type="hidden" name="action" value="assign">
                            <button type="submit"
                                class="px-4 py-2 bg-green-100 text-green-600 text-sm rounded-lg hover:bg-green-200 transition">
                                Tambahkan
                            </button>
                        <?php endif; ?>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="p-8 text-center">
                <span class="material-icons-outlined text-4xl text-gray-300 mb-2">school</span>
                <p class="text-gray-500">Tidak ada mahasiswa tersedia</p>
                <a href="<?= base_url('admin/users/create') ?>" class="text-brown-500 text-sm">Tambah user mahasiswa</a>
            </div>
        <?php endif; ?>
    </div>
    <!-- Empty State for Filter -->
    <div id="emptyFilterState" class="p-8 text-center hidden">
        <span class="material-icons-outlined text-4xl text-gray-300 mb-2">search_off</span>
        <p class="text-gray-500">Tidak ada mahasiswa yang sesuai dengan filter</p>
        <button onclick="resetFilters()" class="text-brown-500 text-sm hover:underline">Reset filter</button>
    </div>
</div>

<div class="mt-6 flex gap-3">
    <a href="<?= base_url('admin/matkum/detail/' . $matkum->id) ?>"
        class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
        <span class="material-icons-outlined">arrow_back</span>
        Kembali ke Detail
    </a>
    <a href="<?= base_url('admin/matkum') ?>"
        class="inline-flex items-center gap-2 px-4 py-2 text-gray-600 hover:text-gray-800">
        Lihat Semua Mata Praktikum
    </a>
</div>

<script>
    // Filter elements
    const searchInput = document.getElementById('searchInput');
    const filterAngkatan = document.getElementById('filterAngkatan');
    const filterStatus = document.getElementById('filterStatus');
    const filterInfo = document.getElementById('filterInfo');
    const filteredCount = document.getElementById('filteredCount');
    const emptyState = document.getElementById('emptyFilterState');
    const mahasiswaRows = document.querySelectorAll('.mahasiswa-row');

    // Add event listeners
    searchInput.addEventListener('input', filterMahasiswa);
    filterAngkatan.addEventListener('change', filterMahasiswa);
    filterStatus.addEventListener('change', filterMahasiswa);

    function filterMahasiswa() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const angkatan = filterAngkatan.value;
        const status = filterStatus.value;

        let visibleCount = 0;
        let hasActiveFilters = searchTerm !== '' || angkatan !== '' || status !== '';

        mahasiswaRows.forEach(row => {
            const nama = row.dataset.nama.toLowerCase();
            const nim = row.dataset.nim.toLowerCase();
            const rowAngkatan = row.dataset.angkatan;
            const rowStatus = row.dataset.status;

            // Check all filter conditions
            const matchSearch = searchTerm === '' || nama.includes(searchTerm) || nim.includes(searchTerm);
            const matchAngkatan = angkatan === '' || rowAngkatan === angkatan;
            const matchStatus = status === '' || rowStatus === status;

            if (matchSearch && matchAngkatan && matchStatus) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Update filter info
        if (hasActiveFilters) {
            filterInfo.classList.remove('hidden');
            filteredCount.textContent = visibleCount;
        } else {
            filterInfo.classList.add('hidden');
        }

        // Show/hide empty state
        if (visibleCount === 0 && mahasiswaRows.length > 0) {
            emptyState.classList.remove('hidden');
        } else {
            emptyState.classList.add('hidden');
        }
    }

    function resetFilters() {
        searchInput.value = '';
        filterAngkatan.value = '';
        filterStatus.value = '';
        filterMahasiswa();
    }
</script>