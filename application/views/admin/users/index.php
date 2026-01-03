<!-- Page Header -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-xl font-medium text-gray-800"><?= $page_title ?></h1>
        <p class="text-sm text-gray-500">Kelola data pengguna sistem</p>
    </div>
    <a href="<?= base_url('admin/users/create') ?>"
        class="inline-flex items-center gap-2 px-4 py-2 bg-brown-500 hover:bg-brown-600 text-white rounded-lg transition">
        <span class="material-icons-outlined text-lg">person_add</span>
        Tambah User
    </a>
</div>

<!-- Filter -->
<div class="bg-white rounded-xl border border-gray-200 p-4 mb-6">
    <form method="GET" class="flex items-center gap-4">
        <span class="text-sm text-gray-600">Filter Role:</span>
        <select name="role" onchange="this.form.submit()"
            class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-brown-400 focus:border-brown-400 outline-none">
            <option value="">Semua</option>
            <option value="admin" <?= $role_filter == 'admin' ? 'selected' : '' ?>>Admin</option>
            <option value="laboran" <?= $role_filter == 'laboran' ? 'selected' : '' ?>>Laboran</option>
            <option value="mahasiswa" <?= $role_filter == 'mahasiswa' ? 'selected' : '' ?>>Mahasiswa</option>
        </select>
    </form>
</div>

<!-- Users Table -->
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <?php if (!empty($users)): ?>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email
                        </th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIM/NIP
                        </th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status
                        </th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php $no = 1;
                    foreach ($users as $user): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-4 text-sm text-gray-600"><?= $no++ ?></td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-9 h-9 rounded-full bg-brown-400 flex items-center justify-center text-white text-sm font-medium">
                                        <?= strtoupper(substr($user->nama, 0, 1)) ?>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800"><?= htmlspecialchars($user->nama) ?></p>
                                        <?php if ($user->prodi): ?>
                                            <p class="text-xs text-gray-500"><?= htmlspecialchars($user->prodi) ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-600"><?= htmlspecialchars($user->email) ?></td>
                            <td class="px-5 py-4 text-sm text-gray-600"><?= htmlspecialchars($user->nim_nip ?? '-') ?></td>
                            <td class="px-5 py-4">
                                <?php
                                $role_colors = [
                                    'admin' => 'bg-red-100 text-red-700',
                                    'laboran' => 'bg-green-100 text-green-700',
                                    'mahasiswa' => 'bg-blue-100 text-blue-700'
                                ];
                                ?>
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-medium <?= $role_colors[$user->role] ?? 'bg-gray-100 text-gray-700' ?>">
                                    <?= ucfirst($user->role) ?>
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <?php if ($user->is_active): ?>
                                    <span class="inline-flex items-center gap-1 text-green-600 text-xs">
                                        <span class="material-icons-outlined text-sm">check_circle</span> Aktif
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1 text-gray-400 text-xs">
                                        <span class="material-icons-outlined text-sm">cancel</span> Nonaktif
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-1">
                                    <a href="<?= base_url('admin/users/edit/' . $user->id) ?>"
                                        class="p-2 hover:bg-gray-100 rounded-full" title="Edit">
                                        <span class="material-icons-outlined text-gray-500 text-lg">edit</span>
                                    </a>
                                    <a href="<?= base_url('admin/users/toggle/' . $user->id) ?>"
                                        class="p-2 hover:bg-gray-100 rounded-full" title="Toggle Status">
                                        <span class="material-icons-outlined text-gray-500 text-lg">toggle_on</span>
                                    </a>
                                    <a href="<?= base_url('admin/users/delete/' . $user->id) ?>"
                                        class="p-2 hover:bg-red-50 rounded-full" title="Hapus" data-confirm-delete>
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
            <span class="material-icons-outlined text-5xl text-gray-300 mb-3">people</span>
            <p class="text-gray-600 font-medium">Tidak ada user</p>
            <p class="text-gray-500 text-sm mb-4">Belum ada user yang terdaftar</p>
            <a href="<?= base_url('admin/users/create') ?>"
                class="inline-flex items-center gap-2 px-4 py-2 bg-brown-500 text-white rounded-lg">
                <span class="material-icons-outlined text-lg">person_add</span>
                Tambah User
            </a>
        </div>
    <?php endif; ?>
</div>