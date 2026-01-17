<!-- Breadcrumb -->
<div class="flex items-center gap-2 text-sm mb-6">
    <a href="<?= base_url('admin/matkum') ?>" class="text-gray-500 hover:text-brown-500">Mata Praktikum</a>
    <span class="material-icons-outlined text-gray-400 text-sm">chevron_right</span>
    <span class="text-gray-700">
        <?= htmlspecialchars($matkul->nama_matkul) ?>
    </span>
</div>

<!-- Page Header -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-xl font-medium text-gray-800">
            <?= $page_title ?>
        </h1>
        <p class="text-sm text-gray-500">Tugaskan laboran untuk mengelola modul mata praktikum ini</p>
    </div>
    <a href="<?= base_url('admin/matkum') ?>" class="text-brown-500 hover:text-brown-600 flex items-center gap-1">
        <span class="material-icons-outlined text-sm">arrow_back</span>
        Kembali
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Assigned Laborans -->
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 bg-green-50">
            <h2 class="font-medium text-gray-800 flex items-center gap-2">
                <span class="material-icons-outlined text-green-600">check_circle</span>
                Laboran Ditugaskan (
                <?= count($assigned_laborans) ?>)
            </h2>
        </div>
        <?php if (!empty($assigned_laborans)): ?>
            <div class="divide-y divide-gray-100">
                <?php foreach ($assigned_laborans as $laboran): ?>
                    <div class="px-5 py-4 flex items-center justify-between hover:bg-gray-50">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-100 text-green-600 rounded-full flex items-center justify-center">
                                <span class="material-icons-outlined">person</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">
                                    <?= htmlspecialchars($laboran->nama) ?>
                                </p>
                                <p class="text-sm text-gray-500">
                                    <?= htmlspecialchars($laboran->email) ?>
                                </p>
                            </div>
                        </div>
                        <form method="POST" class="inline">
                            <input type="hidden" name="laboran_id" value="<?= $laboran->id ?>">
                            <input type="hidden" name="action" value="remove">
                            <button type="submit" class="p-2 hover:bg-red-50 rounded-full text-red-500"
                                onclick="return confirm('Hapus laboran ini dari mata praktikum?')">
                                <span class="material-icons-outlined">remove_circle</span>
                            </button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="p-8 text-center">
                <span class="material-icons-outlined text-4xl text-gray-300 mb-2">person_off</span>
                <p class="text-gray-500">Belum ada laboran yang ditugaskan</p>
                <p class="text-gray-400 text-sm">Pilih laboran dari daftar di sebelah kanan</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Available Laborans -->
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 bg-blue-50">
            <h2 class="font-medium text-gray-800 flex items-center gap-2">
                <span class="material-icons-outlined text-blue-600">people</span>
                Laboran Tersedia
            </h2>
        </div>
        <?php
        $available_laborans = array_filter($all_laborans, function ($l) use ($assigned_ids) {
            return !in_array($l->id, $assigned_ids);
        });
        ?>
        <?php if (!empty($available_laborans)): ?>
            <div class="divide-y divide-gray-100">
                <?php foreach ($available_laborans as $laboran): ?>
                    <div class="px-5 py-4 flex items-center justify-between hover:bg-gray-50">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gray-100 text-gray-600 rounded-full flex items-center justify-center">
                                <span class="material-icons-outlined">person</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">
                                    <?= htmlspecialchars($laboran->nama) ?>
                                </p>
                                <p class="text-sm text-gray-500">
                                    <?= htmlspecialchars($laboran->email) ?>
                                </p>
                            </div>
                        </div>
                        <form method="POST" class="inline">
                            <input type="hidden" name="laboran_id" value="<?= $laboran->id ?>">
                            <input type="hidden" name="action" value="assign">
                            <button type="submit"
                                class="px-3 py-1.5 bg-brown-500 hover:bg-brown-600 text-white rounded-lg text-sm flex items-center gap-1">
                                <span class="material-icons-outlined text-sm">add</span>
                                Tugaskan
                            </button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="p-8 text-center">
                <?php if (empty($all_laborans)): ?>
                    <span class="material-icons-outlined text-4xl text-gray-300 mb-2">person_add</span>
                    <p class="text-gray-500">Belum ada laboran terdaftar</p>
                    <a href="<?= base_url('admin/users/create') ?>" class="text-brown-500 hover:underline text-sm">
                        Tambah laboran baru
                    </a>
                <?php else: ?>
                    <span class="material-icons-outlined text-4xl text-green-300 mb-2">check_circle</span>
                    <p class="text-gray-500">Semua laboran sudah ditugaskan</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Info -->
<div class="mt-6 bg-blue-50 rounded-xl p-5">
    <h3 class="font-medium text-gray-800 mb-2 flex items-center gap-2">
        <span class="material-icons-outlined text-blue-500">info</span>
        Informasi
    </h3>
    <ul class="text-sm text-gray-600 space-y-1">
        <li>• Laboran yang ditugaskan dapat mengelola modul dan pertemuan untuk mata praktikum ini</li>
        <li>• Satu laboran dapat ditugaskan ke beberapa mata praktikum</li>
        <li>• Pastikan laboran sudah membuat akun sebelum ditugaskan</li>
    </ul>
</div>