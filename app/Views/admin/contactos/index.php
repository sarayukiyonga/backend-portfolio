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
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: #f5f7fa;
            color: #333;
        }

        .navbar {
            background: white;
            padding: 15px 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h1 {
            font-size: 20px;
            color: #333;
        }

        .nav-links {
            display: flex;
            gap: 15px;
        }

        .nav-links a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 6px;
            transition: background 0.3s;
        }

        .nav-links a:hover {
            background: #f0f2ff;
        }

        .container {
            max-width: 1400px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .stat-card h3 {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-card .number {
            font-size: 36px;
            font-weight: bold;
            color: #667eea;
        }

        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        .card-header {
            padding: 20px 25px;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header h2 {
            font-size: 18px;
            color: #333;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #f8f9fa;
        }

        th {
            padding: 15px 20px;
            text-align: left;
            font-weight: 600;
            color: #666;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 15px 20px;
            border-bottom: 1px solid #f0f0f0;
        }

        tr:hover {
            background: #f8f9fa;
        }

        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-nuevo {
            background: #fff3cd;
            color: #856404;
        }

        .badge-leido {
            background: #d1ecf1;
            color: #0c5460;
        }

        .badge-respondido {
            background: #d4edda;
            color: #155724;
        }

        .actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-primary {
            background: #667eea;
            color: white;
        }

        .btn-primary:hover {
            background: #5568d3;
        }

        .btn-danger {
            background: #e74c3c;
            color: white;
        }

        .btn-danger:hover {
            background: #c0392b;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }

        .empty-state svg {
            width: 64px;
            height: 64px;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .truncate {
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                gap: 15px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .table-container {
                font-size: 14px;
            }

            th, td {
                padding: 10px;
            }

            .truncate {
                max-width: 150px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <h1>📧 <?= $titulo ?></h1>
        <div class="nav-links">
            <a href="<?= site_url('admin/dashboard') ?>">Dashboard</a>
            <a href="<?= site_url('proyectos') ?>">Proyectos</a>
            <a href="<?= site_url('recursos/admin') ?>">Recursos</a>
        </div>
    </nav>

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
</body>
</html>
