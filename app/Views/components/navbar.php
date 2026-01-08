<nav class="navbar">
    <h1><?= $page_title ?? $titulo ?? 'Admin Panel' ?></h1>
    <!-- <div class="nav-links">
            <a href="<?= site_url('admin/dashboard') ?>">Dashboard</a>
            <div class="user-info">
                <a href="<?= site_url('visitante/perfil') ?>" class="menu-item" data-tooltip="Mi Perfil"><span><?= session()->get('usuario_nombre') ?></span></a>
                <span class="badge">ADMIN</span>
            </div>
            <a href="<?= site_url('auth/logout') ?>" class="btn-logout">Cerrar Sesión</a>
    </div> -->
    <div class="navbar-right">
        <?php if (isset($back_url) && $back_url): ?>
            <a href="<?= $back_url ?>" class="btn-back">
                ← <?= $back_text ?? 'Volver' ?>
            </a>
        <?php endif; ?>
    </div>
</nav>