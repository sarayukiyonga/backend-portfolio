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
            gap: 15px;
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
        
        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
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
        
        .badge-visitante {
            background: #6c757d;
            color: white;
        }
        
        .badge-pendiente {
            background: #ffc107;
            color: #333;
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
            display: inline-block;
        }
        
        .btn-approve {
            background: #28a745;
            color: white;
        }
        
        .btn-reject {
            background: #dc3545;
            color: white;
        }
        
        .btn-sm:hover {
            opacity: 0.8;
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }
        
        .empty-state-icon {
            font-size: 64px;
            margin-bottom: 20px;
        }
        
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <h1>⏳ Usuarios Pendientes de Aprobación</h1>
        <div class="navbar-right">
            <a href="<?= site_url('admin/usuarios') ?>" class="btn-back">← Ver Todos los Usuarios</a>
            <a href="<?= site_url('admin/dashboard') ?>" class="btn-back">← Dashboard</a>
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
</body>
</html>
