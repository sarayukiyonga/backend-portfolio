<!DOCTYPE html>
<html lang="es">
<head>
    <?php include(APPPATH . 'Views/components/head.php'); ?>
</head>
<body>
    <?php include(APPPATH . 'Views/components/sidebar.php'); ?>
   <div class="main-content">
       <?php include(APPPATH . 'Views/components/navbar.php'); ?>
       
        <div class="navbar-actions">
            <a href="<?= site_url('proyectos/crear') ?>" class="btn btn-primary">
                ➕ Nuevo Proyecto
            </a>
        </div>
    
    <div class="container">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>
        
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-error">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>
        
        <!-- Estadísticas -->
        <div class="estadisticas-grid">
            <div class="estadistica-card est-borrador">
                <h3><?= $estadisticas['estados']['borrador'] ?></h3>
                <p>📝 Borradores</p>
            </div>
            <div class="estadistica-card est-publicado">
                <h3><?= $estadisticas['estados']['publicado'] ?></h3>
                <p>✅ Publicados</p>
            </div>
            <div class="estadistica-card est-archivado">
                <h3><?= $estadisticas['estados']['archivado'] ?></h3>
                <p>📦 Archivados</p>
            </div>
            <div class="estadistica-card est-privado">
                <h3><?= $estadisticas['visibilidades']['privado'] ?></h3>
                <p>🔒 Privados</p>
            </div>
            <div class="estadistica-card est-autenticado">
                <h3><?= $estadisticas['visibilidades']['autenticado'] ?></h3>
                <p>👥 Autenticados</p>
            </div>
            <div class="estadistica-card est-publico">
                <h3><?= $estadisticas['visibilidades']['publico'] ?></h3>
                <p>🌐 Públicos</p>
            </div>
        </div>
        
        <!-- Filtros -->
        <div class="filtros">
            <h3>🔍 Filtrar Proyectos</h3>
            <div class="filtros-grid">
                <div>
                    <strong style="display: block; margin-bottom: 8px;">Por Estado:</strong>
                    <div class="filtro-grupo">
                        <a href="<?= site_url('proyectos') ?>" 
                           class="filtro-btn <?= $filtroActual == 'todos' ? 'activo' : '' ?>">
                            Todos
                        </a>
                        <a href="<?= site_url('proyectos?estado=borrador') ?>" 
                           class="filtro-btn <?= $filtroActual == 'borrador' ? 'activo' : '' ?>">
                            Borradores
                        </a>
                        <a href="<?= site_url('proyectos?estado=publicado') ?>" 
                           class="filtro-btn <?= $filtroActual == 'publicado' ? 'activo' : '' ?>">
                            Publicados
                        </a>
                        <a href="<?= site_url('proyectos?estado=archivado') ?>" 
                           class="filtro-btn <?= $filtroActual == 'archivado' ? 'activo' : '' ?>">
                            Archivados
                        </a>
                    </div>
                </div>
                <div>
                    <strong style="display: block; margin-bottom: 8px;">Por Visibilidad:</strong>
                    <div class="filtro-grupo">
                        <a href="<?= site_url('proyectos?visibilidad=privado') ?>" 
                           class="filtro-btn <?= $filtroActual == 'privado' ? 'activo' : '' ?>">
                            Privados
                        </a>
                        <a href="<?= site_url('proyectos?visibilidad=autenticado') ?>" 
                           class="filtro-btn <?= $filtroActual == 'autenticado' ? 'activo' : '' ?>">
                            Autenticados
                        </a>
                        <a href="<?= site_url('proyectos?visibilidad=publico') ?>" 
                           class="filtro-btn <?= $filtroActual == 'publico' ? 'activo' : '' ?>">
                            Públicos
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Grid de Proyectos -->
        <?php if (!empty($proyectos)): ?>
            <div class="proyectos-grid">
                <?php foreach ($proyectos as $proyecto): ?>
                    <div class="proyecto-card">
                        <?php if ($proyecto['imagen_principal']): ?>
                            <img src="<?= base_url('uploads/proyectos/' . $proyecto['imagen_principal']) ?>" 
                                 alt="<?= esc($proyecto['nombre']) ?>" 
                                 class="proyecto-imagen">
                        <?php else: ?>
                            <div class="proyecto-imagen"></div>
                        <?php endif; ?>
                        
                        <div class="proyecto-contenido">
                            <div class="proyecto-header">
                                <div style="flex: 1;">
                                    <h3 class="proyecto-nombre"><?= esc($proyecto['nombre']) ?></h3>
                                </div>
                                <div class="badges">
                                    <span class="badge badge-<?= $proyecto['estado'] ?>">
                                        <?= $proyecto['estado'] ?>
                                    </span>
                                    <span class="badge badge-<?= $proyecto['visibilidad'] ?>">
                                        <?= $proyecto['visibilidad'] ?>
                                    </span>
                                </div>
                            </div>
                            
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
                            
                            <div class="proyecto-acciones">
                                <a href="<?= site_url('proyectos/ver/' . $proyecto['id']) ?>" class="btn-ver">
                                    👁️ Ver
                                </a>
                                <a href="<?= site_url('proyectos/editar/' . $proyecto['id']) ?>" class="btn-editar">
                                    ✏️ Editar
                                </a>
                                <a href="<?= site_url('proyectos/eliminar/' . $proyecto['id']) ?>" 
                                   class="btn-eliminar"
                                   onclick="return confirm('¿Seguro que deseas eliminar este proyecto?')">
                                    🗑️ Eliminar
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-state-icon">📭</div>
                <h2>No hay proyectos con este filtro</h2>
                <p>Intenta con otro filtro o crea un nuevo proyecto</p>
                <br>
                <a href="<?= site_url('proyectos/crear') ?>" class="btn btn-primary">
                    ➕ Crear Primer Proyecto
                </a>
            </div>
        <?php endif; ?>
    </div>
    </div>
    <?php include(APPPATH . 'Views/components/sidebar_js.php'); ?>
</body>
</html>
