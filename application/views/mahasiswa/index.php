<!-- Page Header -->
<div class="mb-6">
    <h1 class="text-xl font-medium text-gray-800">Selamat Datang,
        <?= htmlspecialchars($this->session->userdata('nama')) ?>!
    </h1>
    <p class="text-sm text-gray-500">Akses modul praktikum Anda</p>
</div>

<?php if (isset($current_semester) && $current_semester): ?>
    <div class="mb-6 inline-flex items-center gap-2 px-4 py-2 bg-brown-100 text-brown-700 rounded-full text-sm">
        <span class="material-icons-outlined text-lg">calendar_today</span>
        Semester:
        <?= $current_semester->nama_semester ?>
        <?= $current_semester->tahun_ajaran ?>
    </div>
<?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Mata Praktikum from Current Semester -->
    <div class="lg:col-span-2">
        <h2 class="text-sm font-medium text-gray-600 mb-4">Mata Praktikum Semester Ini</h2>

        <?php if (!empty($my_matkum)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php foreach ($my_matkum as $matkum): ?>
                    <a href="<?= base_url('mahasiswa/matkum/' . $matkum->id . '/' . $current_semester->id) ?>"
                        class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition card-hover">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-lg bg-brown-400 flex items-center justify-center flex-shrink-0">
                                <span class="material-icons-outlined text-white">menu_book</span>
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-800">
                                    <?= htmlspecialchars($matkum->nama_matkul) ?>
                                </h3>
                                <p class="text-sm text-gray-500">
                                    <?= $matkum->kode_matkul ?>
                                </p>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="bg-white rounded-xl border border-gray-200 p-10 text-center">
                <span class="material-icons-outlined text-5xl text-gray-300 mb-3">menu_book</span>
                <p class="text-gray-600 font-medium">Belum terdaftar di mata praktikum</p>
                <p class="text-gray-500 text-sm">Hubungi admin untuk pendaftaran</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Semester History -->
    <div>
        <h2 class="text-sm font-medium text-gray-600 mb-4">Riwayat Semester</h2>
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <?php if (!empty($my_semesters)): ?>
                <div class="divide-y divide-gray-100">
                    <?php foreach ($my_semesters as $semester): ?>
                        <a href="<?= base_url('mahasiswa/semester/' . $semester->id) ?>"
                            class="block px-5 py-4 hover:bg-gray-50 transition">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-medium text-gray-800">
                                        <?= $semester->nama_semester ?>
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        <?= $semester->tahun_ajaran ?>
                                    </p>
                                </div>
                                <span class="material-icons-outlined text-gray-400">chevron_right</span>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="p-8 text-center">
                    <span class="material-icons-outlined text-4xl text-gray-300 mb-2">calendar_today</span>
                    <p class="text-gray-500 text-sm">Belum terdaftar di semester</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>