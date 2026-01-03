<!-- Page Header -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-xl font-medium text-gray-800"><?= $page_title ?></h1>
        <p class="text-sm text-gray-500">Kelola modul yang telah Anda upload</p>
    </div>
    <a href="<?= base_url('laboran/upload') ?>"
        class="inline-flex items-center gap-2 px-4 py-2 bg-brown-500 hover:bg-brown-600 text-white rounded-lg transition">
        <span class="material-icons-outlined text-lg">upload_file</span>
        Upload Modul
    </a>
</div>

<!-- Modul Table -->
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <?php if (!empty($moduls)): ?>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Modul
                        </th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mata
                            Kuliah</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pertemuan
                        </th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status
                        </th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php foreach ($moduls as $modul): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-4">
                                <p class="font-medium text-gray-800"><?= htmlspecialchars($modul->judul_modul) ?></p>
                                <p class="text-xs text-gray-500"><?= date('d M Y', strtotime($modul->created_at)) ?></p>
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-600"><?= htmlspecialchars($modul->nama_matkul) ?></td>
                            <td class="px-5 py-4">
                                <span class="px-2 py-1 bg-brown-100 text-brown-700 text-xs rounded">Pertemuan
                                    <?= $modul->pertemuan_ke ?></span>
                            </td>
                            <td class="px-5 py-4">
                                <?php
                                $type_icons = [
                                    'pdf' => ['picture_as_pdf', 'text-red-500'],
                                    'video' => ['play_circle', 'text-blue-500'],
                                    'link' => ['link', 'text-green-500'],
                                    'lainnya' => ['description', 'text-gray-500']
                                ];
                                $icon = $type_icons[$modul->tipe_file] ?? ['description', 'text-gray-500'];
                                ?>
                                <span class="material-icons-outlined <?= $icon[1] ?>"><?= $icon[0] ?></span>
                            </td>
                            <td class="px-5 py-4">
                                <?php if ($modul->is_visible): ?>
                                    <span class="inline-flex items-center gap-1 text-green-600 text-xs">
                                        <span class="material-icons-outlined text-sm">visibility</span> Visible
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1 text-gray-400 text-xs">
                                        <span class="material-icons-outlined text-sm">visibility_off</span> Hidden
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-1">
                                    <a href="<?= base_url('laboran/modul/edit/' . $modul->id) ?>"
                                        class="p-2 hover:bg-gray-100 rounded-full">
                                        <span class="material-icons-outlined text-gray-500 text-lg">edit</span>
                                    </a>
                                    <a href="<?= base_url('laboran/modul/toggle/' . $modul->id) ?>"
                                        class="p-2 hover:bg-gray-100 rounded-full">
                                        <span class="material-icons-outlined text-gray-500 text-lg">visibility</span>
                                    </a>
                                    <a href="<?= base_url('laboran/modul/delete/' . $modul->id) ?>"
                                        class="p-2 hover:bg-red-50 rounded-full" data-confirm-delete>
                                        <span class="material-icons-outlined text-red-500 text-lg">delete</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="p-12 text-center">
            <span class="material-icons-outlined text-5xl text-gray-300 mb-3">cloud_upload</span>
            <p class="text-gray-600 font-medium">Belum ada modul</p>
            <a href="<?= base_url('laboran/upload') ?>"
                class="inline-flex items-center gap-2 px-4 py-2 bg-brown-500 text-white rounded-lg mt-4">
                <span class="material-icons-outlined text-lg">upload_file</span>
                Upload Modul
            </a>
        </div>
    <?php endif; ?>
</div>