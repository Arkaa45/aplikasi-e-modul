<!-- Page Header -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-xl font-medium text-gray-800">
            <?= $page_title ?>
        </h1>
        <p class="text-sm text-gray-500">
            <?= $matkum->deskripsi ?? 'Mata Praktikum' ?>
        </p>
    </div>
    <a href="<?= base_url('laboran') ?>"
        class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
        <span class="material-icons-outlined text-lg">arrow_back</span>
        Kembali
    </a>
</div>

<!-- Content Sections -->
<div class="space-y-4">
    <!-- RPS Section -->
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <details class="group">
            <summary class="px-5 py-4 flex items-center justify-between cursor-pointer hover:bg-gray-50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                        <span class="material-icons-outlined text-blue-600">description</span>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-800">RPS (Rencana Pembelajaran Semester)</h3>
                        <p class="text-sm text-gray-500">
                            <?= count($rps_list) ?> file
                        </p>
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
                                <p class="font-medium text-gray-800">
                                    <?= htmlspecialchars($rps->judul) ?>
                                </p>
                            </div>
                            <div class="flex gap-2">
                                <a href="<?= base_url('uploads/rps/' . $rps->file_path) ?>" target="_blank"
                                    class="p-2 text-gray-500 hover:text-brown-500">
                                    <span class="material-icons-outlined">visibility</span>
                                </a>
                                <a href="<?= base_url('laboran/delete/rps/' . $rps->id) ?>"
                                    class="p-2 text-gray-500 hover:text-red-500" data-confirm-delete>
                                    <span class="material-icons-outlined">delete</span>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <a href="<?= base_url('laboran/upload/rps/' . $matkum->id) ?>"
                    class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm rounded-lg">
                    <span class="material-icons-outlined text-lg">upload</span>
                    Upload RPS
                </a>
            </div>
        </details>
    </div>

    <!-- Referensi Section -->
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <details class="group">
            <summary class="px-5 py-4 flex items-center justify-between cursor-pointer hover:bg-gray-50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center">
                        <span class="material-icons-outlined text-purple-600">library_books</span>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-800">Referensi</h3>
                        <p class="text-sm text-gray-500">
                            <?= count($referensi_list) ?> item
                        </p>
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
                                <p class="font-medium text-gray-800">
                                    <?= htmlspecialchars($ref->judul) ?>
                                </p>
                            </div>
                            <div class="flex gap-2">
                                <?php if ($ref->tipe == 'link'): ?>
                                    <a href="<?= $ref->link_external ?>" target="_blank"
                                        class="p-2 text-gray-500 hover:text-brown-500">
                                        <span class="material-icons-outlined">open_in_new</span>
                                    </a>
                                <?php else: ?>
                                    <a href="<?= base_url('uploads/referensi/' . $ref->file_path) ?>" target="_blank"
                                        class="p-2 text-gray-500 hover:text-brown-500">
                                        <span class="material-icons-outlined">visibility</span>
                                    </a>
                                <?php endif; ?>
                                <a href="<?= base_url('laboran/delete/referensi/' . $ref->id) ?>"
                                    class="p-2 text-gray-500 hover:text-red-500" data-confirm-delete>
                                    <span class="material-icons-outlined">delete</span>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <a href="<?= base_url('laboran/upload/referensi/' . $matkum->id) ?>"
                    class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-purple-500 hover:bg-purple-600 text-white text-sm rounded-lg">
                    <span class="material-icons-outlined text-lg">upload</span>
                    Upload Referensi
                </a>
            </div>
        </details>
    </div>

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
                        <p class="text-sm text-gray-500">16 slot tersedia</p>
                    </div>
                </div>
                <span class="material-icons-outlined text-gray-400 group-open:rotate-180 transition">expand_more</span>
            </summary>
            <div class="px-5 pb-5 border-t border-gray-100">
                <div class="mt-4 space-y-2">
                    <?php foreach ($modul_slots as $slot => $modul): ?>
                        <div
                            class="flex items-center justify-between p-3 <?= $modul ? 'bg-gray-50' : 'bg-gray-100 border-2 border-dashed border-gray-300' ?> rounded-lg">
                            <div class="flex items-center gap-3">
                                <span
                                    class="w-8 h-8 rounded-full <?= $modul ? 'bg-brown-500 text-white' : 'bg-gray-300 text-gray-500' ?> flex items-center justify-center text-sm font-medium">
                                    <?= $slot ?>
                                </span>
                                <?php if ($modul): ?>
                                    <div>
                                        <p class="font-medium text-gray-800">
                                            <?= htmlspecialchars($modul->judul_modul) ?>
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            <?= $modul->tipe_file ?>
                                            <?php if (!$modul->is_visible): ?>
                                                <span class="text-orange-500">(Tersembunyi)</span>
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                <?php else: ?>
                                    <p class="text-gray-500 text-sm">Slot kosong</p>
                                <?php endif; ?>
                            </div>
                            <div class="flex gap-2">
                                <?php if ($modul): ?>
                                    <a href="<?= base_url('laboran/toggle_modul/' . $modul->id) ?>"
                                        class="p-2 text-gray-500 hover:text-brown-500" title="Toggle visibilitas">
                                        <span class="material-icons-outlined">
                                            <?= $modul->is_visible ? 'visibility' : 'visibility_off' ?>
                                        </span>
                                    </a>
                                    <a href="<?= base_url('laboran/edit_modul/' . $modul->id) ?>"
                                        class="p-2 text-gray-500 hover:text-brown-500">
                                        <span class="material-icons-outlined">edit</span>
                                    </a>
                                    <a href="<?= base_url('laboran/delete/modul/' . $modul->id) ?>"
                                        class="p-2 text-gray-500 hover:text-red-500" data-confirm-delete>
                                        <span class="material-icons-outlined">delete</span>
                                    </a>
                                <?php else: ?>
                                    <a href="<?= base_url('laboran/upload/modul/' . $matkum->id) ?>?slot=<?= $slot ?>"
                                        class="px-3 py-1 text-sm bg-brown-500 text-white rounded hover:bg-brown-600">
                                        Upload
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </details>
    </div>
</div>