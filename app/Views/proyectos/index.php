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
            <div style="margin-bottom: 20px; padding: 15px; background: #e7f3ff; border-radius: 8px; border-left: 4px solid #2196F3;">
                <strong>📋 Ordenar Proyectos:</strong> Arrastra y suelta las tarjetas para cambiar el orden. Los cambios se guardan automáticamente.
            </div>
            <div class="proyectos-grid" id="proyectos-container">
                <?php foreach ($proyectos as $proyecto): ?>
                    <div class="proyecto-card sortable-item" data-proyecto-id="<?= $proyecto['id'] ?>" style="cursor: grab; position: relative;">
                        <div class="drag-handle" style="position: absolute; top: 10px; right: 10px; background: rgba(33, 150, 243, 0.8); color: white; padding: 5px 10px; border-radius: 4px; font-size: 12px; z-index: 10; cursor: grab; user-select: none;">
                            ⋮⋮ Arrastrar
                        </div>
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
    
    <!-- SortableJS para drag and drop -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('proyectos-container');
            if (!container) return;
            
            let sortable = Sortable.create(container, {
                animation: 150,
                handle: '.drag-handle',
                ghostClass: 'sortable-ghost',
                chosenClass: 'sortable-chosen',
                dragClass: 'sortable-drag',
                onEnd: function(evt) {
                    // Obtener el nuevo orden
                    const items = container.querySelectorAll('.proyecto-card');
                    const ordenes = {};
                    
                    items.forEach((item, index) => {
                        const proyectoId = item.getAttribute('data-proyecto-id');
                        ordenes[proyectoId] = index + 1;
                    });
                    
                    // Preparar datos como URLSearchParams (más compatible con CodeIgniter)
                    const params = new URLSearchParams();
                    params.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');
                    
                    // Agregar cada orden
                    Object.keys(ordenes).forEach(function(proyectoId) {
                        params.append('ordenes[' + proyectoId + ']', ordenes[proyectoId]);
                    });
                    
                    // Enviar al servidor
                    fetch('<?= site_url('proyectos/actualizarOrden') ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: params.toString()
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Mostrar mensaje de éxito temporal
                            const mensaje = document.createElement('div');
                            mensaje.className = 'alert alert-success';
                            mensaje.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999; padding: 15px 20px; background: #4CAF50; color: white; border-radius: 5px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);';
                            mensaje.textContent = '✅ Orden actualizado correctamente';
                            document.body.appendChild(mensaje);
                            
                            setTimeout(() => {
                                mensaje.style.opacity = '0';
                                mensaje.style.transition = 'opacity 0.5s';
                                setTimeout(() => mensaje.remove(), 500);
                            }, 2000);
                        } else {
                            alert('Error al actualizar el orden: ' + (data.message || 'Error desconocido'));
                            // Recargar la página para restaurar el orden anterior
                            location.reload();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error de conexión al actualizar el orden');
                        location.reload();
                    });
                }
            });
        });
    </script>
    
    <style>
        .sortable-ghost {
            opacity: 0.4;
            background: #f0f0f0;
        }
        .sortable-chosen {
            cursor: grabbing !important;
        }
        .sortable-drag {
            opacity: 0.8;
            transform: rotate(2deg);
        }
        .proyecto-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transform: translateY(-2px);
            transition: all 0.3s ease;
        }
        .proyecto-card:active {
            cursor: grabbing;
        }
        .drag-handle:hover {
            background: rgba(33, 150, 243, 1) !important;
        }
    </style>
</body>
</html>
