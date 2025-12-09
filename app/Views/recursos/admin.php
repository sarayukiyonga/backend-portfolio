<!DOCTYPE html>
<html lang="es">
<head>
    <?php include(APPPATH . 'Views/components/head.php'); ?>
</head>
<body>
    <?php include(APPPATH . 'Views/components/sidebar.php'); ?>
   <div class="main-content">
       <?php include(APPPATH . 'Views/components/navbar.php'); ?>
   
    <div class="container">
                <div class="navbar-actions">
            <a href="<?= site_url('recursos/crear') ?>" class="btn btn-primary">
                ➕ Subir Recurso
            </a>
        </div>
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
            <div class="estadistica-card stat-total">
                <h3><?= $estadisticas['total'] ?></h3>
                <p>📄 Total Recursos</p>
            </div>
            <div class="estadistica-card stat-activos">
                <h3><?= $estadisticas['activos'] ?></h3>
                <p>✅ Activos</p>
            </div>
            <div class="estadistica-card stat-inactivos">
                <h3><?= $estadisticas['inactivos'] ?></h3>
                <p>❌ Inactivos</p>
            </div>
            <div class="estadistica-card stat-descargas">
                <h3><?= $estadisticas['descargas_totales'] ?></h3>
                <p>📥 Descargas Totales</p>
            </div>
        </div>
        
        <!-- Tabla de Recursos -->
        <div class="recursos-table-container">
            <div class="table-header">
                <h2>Todos los Recursos</h2>
            </div>
            
            <?php if (!empty($recursos)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Recurso</th>
                            <th>Tipo</th>
                            <th>Visibilidad</th>
                            <th>Tamaño</th>
                            <th>Descargas</th>
                            <th>Estado</th>
                            <th>Orden</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recursos as $recurso): ?>
                            <tr>
                                <td>
                                    <div class="recurso-info">
                                        <div class="recurso-icono"><?= $recurso['icono'] ?></div>
                                        <div>
                                            <div class="recurso-titulo-small">
                                                <?= esc($recurso['titulo']) ?>
                                            </div>
                                            <?php if ($recurso['descripcion']): ?>
                                                <div class="recurso-desc-small">
                                                    <?= esc($recurso['descripcion']) ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-tipo">
                                        <?= strtoupper($recurso['tipo']) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php
                                    $visClass = 'vis-' . str_replace('solo_', '', $recurso['visible_para']);
                                    $visText = [
                                        'todos' => '🌐 Todos',
                                        'solo_visitantes' => '👥 Visitantes',
                                        'solo_admin' => '🔒 Admin'
                                    ];
                                    ?>
                                    <span class="badge-visibilidad <?= $visClass ?>">
                                        <?= $visText[$recurso['visible_para']] ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($recurso['tamanio']): ?>
                                        <?= number_format($recurso['tamanio'] / 1024, 0) ?> KB
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong><?= $recurso['descargas'] ?></strong>
                                </td>
                                <td>
                                    <span class="badge <?= $recurso['activo'] ? 'badge-activo' : 'badge-inactivo' ?>">
                                        <?= $recurso['activo'] ? 'Activo' : 'Inactivo' ?>
                                    </span>
                                </td>
                                <td>
                                    <?= $recurso['orden'] ?>
                                </td>
                                <td>
                                    <div class="acciones">
                                        <a href="<?= site_url('recursos/editar/' . $recurso['id']) ?>" 
                                           class="btn-sm btn-editar"
                                           title="Editar">
                                            ✏️
                                        </a>
                                        <a href="<?= site_url('recursos/eliminar/' . $recurso['id']) ?>" 
                                           class="btn-sm btn-eliminar"
                                           onclick="return confirm('¿Seguro que deseas eliminar este recurso?')"
                                           title="Eliminar">
                                            🗑️
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-state-icon">📭</div>
                    <h2>No hay recursos</h2>
                    <p>Comienza subiendo tu primer recurso</p>
                    <br>
                    <a href="<?= site_url('recursos/crear') ?>" class="btn btn-primary">
                        ➕ Subir Primer Recurso
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php include(APPPATH . 'Views/components/sidebar_js.php'); ?>
</body>
</html>
