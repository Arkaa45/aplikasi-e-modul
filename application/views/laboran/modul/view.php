<!-- Page Header -->
<div class="mb-6">
    <h1 class="text-xl font-medium text-gray-800">
        <?= $page_title ?>
    </h1>
    <p class="text-sm text-gray-500">
        <a href="<?= base_url('dashboard') ?>" class="hover:text-brown-500">Dashboard</a>
        <span class="mx-2">/</span>
        <a href="<?= base_url('laboran/modul') ?>" class="hover:text-brown-500">Kelola Modul</a>
        <span class="mx-2">/</span>
        <span>
            <?= htmlspecialchars($modul->judul_modul) ?>
        </span>
    </p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content: Preview & Details -->
    <div class="lg:col-span-2 space-y-6">

        <!-- File Preview -->
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="font-medium text-gray-800">Preview Modul</h2>
                <span class="px-2 py-1 bg-brown-100 text-brown-700 text-xs rounded uppercase">
                    <?= $modul->tipe_file ?>
                </span>
            </div>

            <div class="p-6 bg-gray-50 min-h-[300px] flex items-center justify-center">
                <?php if ($modul->tipe_file == 'pdf' && $modul->file_modul): ?>
                    <embed src="<?= base_url('uploads/modul/' . $modul->file_modul) ?>" type="application/pdf" width="100%"
                        height="600px" class="rounded-lg shadow-sm">
                <?php elseif ($modul->tipe_file == 'video' && $modul->file_modul): ?>
                    <video controls class="w-full rounded-lg shadow-sm">
                        <source src="<?= base_url('uploads/modul/' . $modul->file_modul) ?>" type="video/mp4">
                        Browser Anda tidak mendukung tag video.
                    </video>
                <?php elseif ($modul->tipe_file == 'link' && $modul->link_external): ?>
                    <div class="text-center">
                        <span class="material-icons-outlined text-6xl text-brown-300 mb-2">link</span>
                        <p class="mb-4 text-gray-600">Modul ini adalah link eksternal</p>
                        <a href="<?= $modul->link_external ?>" target="_blank"
                            class="inline-flex items-center gap-2 px-6 py-2.5 bg-brown-500 text-white rounded-lg hover:bg-brown-600 transition">
                            Buka Link <span class="material-icons-outlined text-sm">open_in_new</span>
                        </a>
                    </div>
                <?php else: ?>
                    <div class="text-center">
                        <span class="material-icons-outlined text-6xl text-gray-300 mb-2">description</span>
                        <p class="mb-4 text-gray-600">Preview tidak tersedia untuk tipe file ini</p>
                        <?php if ($modul->file_modul): ?>
                            <a href="<?= base_url('uploads/modul/' . $modul->file_modul) ?>" target="_blank"
                                class="inline-flex items-center gap-2 px-6 py-2.5 bg-brown-500 text-white rounded-lg hover:bg-brown-600 transition">
                                Download File <span class="material-icons-outlined text-sm">download</span>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Description -->
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="font-medium text-gray-800 mb-3">Deskripsi Modul</h3>
            <div class="prose prose-sm max-w-none text-gray-600">
                <?= nl2br(htmlspecialchars($modul->deskripsi ?? 'Tidak ada deskripsi.')) ?>
            </div>
        </div>

    </div>

    <!-- Sidebar: Info -->
    <div class="space-y-6">
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="font-medium text-gray-800 mb-4">Informasi Modul</h3>
            <div class="space-y-4">
                <div>
                    <p class="text-xs text-gray-500 mb-1">Mata Praktikum</p>
                    <p class="font-medium text-gray-800">
                        <?= $modul->nama_matkul ?>
                    </p>
                    <p class="text-sm text-gray-500">
                        <?= $modul->kode_matkul ?>
                    </p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-1">Pertemuan</p>
                    <span class="px-2 py-1 bg-brown-100 text-brown-700 text-sm rounded">
                        Pertemuan
                        <?= $modul->pertemuan_ke ?>
                    </span>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-1">Semester</p>
                    <p class="text-sm text-gray-700">
                        <?= $modul->nama_semester ?>
                        <?= $modul->tahun_ajaran ?>
                    </p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-1">Diupload Oleh</p>
                    <p class="text-sm text-gray-700">
                        <?= $modul->uploader_nama ?>
                    </p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-1">Status</p>
                    <?php if ($modul->is_visible): ?>
                        <span class="inline-flex items-center gap-1 text-green-600 text-sm">
                            <span class="material-icons-outlined text-sm">visibility</span> Visible
                        </span>
                    <?php else: ?>
                        <span class="inline-flex items-center gap-1 text-gray-400 text-sm">
                            <span class="material-icons-outlined text-sm">visibility_off</span> Hidden
                        </span>
                    <?php endif; ?>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-1">Tanggal Upload</p>
                    <p class="text-sm text-gray-700">
                        <?= date('d F Y, H:i', strtotime($modul->created_at)) ?>
                    </p>
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-gray-100 flex flex-col gap-2">
                <a href="<?= base_url('laboran/modul/edit/' . $modul->id) ?>"
                    class="w-full px-4 py-2 bg-gray-50 hover:bg-gray-100 text-gray-700 rounded-lg text-sm font-medium transition flex items-center justify-center gap-2">
                    <span class="material-icons-outlined text-lg">edit</span> Edit Modul
                </a>
                <?php if ($modul->file_modul): ?>
                    <a href="<?= base_url('uploads/modul/' . $modul->file_modul) ?>" download
                        class="w-full px-4 py-2 bg-brown-50 hover:bg-brown-100 text-brown-700 rounded-lg text-sm font-medium transition flex items-center justify-center gap-2">
                        <span class="material-icons-outlined text-lg">download</span> Download File
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>