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
        
        <div class="header-actions">
            <h2>Lista de Usuarios</h2>
            <a href="<?= base_url('admin/crearUsuario') ?>" class="btn-primary">➕ Crear Nuevo Usuario</a>
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
                    <?php if (empty($usuarios)): ?>
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 30px; color: #999;">
                                No hay usuarios registrados
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td><?= $usuario['id'] ?></td>
                                <td><?= esc($usuario['nombre']) ?></td>
                                <td><?= esc($usuario['email']) ?></td>
                                <td>
                                    <span class="badge badge-<?= $usuario['rol_nombre'] ?>">
                                        <?= strtoupper($usuario['rol_nombre']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-<?= $usuario['activo'] ? 'activo' : 'inactivo' ?>">
                                        <?= $usuario['activo'] ? 'Activo' : 'Inactivo' ?>
                                    </span>
                                </td>
                                <td><?= date('d/m/Y', strtotime($usuario['created_at'])) ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="<?= base_url('admin/editarUsuario/' . $usuario['id']) ?>" 
                                           class="btn-sm btn-edit">
                                            ✏️ Editar
                                        </a>
                                        <a href="<?= base_url('admin/cambiarEstado/' . $usuario['id']) ?>" 
                                           class="btn-sm btn-toggle"
                                           onclick="return confirm('¿Estás seguro de cambiar el estado?')">
                                            🔄 <?= $usuario['activo'] ? 'Desactivar' : 'Activar' ?>
                                        </a>
                                        <?php if ($usuario['id'] != session()->get('usuario_id')): ?>
                                            <a href="<?= base_url('admin/eliminarUsuario/' . $usuario['id']) ?>" 
                                               class="btn-sm btn-delete"
                                               onclick="return confirm('¿Estás seguro de eliminar este usuario? Esta acción no se puede deshacer.')">
                                                🗑️ Eliminar
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    </div>
    <?php include(APPPATH . 'Views/components/sidebar_js.php'); ?>
</body>
</html>