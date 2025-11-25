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
        
        .btn-back {
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 8px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s;
        }
        
        .btn-back:hover {
            background: rgba(255,255,255,0.3);
        }
        
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }
        
        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
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
        
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .table-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th {
            background: #f8f9fa;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #e0e0e0;
        }
        
        td {
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        tr:last-child td {
            border-bottom: none;
        }
        
        tr:hover {
            background: #f8f9fa;
        }
        
        .badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }
        
        .badge-admin {
            background: #667eea;
            color: white;
        }
        
        .badge-visitante {
            background: #6c757d;
            color: white;
        }
        
        .badge-activo {
            background: #28a745;
            color: white;
        }
        
        .badge-inactivo {
            background: #dc3545;
            color: white;
        }
        
        .action-buttons {
            display: flex;
            gap: 8px;
        }
        
        .btn-sm {
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
            border: none;
        }
        
        .btn-edit {
            background: #ffc107;
            color: #333;
        }
        
        .btn-toggle {
            background: #17a2b8;
            color: white;
        }
        
        .btn-delete {
            background: #dc3545;
            color: white;
        }
        
        .btn-sm:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <h1>👥 Gestión de Usuarios</h1>
        <div class="navbar-right">
            <a href="<?= base_url('admin/dashboard') ?>" class="btn-back">← Volver al Dashboard</a>
        </div>
    </nav>
    
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
</body>
</html>
