<!-- Page Header -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-xl font-medium text-gray-800"><?= $page_title ?></h1>
        <p class="text-sm text-gray-500"><?= $matkum->deskripsi ?? 'Mata Praktikum' ?></p>
    </div>
    <a href="<?= base_url('dashboard') ?>"
        class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
        <span class="material-icons-outlined text-lg">arrow_back</span>
        Kembali
    </a>
</div>

<!-- Content Sections -->
<div class="space-y-4">
    <!-- RPS Section -->
    <?php if (!empty($rps_list)): ?>
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <details class="group">
                <summary class="px-5 py-4 flex items-center justify-between cursor-pointer hover:bg-gray-50">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                            <span class="material-icons-outlined text-blue-600">description</span>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800">RPS (Rencana Pembelajaran Semester)</h3>
                            <p class="text-sm text-gray-500"><?= count($rps_list) ?> file</p>
                        </div>
                    </div>
                    <span class="material-icons-outlined text-gray-400 group-open:rotate-180 transition">expand_more</span>
                </summary>
                <div class="px-5 pb-5 border-t border-gray-100">
                    <div class="mt-4 space-y-2">
                        <?php foreach ($rps_list as $rps): ?>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <span class="material-icons-outlined text-red-500">picture_as_pdf</span>
                                    <p class="font-medium text-gray-800"><?= htmlspecialchars($rps->judul) ?></p>
                                </div>
                                <div class="flex gap-2">
                                    <a href="<?= base_url('mahasiswa/view/rps/' . $rps->id) ?>" target="_blank"
                                        class="px-3 py-1 text-sm bg-brown-100 text-brown-700 rounded hover:bg-brown-200">
                                        Buka
                                    </a>
                                    <a href="<?= base_url('mahasiswa/download/rps/' . $rps->id) ?>"
                                        class="px-3 py-1 text-sm border border-gray-300 text-gray-600 rounded hover:bg-gray-50">
                                        Download
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </details>
        </div>
    <?php endif; ?>

    <!-- Referensi Section -->
    <?php if (!empty($referensi_list)): ?>
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <details class="group">
                <summary class="px-5 py-4 flex items-center justify-between cursor-pointer hover:bg-gray-50">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center">
                            <span class="material-icons-outlined text-purple-600">library_books</span>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800">Referensi</h3>
                            <p class="text-sm text-gray-500"><?= count($referensi_list) ?> item</p>
                        </div>
                    </div>
                    <span class="material-icons-outlined text-gray-400 group-open:rotate-180 transition">expand_more</span>
                </summary>
                <div class="px-5 pb-5 border-t border-gray-100">
                    <div class="mt-4 space-y-2">
                        <?php foreach ($referensi_list as $ref): ?>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <span
                                        class="material-icons-outlined <?= $ref->tipe == 'link' ? 'text-blue-500' : 'text-orange-500' ?>">
                                        <?= $ref->tipe == 'link' ? 'link' : 'folder' ?>
                                    </span>
                                    <div>
                                        <p class="font-medium text-gray-800"><?= htmlspecialchars($ref->judul) ?></p>
                                        <?php if ($ref->deskripsi): ?>
                                            <p class="text-xs text-gray-500"><?= $ref->deskripsi ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php if ($ref->tipe == 'link'): ?>
                                    <a href="<?= $ref->link_external ?>" target="_blank"
                                        class="px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded hover:bg-blue-200 flex items-center gap-1">
                                        <span class="material-icons-outlined text-sm">open_in_new</span> Buka
                                    </a>
                                <?php else: ?>
                                    <a href="<?= base_url('mahasiswa/download/referensi/' . $ref->id) ?>"
                                        class="px-3 py-1 text-sm border border-gray-300 text-gray-600 rounded hover:bg-gray-50">
                                        Download
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </details>
        </div>
    <?php endif; ?>

    <!-- Modul Section -->
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <details class="group" open>
            <summary class="px-5 py-4 flex items-center justify-between cursor-pointer hover:bg-gray-50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-brown-100 flex items-center justify-center">
                        <span class="material-icons-outlined text-brown-600">menu_book</span>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-800">Modul Praktikum</h3>
                        <p class="text-sm text-gray-500">Materi pembelajaran</p>
                    </div>
                </div>
                <span class="material-icons-outlined text-gray-400 group-open:rotate-180 transition">expand_more</span>
            </summary>
            <div class="px-5 pb-5 border-t border-gray-100">
                <div class="mt-4 space-y-2">
                    <?php
                    $has_visible_modul = false;
                    foreach ($modul_slots as $slot => $modul):
                        if ($modul && $modul->is_visible):
                            $has_visible_modul = true;
                            ?>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <span
                                        class="w-8 h-8 rounded-full bg-brown-500 text-white flex items-center justify-center text-sm font-medium">
                                        <?= $slot ?>
                                    </span>
                                    <div>
                                        <p class="font-medium text-gray-800"><?= htmlspecialchars($modul->judul_modul) ?></p>
                                        <p class="text-xs text-gray-500"><?= ucfirst($modul->tipe_file) ?></p>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <?php if ($modul->tipe_file == 'link'): ?>
                                        <a href="<?= $modul->link_external ?>" target="_blank"
                                            class="px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded hover:bg-blue-200 flex items-center gap-1">
                                            <span class="material-icons-outlined text-sm">open_in_new</span> Buka
                                        </a>
                                    <?php elseif ($modul->tipe_file == 'pdf'): ?>
                                        <a href="<?= base_url('mahasiswa/view/modul/' . $modul->id) ?>" target="_blank"
                                            class="px-3 py-1 text-sm bg-brown-100 text-brown-700 rounded hover:bg-brown-200">
                                            Buka
                                        </a>
                                        <a href="<?= base_url('mahasiswa/download/modul/' . $modul->id) ?>"
                                            class="px-3 py-1 text-sm border border-gray-300 text-gray-600 rounded hover:bg-gray-50">
                                            Download
                                        </a>
                                    <?php else: ?>
                                        <a href="<?= base_url('mahasiswa/download/modul/' . $modul->id) ?>"
                                            class="px-3 py-1 text-sm bg-brown-100 text-brown-700 rounded hover:bg-brown-200">
                                            Download
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php
                        endif;
                    endforeach;

                    if (!$has_visible_modul): ?>
                        <div class="p-8 text-center">
                            <span class="material-icons-outlined text-4xl text-gray-300 mb-2">menu_book</span>
                            <p class="text-gray-500 text-sm">Belum ada modul tersedia</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </details>
    </div>
</div>