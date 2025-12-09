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
        <!-- Estadísticas -->
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Mensajes</h3>
                <div class="number"><?= $estadisticas['total'] ?></div>
            </div>
            <div class="stat-card">
                <h3>No Leídos</h3>
                <div class="number" style="color: #f39c12;"><?= $estadisticas['no_leidos'] ?></div>
            </div>
            <div class="stat-card">
                <h3>Respondidos</h3>
                <div class="number" style="color: #27ae60;"><?= $estadisticas['respondidos'] ?></div>
            </div>
            <div class="stat-card">
                <h3>Hoy</h3>
                <div class="number" style="color: #3498db;"><?= $estadisticas['hoy'] ?></div>
            </div>
        </div>

        <!-- Alertas -->
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

        <!-- Tabla de contactos -->
        <div class="card">
            <div class="card-header">
                <h2>Mensajes Recibidos</h2>
            </div>

            <?php if (empty($contactos)): ?>
                <div class="empty-state">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <h3>No hay mensajes todavía</h3>
                    <p>Los mensajes de contacto aparecerán aquí</p>
                </div>
            <?php else: ?>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Estado</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Teléfono</th>
                                <th>Mensaje</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($contactos as $contacto): ?>
                                <tr>
                                    <td><strong>#<?= $contacto['id'] ?></strong></td>
                                    <td>
                                        <?php if ($contacto['respondido']): ?>
                                            <span class="badge badge-respondido">Respondido</span>
                                        <?php elseif ($contacto['leido']): ?>
                                            <span class="badge badge-leido">Leído</span>
                                        <?php else: ?>
                                            <span class="badge badge-nuevo">Nuevo</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc($contacto['nombre']) ?></td>
                                    <td><?= esc($contacto['email']) ?></td>
                                    <td><?= esc($contacto['telefono'] ?: '-') ?></td>
                                    <td>
                                        <div class="truncate" title="<?= esc($contacto['mensaje']) ?>">
                                            <?= esc($contacto['mensaje']) ?>
                                        </div>
                                    </td>
                                    <td><?= date('d/m/Y H:i', strtotime($contacto['created_at'])) ?></td>
                                    <td>
                                        <div class="actions">
                                            <a href="<?= site_url('admin/contactos/ver/' . $contacto['id']) ?>" 
                                               class="btn btn-primary">
                                                Ver
                                            </a>
                                            <a href="<?= site_url('admin/contactos/eliminar/' . $contacto['id']) ?>" 
                                               class="btn btn-danger"
                                               onclick="return confirm('¿Eliminar este mensaje?')">
                                                Eliminar
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
    </div>
    <?php include(APPPATH . 'Views/components/sidebar_js.php'); ?>
</body>
</html>
