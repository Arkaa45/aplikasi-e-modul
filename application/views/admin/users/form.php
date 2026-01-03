<!-- Page Header -->
<div class="mb-6">
    <h1 class="text-xl font-medium text-gray-800"><?= $page_title ?></h1>
    <p class="text-sm text-gray-500">
        <a href="<?= base_url('dashboard') ?>" class="hover:text-brown-500">Dashboard</a>
        <span class="mx-2">/</span>
        <a href="<?= base_url('admin/users') ?>" class="hover:text-brown-500">Kelola User</a>
        <span class="mx-2">/</span>
        <span><?= $edit_mode ? 'Edit' : 'Tambah' ?></span>
    </p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Form -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <form action="" method="POST">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nama" name="nama" required
                               value="<?= htmlspecialchars($user_data->nama ?? '') ?>"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-400 focus:border-brown-400 outline-none">
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" id="email" name="email" required
                               value="<?= htmlspecialchars($user_data->email ?? '') ?>"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-400 focus:border-brown-400 outline-none">
                    </div>
                    
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                            Password <?= !$edit_mode ? '<span class="text-red-500">*</span>' : '<span class="text-gray-400 text-xs">(Kosongkan jika tidak diubah)</span>' ?>
                        </label>
                        <input type="password" id="password" name="password" <?= !$edit_mode ? 'required' : '' ?>
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-400 focus:border-brown-400 outline-none">
                    </div>
                    
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-1">
                            Role <span class="text-red-500">*</span>
                        </label>
                        <select id="role" name="role" required onchange="toggleRoleFields()"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-400 focus:border-brown-400 outline-none">
                            <option value="">Pilih Role</option>
                            <option value="admin" <?= ($user_data->role ?? '') == 'admin' ? 'selected' : '' ?>>Admin</option>
                            <option value="laboran" <?= ($user_data->role ?? '') == 'laboran' ? 'selected' : '' ?>>Laboran</option>
                            <option value="mahasiswa" <?= ($user_data->role ?? '') == 'mahasiswa' ? 'selected' : '' ?>>Mahasiswa</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="nim_nip" class="block text-sm font-medium text-gray-700 mb-1">NIM/NIP</label>
                        <input type="text" id="nim_nip" name="nim_nip"
                               value="<?= htmlspecialchars($user_data->nim_nip ?? '') ?>"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-400 focus:border-brown-400 outline-none">
                    </div>
                    
                    <div class="mahasiswa-field hidden">
                        <label for="prodi" class="block text-sm font-medium text-gray-700 mb-1">Program Studi</label>
                        <input type="text" id="prodi" name="prodi"
                               value="<?= htmlspecialchars($user_data->prodi ?? '') ?>"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-400 focus:border-brown-400 outline-none">
                    </div>
                    
                    <div class="mahasiswa-field hidden">
                        <label for="angkatan" class="block text-sm font-medium text-gray-700 mb-1">Angkatan</label>
                        <select id="angkatan" name="angkatan"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-400 focus:border-brown-400 outline-none">
                            <option value="">Pilih Tahun</option>
                            <?php for ($year = date('Y'); $year >= 2015; $year--): ?>
                            <option value="<?= $year ?>" <?= ($user_data->angkatan ?? '') == $year ? 'selected' : '' ?>><?= $year ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
                
                <div class="mt-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" <?= ($user_data->is_active ?? 1) ? 'checked' : '' ?>
                               class="w-4 h-4 text-brown-500 border-gray-300 rounded focus:ring-brown-400">
                        <span class="text-sm text-gray-700">User Aktif</span>
                    </label>
                </div>
                
                <div class="flex gap-3 mt-6 pt-6 border-t border-gray-200">
                    <button type="submit" class="px-5 py-2.5 bg-brown-500 hover:bg-brown-600 text-white rounded-lg transition">
                        <?= $edit_mode ? 'Simpan Perubahan' : 'Tambah User' ?>
                    </button>
                    <a href="<?= base_url('admin/users') ?>" class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Info Card -->
    <div>
        <div class="bg-cream-100 rounded-xl p-5">
            <h3 class="font-medium text-gray-800 mb-3 flex items-center gap-2">
                <span class="material-icons-outlined text-brown-500">info</span>
                Informasi
            </h3>
            <ul class="text-sm text-gray-600 space-y-2">
                <li><strong>Admin:</strong> Dapat mengelola semua data</li>
                <li><strong>Laboran:</strong> Dapat mengelola modul dan pertemuan</li>
                <li><strong>Mahasiswa:</strong> Dapat mengakses modul praktikum</li>
            </ul>
        </div>
    </div>
</div>

<script>
function toggleRoleFields() {
    const role = document.getElementById('role').value;
    document.querySelectorAll('.mahasiswa-field').forEach(el => {
        el.classList.toggle('hidden', role !== 'mahasiswa');
    });
}
document.addEventListener('DOMContentLoaded', toggleRoleFields);
</script>
