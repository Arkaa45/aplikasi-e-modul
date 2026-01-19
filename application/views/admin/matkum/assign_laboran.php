<!-- Page Header -->
<div class="mb-6">
    <h1 class="text-xl font-medium text-gray-800"><?= $page_title ?></h1>
    <p class="text-sm text-gray-500">Kelola laboran yang ditugaskan ke mata praktikum ini</p>
</div>

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="divide-y divide-gray-100">
        <?php if (!empty($all_laborans)): ?>
            <?php foreach ($all_laborans as $laboran): ?>
                <?php $is_assigned = in_array($laboran->id, $assigned_ids); ?>
                <div class="px-5 py-4 flex items-center justify-between hover:bg-gray-50">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-medium">
                            <?= strtoupper(substr($laboran->nama, 0, 1)) ?>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800"><?= htmlspecialchars($laboran->nama) ?></p>
                            <p class="text-sm text-gray-500"><?= $laboran->email ?></p>
                        </div>
                    </div>
                    <form method="POST" class="inline">
                        <input type="hidden" name="laboran_id" value="<?= $laboran->id ?>">
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
                                Tugaskan
                            </button>
                        <?php endif; ?>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="p-8 text-center">
                <span class="material-icons-outlined text-4xl text-gray-300 mb-2">badge</span>
                <p class="text-gray-500">Tidak ada laboran tersedia</p>
                <a href="<?= base_url('admin/users/create') ?>" class="text-brown-500 text-sm">Tambah user laboran</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="mt-6">
    <a href="<?= base_url('admin/matkum/detail/' . $matkum->id) ?>"
        class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
        <span class="material-icons-outlined">arrow_back</span>
        Kembali
    </a>
</div>