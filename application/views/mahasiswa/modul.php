<!-- Page Header -->
<div class="mb-6">
    <h1 class="text-xl font-medium text-gray-800"><?= $page_title ?></h1>
    <p class="text-sm text-gray-500">
        <a href="<?= base_url('dashboard') ?>" class="hover:text-brown-500">Dashboard</a>
        <span class="mx-2">/</span>
        <a href="<?= base_url('mahasiswa/pertemuan/' . $pertemuan->id_matkul) ?>"
            class="hover:text-brown-500">Pertemuan</a>
        <span class="mx-2">/</span>
        <span>Modul</span>
    </p>
</div>

<!-- Pertemuan Info -->
<div class="mb-6 p-4 bg-cream-100 rounded-xl flex items-center gap-3">
    <div class="w-10 h-10 rounded-lg bg-brown-400 flex items-center justify-center text-white font-semibold">
        <?= $pertemuan->pertemuan_ke ?>
    </div>
    <div>
        <p class="font-medium text-gray-800"><?= htmlspecialchars($pertemuan->judul) ?></p>
        <p class="text-sm text-gray-500"><?= htmlspecialchars($pertemuan->nama_matkul) ?> •
            <?= $pertemuan->nama_semester ?> <?= $pertemuan->tahun_ajaran ?></p>
    </div>
</div>

<!-- Modul List -->
<div class="space-y-4">
    <?php if (!empty($moduls)): ?>
        <?php foreach ($moduls as $modul): ?>
            <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition card-hover">
                <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                    <div class="flex items-start gap-4 flex-1">
                        <?php
                        $type_icons = [
                            'pdf' => ['picture_as_pdf', 'bg-red-100 text-red-500'],
                            'video' => ['play_circle', 'bg-blue-100 text-blue-500'],
                            'link' => ['link', 'bg-green-100 text-green-500'],
                            'lainnya' => ['description', 'bg-gray-100 text-gray-500']
                        ];
                        $icon = $type_icons[$modul->tipe_file] ?? $type_icons['lainnya'];
                        ?>
                        <div class="w-12 h-12 rounded-lg <?= $icon[1] ?> flex items-center justify-center flex-shrink-0">
                            <span class="material-icons-outlined text-2xl"><?= $icon[0] ?></span>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800"><?= htmlspecialchars($modul->judul_modul) ?></h3>
                            <?php if ($modul->deskripsi): ?>
                                <p class="text-sm text-gray-500"><?= htmlspecialchars($modul->deskripsi) ?></p>
                            <?php endif; ?>
                            <div class="flex items-center gap-4 mt-2 text-xs text-gray-400">
                                <span class="flex items-center gap-1">
                                    <span class="material-icons-outlined text-sm">schedule</span>
                                    <?= date('d M Y', strtotime($modul->created_at)) ?>
                                </span>
                                <span class="flex items-center gap-1">
                                    <span class="material-icons-outlined text-sm">download</span>
                                    <?= $modul->download_count ?> downloads
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-2 sm:flex-col">
                        <?php if ($modul->tipe_file == 'pdf'): ?>
                            <a href="<?= base_url('mahasiswa/view/' . $modul->id) ?>" target="_blank"
                                class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-brown-500 hover:bg-brown-600 text-white rounded-lg transition">
                                <span class="material-icons-outlined text-lg">visibility</span>
                                <span class="hidden sm:inline">Lihat</span>
                            </a>
                        <?php endif; ?>

                        <?php if ($modul->tipe_file == 'link'): ?>
                            <a href="<?= htmlspecialchars($modul->link_external) ?>" target="_blank"
                                class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg transition">
                                <span class="material-icons-outlined text-lg">open_in_new</span>
                                <span class="hidden sm:inline">Buka</span>
                            </a>
                        <?php else: ?>
                            <a href="<?= base_url('mahasiswa/download/' . $modul->id) ?>"
                                class="inline-flex items-center justify-center gap-2 px-4 py-2 border border-gray-300 text-gray-700 hover:bg-gray-50 rounded-lg transition">
                                <span class="material-icons-outlined text-lg">download</span>
                                <span class="hidden sm:inline">Download</span>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="bg-white rounded-xl border border-gray-200 p-12 text-center">
            <span class="material-icons-outlined text-5xl text-gray-300 mb-3">description</span>
            <p class="text-gray-600 font-medium">Belum ada modul</p>
            <p class="text-gray-500 text-sm mb-4">Modul untuk pertemuan ini belum tersedia</p>
            <a href="<?= base_url('mahasiswa/pertemuan/' . $pertemuan->id_matkul) ?>"
                class="inline-flex items-center gap-2 px-4 py-2 bg-brown-500 text-white rounded-lg">
                <span class="material-icons-outlined text-lg">arrow_back</span>
                Kembali
            </a>
        </div>
    <?php endif; ?>
</div>