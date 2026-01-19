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
        <span>Assign Mata Praktikum</span>
    </p>
</div>

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="px-5 py-4 border-b border-gray-100">
        <h2 class="font-medium text-gray-800">Pilih Mata Praktikum</h2>
        <p class="text-sm text-gray-500">Centang mata praktikum yang tersedia di semester ini</p>
    </div>

    <div class="divide-y divide-gray-100">
        <?php if (!empty($all_matkum)): ?>
            <?php foreach ($all_matkum as $matkum): ?>
                <?php $is_assigned = in_array($matkum->id, $assigned_ids); ?>
                <div class="px-5 py-4 flex items-center justify-between hover:bg-gray-50">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-brown-100 flex items-center justify-center">
                            <span class="material-icons-outlined text-brown-600">menu_book</span>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">
                                <?= htmlspecialchars($matkum->nama_matkul) ?>
                            </p>
                            <p class="text-sm text-gray-500">
                                <?= $matkum->kode_matkul ?>
                            </p>
                        </div>
                    </div>
                    <form method="POST" class="inline">
                        <input type="hidden" name="matkul_id" value="<?= $matkum->id ?>">
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
                <span class="material-icons-outlined text-4xl text-gray-300 mb-2">menu_book</span>
                <p class="text-gray-500">Belum ada mata praktikum. <a href="<?= base_url('admin/matkum/create') ?>"
                        class="text-brown-500">Buat dulu</a></p>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="mt-6">
    <a href="<?= base_url('admin/semester/detail/' . $semester->id) ?>"
        class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
        <span class="material-icons-outlined">arrow_back</span>
        Kembali
    </a>
</div>