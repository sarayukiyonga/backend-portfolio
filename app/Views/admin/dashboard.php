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
        
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .navbar h1 {
            font-size: 24px;
        }
        
        .navbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .badge {
            background: rgba(255,255,255,0.2);
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .btn-logout {
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 8px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s;
        }
        
        .btn-logout:hover {
            background: rgba(255,255,255,0.3);
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
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
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
        
        .card-usuarios h3 {
            color: #667eea;
        }
        
        .card-admin h3 {
            color: #764ba2;
        }
        
        .card-visitantes h3 {
            color: #17a2b8;
        }
        
        .card-activos h3 {
            color: #28a745;
        }
        
        .card-pendientes {
            border-left: 4px solid #ffc107;
        }
        
        .card-pendientes h3 {
            color: #ffc107;
        }
        
        /* Estilos para tarjetas de proyectos */
        .card-proyectos h3 {
            color: #20c997;
        }
        
        .card-proyectos-activos h3 {
            color: #28a745;
        }
        
        .card-proyectos-inactivos h3 {
            color: #dc3545;
        }
        
        .card-proyectos-anio h3 {
            color: #fd7e14;
        }
        
        .menu-links {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 30px;
        }
        
        .menu-link {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-decoration: none;
            color: #333;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: transform 0.2s, box-shadow 0.2s;
            position: relative;
        }
        
        .menu-link:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .menu-link h4 {
            color: #667eea;
            margin-bottom: 10px;
            font-size: 18px;
        }
        
        .menu-link p {
            color: #666;
            font-size: 14px;
        }
        
        .menu-link-pendientes {
            border: 2px solid #ffc107;
        }
        
        .menu-link-pendientes h4 {
            color: #ffc107;
        }
        
        .menu-link-proyectos {
            border: 2px solid #28a745;
            background: linear-gradient(135deg, #f0fff4 0%, #c6f6d5 100%);
        }
        
        .menu-link-proyectos h4 {
            color: #28a745;
        }
        
        .notification-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 14px;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
        }
        
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
    </style>
</head>
<body>
    <nav class="navbar">
        <h1>🛡️ Panel de Administración</h1>
        <div class="navbar-right">
            <div class="user-info">
                <span><?= session()->get('usuario_nombre') ?></span>
                <span class="badge">ADMIN</span>
            </div>
            <a href="<?= site_url('auth/logout') ?>" class="btn-logout">Cerrar Sesión</a>
        </div>
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
         <!-- MENÚ DE ADMINISTRACIÓN -->
        <h2 class="section-title">⚙️ Menú de Administración</h2>
        <div class="menu-links">
            <?php if ($pendientes > 0): ?>
                <a href="<?= site_url('admin/usuariosPendientes') ?>" class="menu-link menu-link-pendientes">
                    <span class="notification-badge"><?= $pendientes ?></span>
                    <h4>⏳ Aprobar Usuarios</h4>
                    <p>Usuarios esperando aprobación</p>
                </a>
            <?php endif; ?>
              <?php if (isset($mensajes_sin_leer) && $mensajes_sin_leer > 0): ?>
    <a href="<?= site_url('admin/contactos') ?>" class="menu-link menu-link-pendientes">
        <span class="notification-badge"><?= $mensajes_sin_leer ?></span>
        <h4>✉️ Mensajes de Contacto</h4>
        <p>Mensajes sin leer del formulario</p>
    </a>
<?php else: ?>
    <a href="<?= site_url('admin/contactos') ?>" class="menu-link">
        <h4>✉️ Mensajes de Contacto</h4>
        <p>Ver mensajes del formulario de contacto</p>
    </a>
<?php endif; ?>
            <a href="<?= site_url('proyectos') ?>" class="menu-link menu-link-proyectos">
                <h4>🎨 Proyectos</h4>
                <p>Gestionar portfolio de proyectos</p>
            </a>
            <a href="<?= site_url('recursos/admin') ?>" class="menu-link">
                <h4>📁 Documentos</h4>
                <p>Gestionar Recursos: documentos, PDFs, currículum y material exclusivo</p>
            </a>
            <a href="<?= site_url('admin/usuarios') ?>" class="menu-link">
                <h4>👥 Gestión de Usuarios</h4>
                <p>Ver, crear, editar y eliminar usuarios</p>
            </a>
            <a href="<?= site_url('admin/crearUsuario') ?>" class="menu-link">
                <h4>➕ Crear Usuario</h4>
                <p>Agregar un nuevo usuario al sistema</p>
            </a>
            <a href="<?= site_url('visitante/perfil') ?>" class="menu-link">
                <h4>👤 Mi Perfil</h4>
                <p>Ver y editar mi información personal</p>
            </a>
           
        </div>

         <div class="separador"></div>

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
                <p>✓ Proyectos Activos</p>
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
</body>
</html>