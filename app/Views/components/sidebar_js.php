<script>
/**
 * Toggle del sidebar (plegar/desplegar)
 */
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const icon = document.getElementById('toggleIcon');
    
    if (!sidebar || !icon) return;
    
    sidebar.classList.toggle('collapsed');
    
    if (sidebar.classList.contains('collapsed')) {
        icon.textContent = '▶';
        localStorage.setItem('sidebarCollapsed', 'true');
    } else {
        icon.textContent = '◀';
        localStorage.setItem('sidebarCollapsed', 'false');
    }
}

/**
 * Recordar estado del sidebar al recargar
 */
window.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.getElementById('sidebar');
    const icon = document.getElementById('toggleIcon');
    
    if (!sidebar || !icon) return;
    
    const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
    
    if (isCollapsed) {
        sidebar.classList.add('collapsed');
        icon.textContent = '▶';
    }
});

/**
 * Destacar menú activo según URL actual
 */
window.addEventListener('DOMContentLoaded', () => {
    const currentPath = window.location.pathname;
    const menuItems = document.querySelectorAll('.menu-item');
    
    menuItems.forEach(item => {
        const itemPath = new URL(item.href).pathname;
        
        // Remover clase active de todos
        item.classList.remove('active');
        
        // Agregar active si coincide la ruta
        if (itemPath === currentPath || 
            (currentPath.includes(itemPath) && itemPath !== '<?= site_url('admin/dashboard') ?>')) {
            item.classList.add('active');
        }
    });
});
</script>
