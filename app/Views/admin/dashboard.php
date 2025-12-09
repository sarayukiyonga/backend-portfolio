<!DOCTYPE html>
<html lang="es">
<head>
    <?php include(APPPATH . 'Views/components/head.php'); ?>
</head>
<body>
    <?php include(APPPATH . 'Views/components/sidebar.php'); ?>
  
    <!-- ========================================
         CONTENIDO PRINCIPAL
    ======================================== -->
    <div class="main-content">
       <?php include(APPPATH . 'Views/components/navbar.php'); ?>
        
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
    <?php include(APPPATH . 'Views/components/sidebar_js.php'); ?>
</body>
</html>
