<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio - Inicio</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #ffffff;
            color: #333;
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
        
        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 120px 30px;
            text-align: center;
        }
        
        .hero h1 {
            font-size: 56px;
            margin-bottom: 20px;
            font-weight: 700;
        }
        
        .hero p {
            font-size: 22px;
            margin-bottom: 40px;
            opacity: 0.95;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .hero-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .btn-hero {
            padding: 15px 40px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            font-size: 18px;
            transition: all 0.3s;
            display: inline-block;
        }
        
        .btn-primary {
            background: white;
            color: #667eea;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        
        .btn-secondary {
            background: rgba(255,255,255,0.2);
            color: white;
            border: 2px solid white;
        }
        
        .btn-secondary:hover {
            background: rgba(255,255,255,0.3);
        }
        
        /* Sección Proyectos Destacados */
        .proyectos-section {
            max-width: 1400px;
            margin: 80px auto;
            padding: 0 30px;
        }
        
        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }
        
        .section-header h2 {
            font-size: 42px;
            margin-bottom: 15px;
            color: #333;
        }
        
        .section-header p {
            font-size: 18px;
            color: #666;
        }
        
        .proyectos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 40px;
            margin-bottom: 50px;
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
            padding: 25px;
        }
        
        .proyecto-nombre {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #333;
        }
        
        .proyecto-descripcion {
            color: #666;
            font-size: 15px;
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
            font-size: 13px;
            color: #999;
            margin-bottom: 15px;
        }
        
        .ver-mas-section {
            text-align: center;
        }
        
        .btn-ver-todos {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 50px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            font-size: 18px;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .btn-ver-todos:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }
        
        /* Sección CTA */
        .cta-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 80px 30px;
            text-align: center;
            margin-top: 100px;
        }
        
        .cta-section h2 {
            font-size: 42px;
            margin-bottom: 20px;
        }
        
        .cta-section p {
            font-size: 20px;
            margin-bottom: 40px;
            opacity: 0.95;
        }
        
        /* Footer */
        .footer {
            background: #2d3748;
            color: white;
            padding: 40px 30px;
            text-align: center;
        }
        
        .footer p {
            opacity: 0.8;
        }
        
        .empty-state {
            text-align: center;
            padding: 80px 20px;
            color: #999;
        }
        
        .empty-state-icon {
            font-size: 80px;
            margin-bottom: 20px;
        }
        
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 36px;
            }
            
            .hero p {
                font-size: 18px;
            }
            
            .proyectos-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }
            
            .nav-links {
                display: none;
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
    
    <!-- Hero Section -->
    <section class="hero">
        <h1>Bienvenido a Mi Portfolio</h1>
        <p>Descubre proyectos creativos, innovadores y profesionales que demuestran nuestra experiencia y pasión por el diseño</p>
        <div class="hero-buttons">
            <a href="<?= site_url('proyectos/publico') ?>" class="btn-hero btn-primary">
                Ver Proyectos
            </a>
            <a href="<?= site_url('contacto') ?>" class="btn-hero btn-secondary">
                Contactar
            </a>
        </div>
    </section>
    
    <!-- Proyectos Destacados -->
    <section class="proyectos-section">
        <div class="section-header">
            <h2>Proyectos Destacados</h2>
            <p>Una selección de nuestros trabajos más recientes</p>
        </div>
        
        <?php if (!empty($proyectosDestacados)): ?>
            <div class="proyectos-grid">
                <?php foreach ($proyectosDestacados as $proyecto): ?>
                    <div class="proyecto-card" onclick="window.location.href='<?= site_url('proyectos/publico/' . $proyecto['id']) ?>'">
                        <?php if ($proyecto['imagen_principal']): ?>
                            <img src="<?= base_url('uploads/proyectos/' . $proyecto['imagen_principal']) ?>" 
                                 alt="<?= esc($proyecto['nombre']) ?>" 
                                 class="proyecto-imagen">
                        <?php else: ?>
                            <div class="proyecto-imagen"></div>
                        <?php endif; ?>
                        
                        <div class="proyecto-contenido">
                            <h3 class="proyecto-nombre">
                                <?= esc($proyecto['nombre']) ?>
                            </h3>
                            
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
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="ver-mas-section">
                <a href="<?= site_url('proyectos/publico') ?>" class="btn-ver-todos">
                    Ver Todos los Proyectos →
                </a>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-state-icon">🎨</div>
                <h3>Próximamente</h3>
                <p>Estamos trabajando en contenido increíble. Vuelve pronto.</p>
            </div>
        <?php endif; ?>
    </section>
    
    <!-- CTA Section -->
    <section class="cta-section">
        <h2>¿Tienes un proyecto en mente?</h2>
        <p>Trabajemos juntos para hacerlo realidad</p>
        <a href="<?= site_url('contacto') ?>" class="btn-hero btn-primary">
            Contactar Ahora
        </a>
    </section>
    
    <!-- Footer -->
    <footer class="footer">
        <p>&copy; <?= date('Y') ?> Mi Portfolio. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
