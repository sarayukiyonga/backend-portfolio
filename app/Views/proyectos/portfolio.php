<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?></title>
    
    <link rel="stylesheet" href="<?= base_url('css/styles.css') ?>">
</head>
<body>
    <nav class="topbar">
        <h1>🎨 Portfolio de Proyectos</h1>
        <div class="navbar-right">
            <?php if ($esAdmin): ?>
                <a href="<?= site_url('proyectos') ?>" class="btn-admin">
                    🛠️ Panel Admin
                </a>
            <?php endif; ?>
            <a href="<?= site_url(session()->get('usuario_rol') == 'admin' ? 'admin/dashboard' : 'visitante/dashboard') ?>" class="btn-back">
                ← Dashboard
            </a>
        </div>
    </nav>
    
    <div class="container">
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-error">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>
        
        <div class="header-portfolio">
            <h2>Mis Proyectos</h2>
            <p>Explora algunos de mis trabajos realizados</p>
        </div>
        
        <?php if (!empty($proyectos)): ?>
            <div class="proyectos-grid">
                <?php foreach ($proyectos as $proyecto): ?>
                    <div class="proyecto-card" onclick="window.location.href='<?= site_url('proyectos/detalle/' . $proyecto['id']) ?>'">
                        <?php if ($proyecto['imagen_principal']): ?>
                            <img src="<?= base_url('uploads/proyectos/' . $proyecto['imagen_principal']) ?>" 
                                 alt="<?= esc($proyecto['nombre']) ?>" 
                                 class="proyecto-imagen">
                        <?php else: ?>
                            <div class="proyecto-imagen" style="display: flex; align-items: center; justify-content: center; background: #e0e0e0; color: #999;">
                                Sin imagen
                            </div>
                        <?php endif; ?>
                        
                        <div class="proyecto-contenido">
                            <h3 class="proyecto-nombre">
                                <?= esc($proyecto['nombre']) ?>
                            </h3>
                            
                            <p class="proyecto-descripcion">
                                <?= esc($proyecto['descripcion']) ?>
                            </p>
                            
                            <div class="proyecto-meta">
                                <?php if ($proyecto['cliente']): ?>
                                    <span>👤 <?= esc($proyecto['cliente']) ?></span>
                                <?php endif; ?>
                                <?php if ($proyecto['anio']): ?>
                                    <span>📅 <?= $proyecto['anio'] ?></span>
                                <?php endif; ?>
                            </div>
                            
                            <a href="<?= site_url('proyectos/detalle/' . $proyecto['id']) ?>" 
                               class="btn-ver"
                               onclick="event.stopPropagation()">
                                Ver Proyecto →
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-state-icon">🎨</div>
                <h2>No hay proyectos disponibles</h2>
                <p>Vuelve pronto para ver nuestros proyectos</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
