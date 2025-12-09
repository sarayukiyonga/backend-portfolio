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
        
        <h2>Solicitudes de Registro</h2>
        
        <?php if (!empty($usuarios)): ?>
            <div class="alert alert-info">
                📋 Hay <strong><?= count($usuarios) ?></strong> usuario(s) esperando aprobación
            </div>
            
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Fecha Registro</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td><?= $usuario['id'] ?></td>
                                <td><?= esc($usuario['nombre']) ?></td>
                                <td><?= esc($usuario['email']) ?></td>
                                <td>
                                    <span class="badge badge-visitante">
                                        <?= strtoupper($usuario['rol_nombre']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-pendiente">
                                        ⏳ PENDIENTE
                                    </span>
                                </td>
                                <td><?= date('d/m/Y H:i', strtotime($usuario['created_at'])) ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="<?= site_url('admin/aprobarUsuario/' . $usuario['id']) ?>" 
                                           class="btn-sm btn-approve"
                                           onclick="return confirm('¿Aprobar a este usuario? Podrá iniciar sesión.')">
                                            ✅ Aprobar
                                        </a>
                                        <a href="<?= site_url('admin/rechazarUsuario/' . $usuario['id']) ?>" 
                                           class="btn-sm btn-reject"
                                           onclick="return confirm('¿Rechazar a este usuario? Se eliminará del sistema.')">
                                            ❌ Rechazar
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="table-container">
                <div class="empty-state">
                    <div class="empty-state-icon">✅</div>
                    <h3>No hay usuarios pendientes</h3>
                    <p>Todos los usuarios han sido procesados</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
    </div>
    <?php include(APPPATH . 'Views/components/sidebar_js.php'); ?>
</body>
</html>