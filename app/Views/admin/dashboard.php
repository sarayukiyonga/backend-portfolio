<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
        }

        /* ========================================
           SIDEBAR LATERAL
        ======================================== */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: 250px;
            background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
            color: white;
            transition: width 0.3s ease;
            overflow: hidden;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }

        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar-header {
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            min-height: 70px;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            white-space: nowrap;
        }

        .sidebar-brand .icon {
            font-size: 28px;
            min-width: 28px;
        }

        .sidebar-brand .text {
            font-size: 18px;
            font-weight: 600;
            opacity: 1;
            transition: opacity 0.3s ease;
        }

        .sidebar.collapsed .sidebar-brand .text {
            opacity: 0;
            width: 0;
        }

        .toggle-btn {
            background: rgba(255,255,255,0.1);
            border: none;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            font-size: 18px;
        }

        .toggle-btn:hover {
            background: rgba(255,255,255,0.2);
        }

        .sidebar-menu {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 20px 0;
        }

        .sidebar-menu::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-menu::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.05);
        }

        .sidebar-menu::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.2);
            border-radius: 3px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 14px 20px;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            gap: 12px;
            white-space: nowrap;
        }

        .menu-item:hover {
            background: rgba(255,255,255,0.1);
        }

        .menu-item.active {
            background: rgba(255,255,255,0.15);
            border-left: 4px solid white;
        }

        .menu-item .icon {
            font-size: 22px;
            min-width: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .menu-item .text {
            font-size: 14px;
            font-weight: 500;
            opacity: 1;
            transition: opacity 0.3s ease;
        }

        .sidebar.collapsed .menu-item .text {
            opacity: 0;
            width: 0;
        }

        .menu-item .badge-notification {
            position: absolute;
            top: 8px;
            right: 20px;
            background: #dc3545;
            color: white;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 11px;
            animation: pulse 2s infinite;
        }

        .sidebar.collapsed .menu-item .badge-notification {
            right: 8px;
            top: 5px;
        }

        .menu-divider {
            height: 1px;
            background: rgba(255,255,255,0.1);
            margin: 10px 20px;
        }

        .sidebar-footer {
            padding: 15px 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            color: white;
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            min-width: 35px;
        }

        .user-details {
            flex: 1;
            opacity: 1;
            transition: opacity 0.3s ease;
        }

        .sidebar.collapsed .user-details {
            opacity: 0;
            width: 0;
        }

        .user-name {
            font-size: 13px;
            font-weight: 600;
        }

        .user-role {
            font-size: 11px;
            opacity: 0.8;
        }

        .logout-btn {
            background: rgba(255,255,255,0.1);
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .logout-btn:hover {
            background: rgba(255,255,255,0.2);
        }

        .sidebar.collapsed .logout-btn {
            padding: 8px;
            font-size: 0;
        }

        .sidebar.collapsed .logout-btn::before {
            content: "🚪";
            font-size: 18px;
        }

        /* ========================================
           CONTENIDO PRINCIPAL
        ======================================== */
        .main-content {
            margin-left: 250px;
            transition: margin-left 0.3s ease;
            min-height: 100vh;
        }

        .sidebar.collapsed ~ .main-content {
            margin-left: 70px;
        }

        .navbar {
            background: white;
            padding: 15px 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h1 {
            font-size: 24px;
            color: #333;
        }

        .container {
            max-width: 1400px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .section-title {
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .card h3 {
            font-size: 42px;
            margin-bottom: 10px;
        }

        .card p {
            color: #666;
            font-size: 16px;
        }

        .card-usuarios h3 { color: #667eea; }
        .card-admin h3 { color: #764ba2; }
        .card-visitantes h3 { color: #17a2b8; }
        .card-activos h3 { color: #28a745; }
        .card-pendientes { border-left: 4px solid #ffc107; }
        .card-pendientes h3 { color: #ffc107; }
        .card-proyectos h3 { color: #20c997; }
        .card-proyectos-activos h3 { color: #28a745; }
        .card-proyectos-inactivos h3 { color: #dc3545; }
        .card-proyectos-anio h3 { color: #fd7e14; }

        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-warning {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
        }

        .proyecto-reciente {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .proyecto-reciente img {
            width: 150px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
        }

        .proyecto-reciente-info h4 {
            color: #667eea;
            margin-bottom: 8px;
        }

        .proyecto-reciente-info p {
            color: #666;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .separador {
            height: 2px;
            background: linear-gradient(90deg, #667eea 0%, transparent 100%);
            margin: 40px 0;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
        }

        /* ========================================
           RESPONSIVE
        ======================================== */
        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
            }

            .sidebar-brand .text,
            .menu-item .text,
            .user-details {
                opacity: 0;
                width: 0;
            }

            .main-content {
                margin-left: 70px;
            }

            .toggle-btn {
                display: none;
            }
        }

        /* Tooltip para sidebar colapsado */
        .menu-item {
            position: relative;
        }

        .sidebar.collapsed .menu-item::after {
            content: attr(data-tooltip);
            position: absolute;
            left: 70px;
            background: #333;
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 13px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
            z-index: 1000;
        }

        .sidebar.collapsed .menu-item:hover::after {
            opacity: 1;
        }
    </style>
</head>
<body>
    <!-- ========================================
         SIDEBAR LATERAL
    ======================================== -->
    <div class="sidebar" id="sidebar">
        <!-- Header del Sidebar -->
        <div class="sidebar-header">
            <div class="sidebar-brand">
                <span class="icon">🛡️</span>
                <span class="text">Admin Panel</span>
            </div>
            <button class="toggle-btn" onclick="toggleSidebar()">
                <span id="toggleIcon">◀</span>
            </button>
        </div>

        <!-- Menú de Navegación -->
        <div class="sidebar-menu">
            <a href="<?= site_url('admin/dashboard') ?>" class="menu-item active" data-tooltip="Dashboard">
                <span class="icon">📊</span>
                <span class="text">Dashboard</span>
            </a>

            <?php if ($pendientes > 0): ?>
                <a href="<?= site_url('admin/usuariosPendientes') ?>" class="menu-item" data-tooltip="Aprobar Usuarios">
                    <span class="icon">⏳</span>
                    <span class="text">Aprobar Usuarios</span>
                    <span class="badge-notification"><?= $pendientes ?></span>
                </a>
            <?php endif; ?>

            <a href="<?= site_url('proyectos') ?>" class="menu-item" data-tooltip="Proyectos">
                <span class="icon">🎨</span>
                <span class="text">Proyectos</span>
            </a>

            <a href="<?= site_url('recursos/admin') ?>" class="menu-item" data-tooltip="Documentos">
                <span class="icon">📄</span>
                <span class="text">Documentos</span>
            </a>

            <?php if (isset($mensajes_sin_leer) && $mensajes_sin_leer > 0): ?>
                <a href="<?= site_url('admin/contactos') ?>" class="menu-item" data-tooltip="Mensajes de Contacto">
                    <span class="icon">✉️</span>
                    <span class="text">Mensajes</span>
                    <span class="badge-notification"><?= $mensajes_sin_leer ?></span>
                </a>
            <?php else: ?>
                <a href="<?= site_url('admin/contactos') ?>" class="menu-item" data-tooltip="Mensajes de Contacto">
                    <span class="icon">✉️</span>
                    <span class="text">Mensajes</span>
                </a>
            <?php endif; ?>

            <div class="menu-divider"></div>

            <a href="<?= site_url('admin/usuarios') ?>" class="menu-item" data-tooltip="Gestión de Usuarios">
                <span class="icon">👥</span>
                <span class="text">Gestión de Usuarios</span>
            </a>

            <a href="<?= site_url('admin/crearUsuario') ?>" class="menu-item" data-tooltip="Crear Usuario">
                <span class="icon">➕</span>
                <span class="text">Crear Usuario</span>
            </a>

            <div class="menu-divider"></div>

            <a href="<?= site_url('visitante/perfil') ?>" class="menu-item" data-tooltip="Mi Perfil">
                <span class="icon">👤</span>
                <span class="text">Mi Perfil</span>
            </a>
        </div>

        <!-- Footer del Sidebar -->
        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">👤</div>
                <div class="user-details">
                    <div class="user-name"><?= session()->get('usuario_nombre') ?></div>
                    <div class="user-role">ADMIN</div>
                </div>
            </div>
            <a href="<?= site_url('auth/logout') ?>" class="logout-btn" style="margin-top: 10px; display: block; text-align: center;">
                Cerrar Sesión
            </a>
        </div>
    </div>

    <!-- ========================================
         CONTENIDO PRINCIPAL
    ======================================== -->
    <div class="main-content">
        <nav class="navbar">
            <h1>🏠 Panel de Administración</h1>
        </nav>
        
        <div class="container">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>
            
            <?php if ($pendientes > 0): ?>
                <div class="alert alert-warning">
                    ⚠️ <strong>¡Atención!</strong> Hay <strong><?= $pendientes ?></strong> usuario(s) esperando aprobación.
                    <a href="<?= site_url('admin/usuariosPendientes') ?>" style="color: #856404; text-decoration: underline; font-weight: bold;">Ver ahora</a>
                </div>
            <?php endif; ?>
            
            <?php if (isset($mensajes_sin_leer) && $mensajes_sin_leer > 0): ?>
                <div class="alert alert-warning">
                    ✉️ <strong>¡Tienes mensajes nuevos!</strong> Hay <strong><?= $mensajes_sin_leer ?></strong> mensaje(s) sin leer en el formulario de contacto.
                    <a href="<?= site_url('admin/contactos') ?>" style="color: #856404; text-decoration: underline; font-weight: bold;">Ver ahora</a>
                </div>
            <?php endif; ?>

            <!-- ESTADÍSTICAS DE USUARIOS -->
            <h2 class="section-title">👥 Estadísticas de Usuarios</h2>
            <div class="dashboard-grid">
                <div class="card card-pendientes">
                    <h3><?= $pendientes ?></h3>
                    <p>⏳ Pendientes de Aprobación</p>
                </div>
                <div class="card card-usuarios">
                    <h3><?= count($usuarios) ?></h3>
                    <p>Total de Usuarios</p>
                </div>
                <div class="card card-admin">
                    <h3><?= count(array_filter($usuarios, fn($u) => $u['rol_nombre'] == 'admin')) ?></h3>
                    <p>Administradores</p>
                </div>
                <div class="card card-visitantes">
                    <h3><?= count(array_filter($usuarios, fn($u) => $u['rol_nombre'] == 'visitante')) ?></h3>
                    <p>Visitantes</p>
                </div>
                <div class="card card-activos">
                    <h3><?= count(array_filter($usuarios, fn($u) => $u['activo'] == 1)) ?></h3>
                    <p>Usuarios Activos</p>
                </div>
            </div>
            
            <div class="separador"></div>
            
            <!-- ESTADÍSTICAS DE PROYECTOS -->
            <h2 class="section-title">🎨 Estadísticas de Proyectos</h2>
            <div class="dashboard-grid">
                <div class="card card-proyectos">
                    <h3><?= $totalProyectos ?></h3>
                    <p>Total de Proyectos</p>
                </div>
                <div class="card card-proyectos-activos">
                    <h3><?= $proyectosActivos ?></h3>
                    <p>✔ Proyectos Activos</p>
                </div>
                <div class="card card-proyectos-inactivos">
                    <h3><?= $proyectosInactivos ?></h3>
                    <p>✗ Proyectos Inactivos</p>
                </div>
                <div class="card card-proyectos-anio">
                    <h3><?= $proyectosEsteAnio ?></h3>
                    <p>📅 Proyectos de <?= date('Y') ?></p>
                </div>
            </div>
            
            <!-- PROYECTO MÁS RECIENTE -->
            <?php if ($proyectoReciente): ?>
                <h3 style="color: #333; margin-top: 20px; margin-bottom: 15px;">🆕 Último Proyecto Creado</h3>
                <div class="proyecto-reciente">
                    <?php if ($proyectoReciente['imagen_principal']): ?>
                        <img src="<?= base_url('uploads/proyectos/' . $proyectoReciente['imagen_principal']) ?>" 
                             alt="<?= esc($proyectoReciente['nombre']) ?>">
                    <?php else: ?>
                        <div style="width: 150px; height: 100px; background: #e0e0e0; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #999;">
                            Sin imagen
                        </div>
                    <?php endif; ?>
                    <div class="proyecto-reciente-info">
                        <h4><?= esc($proyectoReciente['nombre']) ?></h4>
                        <p><strong>Cliente:</strong> <?= $proyectoReciente['cliente'] ?: 'No especificado' ?></p>
                        <p><strong>Año:</strong> <?= $proyectoReciente['anio'] ?: 'No especificado' ?></p>
                        <p><strong>Creado:</strong> <?= date('d/m/Y H:i', strtotime($proyectoReciente['created_at'])) ?></p>
                        <p>
                            <a href="<?= site_url('proyectos/ver/' . $proyectoReciente['id']) ?>" 
                               style="color: #667eea; text-decoration: none; font-weight: 600;">
                                👁️ Ver proyecto
                            </a>
                            |
                            <a href="<?= site_url('proyectos/editar/' . $proyectoReciente['id']) ?>" 
                               style="color: #ffc107; text-decoration: none; font-weight: 600;">
                                ✏️ Editar
                            </a>
                        </p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- ========================================
         JAVASCRIPT
    ======================================== -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const icon = document.getElementById('toggleIcon');
            
            sidebar.classList.toggle('collapsed');
            
            if (sidebar.classList.contains('collapsed')) {
                icon.textContent = '▶';
                localStorage.setItem('sidebarCollapsed', 'true');
            } else {
                icon.textContent = '◀';
                localStorage.setItem('sidebarCollapsed', 'false');
            }
        }

        // Recordar estado del sidebar
        window.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const icon = document.getElementById('toggleIcon');
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            
            if (isCollapsed) {
                sidebar.classList.add('collapsed');
                icon.textContent = '▶';
            }
        });

        // Destacar menú activo según URL
        window.addEventListener('DOMContentLoaded', () => {
            const currentPath = window.location.pathname;
            const menuItems = document.querySelectorAll('.menu-item');
            
            menuItems.forEach(item => {
                item.classList.remove('active');
                if (item.getAttribute('href') === currentPath || 
                    (currentPath.includes(item.getAttribute('href')) && item.getAttribute('href') !== '<?= site_url('admin/dashboard') ?>')) {
                    item.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>
