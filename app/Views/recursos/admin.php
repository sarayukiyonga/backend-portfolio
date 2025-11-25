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
        
        .navbar-actions {
            display: flex;
            gap: 10px;
        }
        
        .btn {
            padding: 8px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: all 0.3s;
            font-weight: 500;
        }
        
        .btn-primary {
            background: #28a745;
            color: white;
        }
        
        .btn-primary:hover {
            background: #218838;
        }
        
        .btn-back {
            background: rgba(255,255,255,0.2);
            color: white;
        }
        
        .btn-back:hover {
            background: rgba(255,255,255,0.3);
        }
        
        .container {
            max-width: 1400px;
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
        
        /* Estadísticas */
        .estadisticas-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .estadistica-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .estadistica-card h3 {
            font-size: 36px;
            margin-bottom: 10px;
        }
        
        .estadistica-card p {
            color: #666;
            font-size: 14px;
        }
        
        .stat-total h3 { color: #667eea; }
        .stat-activos h3 { color: #28a745; }
        .stat-inactivos h3 { color: #dc3545; }
        .stat-descargas h3 { color: #ffc107; }
        
        /* Tabla */
        .recursos-table-container {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .table-header h2 {
            font-size: 24px;
            color: #333;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        thead {
            background: #f8f9fa;
        }
        
        th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #495057;
            border-bottom: 2px solid #dee2e6;
        }
        
        td {
            padding: 15px;
            border-bottom: 1px solid #dee2e6;
        }
        
        tbody tr:hover {
            background: #f8f9fa;
        }
        
        .recurso-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .recurso-icono {
            font-size: 40px;
        }
        
        .recurso-titulo-small {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }
        
        .recurso-desc-small {
            font-size: 13px;
            color: #666;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .badge {
            padding: 5px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .badge-activo {
            background: #d4edda;
            color: #155724;
        }
        
        .badge-inactivo {
            background: #f8d7da;
            color: #721c24;
        }
        
        .badge-tipo {
            background: #e7f3ff;
            color: #004085;
        }
        
        .badge-visibilidad {
            padding: 4px 8px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 600;
        }
        
        .vis-todos {
            background: #d4edda;
            color: #155724;
        }
        
        .vis-visitantes {
            background: #fff3cd;
            color: #856404;
        }
        
        .vis-admin {
            background: #f8d7da;
            color: #721c24;
        }
        
        .acciones {
            display: flex;
            gap: 8px;
        }
        
        .btn-sm {
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.3s;
            display: inline-block;
        }
        
        .btn-editar {
            background: #ffc107;
            color: #333;
        }
        
        .btn-editar:hover {
            background: #e0a800;
        }
        
        .btn-eliminar {
            background: #dc3545;
            color: white;
        }
        
        .btn-eliminar:hover {
            background: #c82333;
        }
        
        .btn-toggle {
            background: #6c757d;
            color: white;
            border: none;
            cursor: pointer;
        }
        
        .btn-toggle:hover {
            background: #5a6268;
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }
        
        .empty-state-icon {
            font-size: 60px;
            margin-bottom: 15px;
        }
        
        @media (max-width: 768px) {
            .estadisticas-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            table {
                font-size: 13px;
            }
            
            .acciones {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <h1>🛠️ Gestión de Recursos</h1>
        <div class="navbar-actions">
            <a href="<?= site_url('recursos/crear') ?>" class="btn btn-primary">
                ➕ Subir Recurso
            </a>
            <a href="<?= site_url('admin/dashboard') ?>" class="btn btn-back">
                ← Dashboard
            </a>
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
</body>
</html>
