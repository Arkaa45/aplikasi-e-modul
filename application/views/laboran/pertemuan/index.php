<!-- Page Header -->
<div class="mb-6">
    <h1 class="text-xl font-medium text-gray-800"><?= $page_title ?></h1>
    <p class="text-sm text-gray-500">
        <a href="<?= base_url('dashboard') ?>" class="hover:text-brown-500">Dashboard</a>
        <span class="mx-2">/</span>
        <a href="<?= base_url('laboran/finish_pertemuan') ?>" class="hover:text-brown-500">Pertemuan</a>
        <span class="mx-2">/</span>
        <span><?= htmlspecialchars($selected_matkul->nama_matkul) ?></span>
    </p>
</div>

<?php if (!$current_semester): ?>
    <div class="p-4 bg-amber-50 border border-amber-200 text-amber-700 rounded-lg flex items-center gap-3">
        <span class="material-icons-outlined">warning</span>
        Belum ada semester aktif.
    </div>
<?php else: ?>

    <!-- Matkul & Semester Info -->
    <div class="mb-6 p-4 bg-brown-500 text-white rounded-xl flex items-center justify-between">
        <div class="flex items-center gap-4">
            <span class="material-icons-outlined text-3xl opacity-80">menu_book</span>
            <div>
                <p class="font-medium"><?= htmlspecialchars($selected_matkul->nama_matkul) ?></p>
                <p class="text-sm opacity-80"><?= $selected_matkul->kode_matkul ?> • <?= $current_semester->nama_semester ?>
                    <?= $current_semester->tahun_ajaran ?></p>
            </div>
        </div>
        <div class="flex gap-2">
            <a href="<?= base_url('laboran/pertemuan/create') ?>"
                class="px-4 py-2 bg-white text-brown-600 rounded-lg text-sm font-medium hover:bg-gray-100 transition flex items-center gap-2">
                <span class="material-icons-outlined text-lg">add</span>
                Tambah Pertemuan
            </a>
            <a href="<?= base_url('laboran/finish_pertemuan') ?>"
                class="px-4 py-2 bg-brown-600 text-white rounded-lg text-sm font-medium hover:bg-brown-700 transition">
                Ganti Mata Praktikum
            </a>
        </div>
    </div>

    <!-- Pertemuan List -->
    <?php if (!empty($pertemuan)): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($pertemuan as $p): ?>
                <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition card-hover">
                    <div class="flex items-start gap-3">
                        <div
                            class="w-10 h-10 rounded-lg bg-brown-100 flex items-center justify-center text-brown-700 font-semibold">
                            <?= $p->pertemuan_ke ?>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-medium text-gray-800"><?= htmlspecialchars($p->judul) ?></h3>
                            <?php if ($p->deskripsi): ?>
                                <p class="text-sm text-gray-500 mt-1"><?= htmlspecialchars(substr($p->deskripsi, 0, 80)) ?>...</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="flex justify-end gap-1 mt-4 pt-3 border-t border-gray-100">
                        <a href="<?= base_url('laboran/pertemuan/edit/' . $p->id) ?>" class="p-2 hover:bg-gray-100 rounded-full">
                            <span class="material-icons-outlined text-gray-500 text-lg">edit</span>
                        </a>
                        <a href="<?= base_url('laboran/pertemuan/delete/' . $p->id) ?>" class="p-2 hover:bg-red-50 rounded-full"
                            data-confirm-delete>
                            <span class="material-icons-outlined text-red-500 text-lg">delete</span>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="bg-white rounded-xl border border-gray-200 p-12 text-center">
            <span class="material-icons-outlined text-5xl text-gray-300 mb-3">event</span>
            <p class="text-gray-600 font-medium">Belum ada pertemuan</p>
            <p class="text-gray-500 text-sm mb-4">Tambahkan pertemuan untuk mata praktikum ini</p>
            <a href="<?= base_url('laboran/pertemuan/create') ?>"
                class="inline-flex items-center gap-2 px-4 py-2 bg-brown-500 text-white rounded-lg">
                <span class="material-icons-outlined text-lg">add</span>
                Tambah Pertemuan
            </a>
        </div>
    <?php endif; ?>

<?php endif; ?>