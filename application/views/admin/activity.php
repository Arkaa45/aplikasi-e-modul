<!-- Page Header -->
<div class="mb-6">
    <h1 class="text-xl font-medium text-gray-800"><?= $page_title ?></h1>
    <p class="text-sm text-gray-500">Riwayat aktivitas pengguna sistem</p>
</div>

<!-- Activity Log Table -->
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <?php if (!empty($logs)): ?>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu
                        </th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi
                        </th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IP</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php foreach ($logs as $log): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-4 text-sm text-gray-500">
                                <?= date('d M Y H:i', strtotime($log->created_at)) ?>
                            </td>
                            <td class="px-5 py-4">
                                <p class="font-medium text-gray-800 text-sm"><?= htmlspecialchars($log->user_nama) ?></p>
                                <?php
                                $role_colors = [
                                    'admin' => 'bg-red-100 text-red-700',
                                    'laboran' => 'bg-green-100 text-green-700',
                                    'mahasiswa' => 'bg-blue-100 text-blue-700'
                                ];
                                ?>
                                <span class="px-2 py-0.5 rounded text-xs <?= $role_colors[$log->user_role] ?? 'bg-gray-100' ?>">
                                    <?= ucfirst($log->user_role) ?>
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <?php
                                $action_colors = [
                                    'login' => 'bg-green-100 text-green-700',
                                    'logout' => 'bg-gray-100 text-gray-700',
                                    'create' => 'bg-blue-100 text-blue-700',
                                    'update' => 'bg-amber-100 text-amber-700',
                                    'delete' => 'bg-red-100 text-red-700'
                                ];
                                $color = 'bg-gray-100 text-gray-700';
                                foreach ($action_colors as $key => $val) {
                                    if (strpos($log->action, $key) !== false) {
                                        $color = $val;
                                        break;
                                    }
                                }
                                ?>
                                <span class="px-2 py-1 rounded text-xs font-medium <?= $color ?>">
                                    <?= htmlspecialchars($log->action) ?>
                                </span>
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-500 max-w-xs truncate">
                                <?= htmlspecialchars($log->description ?? '-') ?>
                            </td>
                            <td class="px-5 py-4">
                                <code class="text-xs text-gray-500"><?= htmlspecialchars($log->ip_address) ?></code>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="p-12 text-center">
            <span class="material-icons-outlined text-5xl text-gray-300 mb-3">history</span>
            <p class="text-gray-500">Tidak ada aktivitas tercatat</p>
        </div>
    <?php endif; ?>
</div>