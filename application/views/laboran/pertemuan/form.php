<!-- Page Header -->
<div class="mb-6">
    <h1 class="text-xl font-medium text-gray-800"><?= $page_title ?></h1>
    <p class="text-sm text-gray-500">
        <a href="<?= base_url('dashboard') ?>" class="hover:text-brown-500">Dashboard</a>
        <span class="mx-2">/</span>
        <a href="<?= base_url('laboran/pertemuan') ?>" class="hover:text-brown-500">Pertemuan</a>
        <span class="mx-2">/</span>
        <span><?= $edit_mode ? 'Edit' : 'Tambah' ?></span>
    </p>
</div>

<?php if (!$current_semester): ?>
    <div class="p-4 bg-amber-50 border border-amber-200 text-amber-700 rounded-lg">
        Belum ada semester aktif.
    </div>
<?php else: ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <form action="" method="POST">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="id_matkul" class="block text-sm font-medium text-gray-700 mb-1">Mata Kuliah</label>
                            <select id="id_matkul" name="id_matkul" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-400 focus:border-brown-400 outline-none">
                                <option value="">Pilih</option>
                                <?php foreach ($my_matkul as $matkul): ?>
                                    <option value="<?= $matkul->id ?>" <?= ($pertemuan_data->id_matkul ?? '') == $matkul->id ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($matkul->nama_matkul) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div>
                            <label for="pertemuan_ke" class="block text-sm font-medium text-gray-700 mb-1">Pertemuan
                                Ke</label>
                            <input type="number" id="pertemuan_ke" name="pertemuan_ke" required min="1" max="20"
                                value="<?= $pertemuan_data->pertemuan_ke ?? '' ?>"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-400 focus:border-brown-400 outline-none">
                        </div>
                    </div>

                    <div class="mt-4">
                        <label for="judul" class="block text-sm font-medium text-gray-700 mb-1">Judul Pertemuan</label>
                        <input type="text" id="judul" name="judul" required placeholder="Contoh: Pengenalan DBMS"
                            value="<?= htmlspecialchars($pertemuan_data->judul ?? '') ?>"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-400 focus:border-brown-400 outline-none">
                    </div>

                    <div class="mt-4">
                        <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                        <input type="date" id="tanggal" name="tanggal" value="<?= $pertemuan_data->tanggal ?? '' ?>"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-400 focus:border-brown-400 outline-none">
                    </div>

                    <div class="mt-4">
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea id="deskripsi" name="deskripsi" rows="2"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-400 focus:border-brown-400 outline-none"><?= htmlspecialchars($pertemuan_data->deskripsi ?? '') ?></textarea>
                    </div>

                    <div class="flex gap-3 mt-6 pt-6 border-t border-gray-200">
                        <button type="submit"
                            class="px-5 py-2.5 bg-brown-500 hover:bg-brown-600 text-white rounded-lg transition">
                            <?= $edit_mode ? 'Simpan' : 'Tambah' ?>
                        </button>
                        <a href="<?= base_url('laboran/pertemuan') ?>"
                            class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="bg-cream-100 rounded-xl p-5 h-fit">
            <h3 class="font-medium text-gray-800 mb-2">Semester Aktif</h3>
            <p class="text-lg font-semibold text-brown-600"><?= $current_semester->nama_semester ?>
                <?= $current_semester->tahun_ajaran ?></p>
        </div>
    </div>

<?php endif; ?>