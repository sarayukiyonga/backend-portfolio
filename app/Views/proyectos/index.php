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
        
        /* Estadísticas */
        .estadisticas-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }
        
        .estadistica-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .estadistica-card h3 {
            font-size: 32px;
            margin-bottom: 8px;
        }
        
        .estadistica-card p {
            color: #666;
            font-size: 13px;
        }
        
        .est-borrador h3 { color: #ffc107; }
        .est-publicado h3 { color: #28a745; }
        .est-archivado h3 { color: #6c757d; }
        .est-privado h3 { color: #dc3545; }
        .est-autenticado h3 { color: #17a2b8; }
        .est-publico h3 { color: #20c997; }
        
        /* Filtros */
        .filtros {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .filtros h3 {
            margin-bottom: 15px;
            color: #333;
        }
        
        .filtros-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        
        .filtro-grupo {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        
        .filtro-btn {
            padding: 8px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            background: white;
            color: #666;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .filtro-btn:hover {
            border-color: #667eea;
            color: #667eea;
        }
        
        .filtro-btn.activo {
            background: #667eea;
            border-color: #667eea;
            color: white;
        }
        
        /* Grid de proyectos */
        .proyectos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
        }
        
        .proyecto-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .proyecto-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }
        
        .proyecto-imagen {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background: #e0e0e0;
        }
        
        .proyecto-contenido {
            padding: 20px;
        }
        
        .proyecto-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 10px;
        }
        
        .proyecto-nombre {
            font-size: 20px;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }
        
        /* Badges */
        .badges {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        
        .badge {
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            text-align: center;
            white-space: nowrap;
        }
        
        .badge-borrador {
            background: #fff3cd;
            color: #856404;
        }
        
        .badge-publicado {
            background: #d4edda;
            color: #155724;
        }
        
        .badge-archivado {
            background: #e2e3e5;
            color: #383d41;
        }
        
        .badge-privado {
            background: #f8d7da;
            color: #721c24;
        }
        
        .badge-autenticado {
            background: #d1ecf1;
            color: #0c5460;
        }
        
        .badge-publico {
            background: #d4edda;
            color: #155724;
        }
        
        .proyecto-descripcion {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 15px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .proyecto-meta {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
            font-size: 13px;
            color: #999;
        }
        
        .proyecto-acciones {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        
        .btn-ver {
            background: #667eea;
            color: white;
            padding: 8px 16px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            transition: background 0.3s;
        }
        
        .btn-ver:hover {
            background: #5568d3;
        }
        
        .btn-editar {
            background: #ffc107;
            color: #333;
            padding: 8px 16px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            transition: background 0.3s;
        }
        
        .btn-editar:hover {
            background: #e0a800;
        }
        
        .btn-eliminar {
            background: #dc3545;
            color: white;
            padding: 8px 16px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            transition: background 0.3s;
        }
        
        .btn-eliminar:hover {
            background: #c82333;
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 10px;
        }
        
        .empty-state-icon {
            font-size: 60px;
            margin-bottom: 15px;
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
        
        @media (max-width: 768px) {
            .filtros-grid {
                grid-template-columns: 1fr;
            }
            
            .estadisticas-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-content">
            <div class="logo">Saray Martínez</div>
            <div class="nav-links">
                <a href="<?= site_url('/') ?>">Inicio</a>
                <a href="<?= site_url('proyectos/publico') ?>">Proyectos</a>
                <a href="<?= site_url('welcome/about') ?>">Acerca de</a>
                <a href="<?= site_url('contacto') ?>">Contacto</a>
                <?php if (session()->has('usuario_id')): ?>
                    <a href="<?= site_url(session()->get('usuario_rol') == 'admin' ? 'admin/dashboard' : 'visitante/dashboard') ?>" class="btn-login">
                        Dashboard
                    </a>
                <?php else: ?>
                    <a href="<?= site_url('auth/login') ?>" class="btn-login">
                        Iniciar Sesión
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <nav class="navbar">
        <h1>🎨 Gestión de Proyectos</h1>
        <div class="navbar-actions">
            <a href="<?= site_url('proyectos/crear') ?>" class="btn btn-primary">
                ➕ Nuevo Proyecto
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
</body>
</html>
