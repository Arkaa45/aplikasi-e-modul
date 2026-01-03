<!-- Page Header -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-xl font-medium text-gray-800"><?= $page_title ?></h1>
        <p class="text-sm text-gray-500">Atur jadwal pertemuan praktikum</p>
    </div>
    <a href="<?= base_url('laboran/pertemuan/create') ?>"
        class="inline-flex items-center gap-2 px-4 py-2 bg-brown-500 hover:bg-brown-600 text-white rounded-lg transition">
        <span class="material-icons-outlined text-lg">add</span>
        Tambah Pertemuan
    </a>
</div>

<!-- Filter -->
<div class="bg-white rounded-xl border border-gray-200 p-4 mb-6">
    <form method="GET" class="flex flex-wrap items-center gap-4">
        <span class="text-sm text-gray-600">Mata Kuliah:</span>
        <select name="matkul" onchange="this.form.submit()"
            class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-brown-400 outline-none">
            <option value="">-- Pilih --</option>
            <?php foreach ($my_matkul as $matkul): ?>
                <option value="<?= $matkul->id ?>" <?= $matkul_id == $matkul->id ? 'selected' : '' ?>>
                    <?= htmlspecialchars($matkul->nama_matkul) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if ($current_semester): ?>
            <span class="px-3 py-1 bg-green-100 text-green-700 text-sm rounded-full">
                <?= $current_semester->nama_semester ?>     <?= $current_semester->tahun_ajaran ?>
            </span>
        <?php endif; ?>
    </form>
</div>

<!-- Pertemuan List -->
<?php if ($matkul_id): ?>
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <?php if (!empty($pertemuan)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-5">
                <?php foreach ($pertemuan as $p): ?>
                    <div class="border border-gray-200 rounded-xl p-4 hover:border-brown-300 transition">
                        <div class="flex items-start gap-3">
                            <div
                                class="w-10 h-10 rounded-lg bg-brown-100 flex items-center justify-center text-brown-700 font-semibold">
                                <?= $p->pertemuan_ke ?>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-medium text-gray-800"><?= htmlspecialchars($p->judul) ?></h3>
                                <?php if ($p->tanggal): ?>
                                    <p class="text-xs text-gray-500 mt-1">
                                        <span class="material-icons-outlined text-xs align-middle">calendar_today</span>
                                        <?= date('d M Y', strtotime($p->tanggal)) ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="flex gap-2 mt-3 pt-3 border-t border-gray-100">
                            <a href="<?= base_url('laboran/pertemuan/edit/' . $p->id) ?>"
                                class="flex-1 px-3 py-1.5 text-center text-sm border border-gray-300 rounded-lg hover:bg-gray-50">Edit</a>
                            <a href="<?= base_url('laboran/pertemuan/delete/' . $p->id) ?>"
                                class="px-3 py-1.5 text-sm text-red-600 border border-red-200 rounded-lg hover:bg-red-50"
                                data-confirm-delete>Hapus</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="p-12 text-center">
                <span class="material-icons-outlined text-5xl text-gray-300 mb-3">event</span>
                <p class="text-gray-600 font-medium">Belum ada pertemuan</p>
                <a href="<?= base_url('laboran/pertemuan/create') ?>"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-brown-500 text-white rounded-lg mt-4">
                    <span class="material-icons-outlined text-lg">add</span>
                    Tambah Pertemuan
                </a>
            </div>
        <?php endif; ?>
    </div>
<?php else: ?>
    <div class="bg-white rounded-xl border border-gray-200 p-12 text-center">
        <span class="material-icons-outlined text-5xl text-gray-300 mb-3">touch_app</span>
        <p class="text-gray-500">Pilih mata kuliah untuk melihat pertemuan</p>
    </div>
<?php endif; ?>