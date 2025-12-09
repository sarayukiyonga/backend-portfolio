
<div class="sidebar" id="sidebar">
    <!-- Header del Sidebar -->
    <div class="sidebar-header">
        <div class="sidebar-brand">
            <span class="icon">🛡️</span>
            <span class="text">Admin Panel</span>
        </div>
    </div>
        <button class="toggle-btn" onclick="toggleSidebar()" title="Plegar/Desplegar menú">
            <span id="toggleIcon">◀</span>
        </button>
    <!-- Menú de Navegación -->
    <div class="sidebar-menu">
        <a href="<?= site_url('admin/dashboard') ?>" 
           class="menu-item <?= ($active_menu ?? '') == 'dashboard' ? 'active' : '' ?>" 
           data-tooltip="Dashboard">
            <span class="icon">📊</span>
            <span class="text">Dashboard</span>
        </a>

        <?php if (isset($pendientes) && $pendientes > 0): ?>
            <a href="<?= site_url('admin/usuariosPendientes') ?>" 
               class="menu-item <?= ($active_menu ?? '') == 'pendientes' ? 'active' : '' ?>" 
               data-tooltip="Aprobar Usuarios">
                <span class="icon">⏳</span>
                <span class="text">Aprobar Usuarios</span>
                <span class="badge-notification"><?= $pendientes ?></span>
            </a>
        <?php endif; ?>

        <a href="<?= site_url('proyectos') ?>" 
           class="menu-item <?= ($active_menu ?? '') == 'proyectos' ? 'active' : '' ?>" 
           data-tooltip="Proyectos">
            <span class="icon">🎨</span>
            <span class="text">Proyectos</span>
        </a>

        <a href="<?= site_url('recursos/admin') ?>" 
           class="menu-item <?= ($active_menu ?? '') == 'recursos' ? 'active' : '' ?>" 
           data-tooltip="Documentos">
            <span class="icon">📄</span>
            <span class="text">Documentos</span>
        </a>

        <?php if (isset($mensajes_sin_leer) && $mensajes_sin_leer > 0): ?>
            <a href="<?= site_url('admin/contactos') ?>" 
               class="menu-item <?= ($active_menu ?? '') == 'contactos' ? 'active' : '' ?>" 
               data-tooltip="Mensajes de Contacto">
                <span class="icon">✉️</span>
                <span class="text">Mensajes</span>
                <span class="badge-notification"><?= $mensajes_sin_leer ?></span>
            </a>
        <?php else: ?>
            <a href="<?= site_url('admin/contactos') ?>" 
               class="menu-item <?= ($active_menu ?? '') == 'contactos' ? 'active' : '' ?>" 
               data-tooltip="Mensajes de Contacto">
                <span class="icon">✉️</span>
                <span class="text">Mensajes</span>
            </a>
        <?php endif; ?>

        <div class="menu-divider"></div>

        <a href="<?= site_url('admin/usuarios') ?>" 
           class="menu-item <?= ($active_menu ?? '') == 'usuarios' ? 'active' : '' ?>" 
           data-tooltip="Gestión de Usuarios">
            <span class="icon">👥</span>
            <span class="text">Gestión de Usuarios</span>
        </a>

        <a href="<?= site_url('admin/crearUsuario') ?>" 
           class="menu-item <?= ($active_menu ?? '') == 'crear' ? 'active' : '' ?>" 
           data-tooltip="Crear Usuario">
            <span class="icon">➕</span>
            <span class="text">Crear Usuario</span>
        </a>

        <div class="menu-divider"></div>

        <a href="<?= site_url('visitante/perfil') ?>" 
           class="menu-item <?= ($active_menu ?? '') == 'perfil' ? 'active' : '' ?>" 
           data-tooltip="Mi Perfil">
            <span class="icon">👤</span>
            <span class="text">Mi Perfil</span>
        </a>
    </div>

    <!-- Footer del Sidebar -->
    <div class="sidebar-footer">
        <div class="user-info">
            <div class="user-avatar">👤</div>
            <div class="user-details">
                <div class="user-name"><?= session()->get('usuario_nombre') ?? 'Usuario' ?></div>
                <div class="user-role">ADMIN</div>
            </div>
        </div>
        <a href="<?= site_url('auth/logout') ?>" class="logout-btn" style="margin-top: 10px; display: block; text-align: center;">
            Cerrar Sesión
        </a>
    </div>
</div>
