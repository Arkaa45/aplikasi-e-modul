</div>
</main>

<!-- Scripts -->
<script>
    // Sidebar Toggle
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    }

    function closeSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    }

    document.getElementById('sidebarToggle')?.addEventListener('click', toggleSidebar);

    // User Dropdown
    function toggleDropdown() {
        document.getElementById('dropdownMenu').classList.toggle('hidden');
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function (e) {
        const dropdown = document.getElementById('userDropdown');
        const menu = document.getElementById('dropdownMenu');
        if (dropdown && !dropdown.contains(e.target)) {
            menu?.classList.add('hidden');
        }
    });

    // Auto-hide alerts after 5 seconds
    setTimeout(() => {
        document.getElementById('alertSuccess')?.remove();
        document.getElementById('alertError')?.remove();
    }, 5000);

    // Confirm delete
    document.querySelectorAll('[data-confirm-delete]').forEach(el => {
        el.addEventListener('click', function (e) {
            if (!confirm('Apakah Anda yakin ingin menghapus?')) {
                e.preventDefault();
            }
        });
    });
</script>
</body>

</html>