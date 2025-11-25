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
            background: #ffffff;
        }

        /* Header/Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.98);
            padding: 20px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .navbar-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-size: 28px;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .nav-links {
            display: flex;
            gap: 30px;
            align-items: center;
        }
        
        .nav-links a {
            text-decoration: none;
            color: #666;
            font-weight: 500;
            transition: color 0.3s;
        }
        
        .nav-links a:hover {
            color: #667eea;
        }
        
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 10px 25px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        /* Header público */
        .header-publico {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 20px;
            text-align: center;
        }
        
        .header-publico h1 {
            font-size: 48px;
            margin-bottom: 15px;
            font-weight: 700;
        }
        
        .header-publico p {
            font-size: 20px;
            opacity: 0.95;
        }
        
        .container {
            max-width: 1400px;
            margin: 60px auto;
            padding: 0 20px;
        }
        
        .proyectos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
            gap: 40px;
        }
        
        .proyecto-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
        }
        
        .proyecto-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        }
        
        .proyecto-imagen {
            width: 100%;
            height: 280px;
            object-fit: cover;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        
        .proyecto-contenido {
            padding: 30px;
        }
        
        .proyecto-nombre {
            font-size: 26px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #2d3748;
        }
        
        .proyecto-descripcion {
            color: #718096;
            font-size: 15px;
            line-height: 1.7;
            margin-bottom: 20px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .proyecto-meta {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
            font-size: 14px;
            color: #a0aec0;
        }
        
        .proyecto-meta span {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .btn-ver-proyecto {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 30px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            transition: opacity 0.3s, transform 0.3s;
        }
        
        .btn-ver-proyecto:hover {
            opacity: 0.9;
            transform: scale(1.05);
        }
        
        .empty-state {
            text-align: center;
            padding: 100px 20px;
        }
        
        .empty-state-icon {
            font-size: 100px;
            margin-bottom: 30px;
            opacity: 0.3;
        }
        
        .empty-state h2 {
            color: #4a5568;
            font-size: 28px;
            margin-bottom: 15px;
        }
        
        .empty-state p {
            color: #a0aec0;
            font-size: 16px;
        }
        
        /* Footer público */
        .footer-publico {
            background: #2d3748;
            color: white;
            text-align: center;
            padding: 40px 20px;
            margin-top: 80px;
        }
        
        .footer-publico p {
            opacity: 0.8;
        }
        
        @media (max-width: 768px) {
            .header-publico h1 {
                font-size: 36px;
            }
            
            .header-publico p {
                font-size: 18px;
            }
            
            .proyectos-grid {
                grid-template-columns: 1fr;
                gap: 30px;
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
                <a href="<?= site_url('welcome/contact') ?>">Contacto</a>
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
    <header class="header-publico">
        <h1>🎨 Nuestros Proyectos</h1>
        <p>Descubre nuestro trabajo y experiencia</p>
    </header>
    
    <div class="container">
        <?php if (!empty($proyectos)): ?>
            <div class="proyectos-grid">
                <?php foreach ($proyectos as $proyecto): ?>
                    <div class="proyecto-card" onclick="window.location.href='<?= site_url('proyectos/publico/' . $proyecto['id']) ?>'">
                        <?php if ($proyecto['imagen_principal']): ?>
                            <img src="<?= base_url('uploads/proyectos/' . $proyecto['imagen_principal']) ?>" 
                                 alt="<?= esc($proyecto['nombre']) ?>" 
                                 class="proyecto-imagen">
                        <?php else: ?>
                            <div class="proyecto-imagen"></div>
                        <?php endif; ?>
                        
                        <div class="proyecto-contenido">
                            <h2 class="proyecto-nombre">
                                <?= esc($proyecto['nombre']) ?>
                            </h2>
                            
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
                            
                            <a href="<?= site_url('proyectos/publico/' . $proyecto['id']) ?>" 
                               class="btn-ver-proyecto"
                               onclick="event.stopPropagation()">
                                Ver Proyecto Completo →
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-state-icon">🎨</div>
                <h2>Próximamente nuevos proyectos</h2>
                <p>Estamos trabajando en contenido increíble. Vuelve pronto.</p>
            </div>
        <?php endif; ?>
    </div>
    
    <footer class="footer-publico">
        <p>&copy; <?= date('Y') ?> - Todos los derechos reservados</p>
    </footer>
</body>
</html>
