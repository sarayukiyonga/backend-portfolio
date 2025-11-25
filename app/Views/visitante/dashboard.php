<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Visitante</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        
        .navbar {
            background: rgba(255, 255, 255, 0.98);
            padding: 15px 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .navbar h1 {
            font-size: 24px;
            color: #667eea;
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
        
        .btn-home {
            background: #28a745;
            color: white;
        }
        
        .btn-home:hover {
            background: #218838;
        }
        
        .btn-logout {
            background: #dc3545;
            color: white;
        }
        
        .btn-logout:hover {
            background: #c82333;
        }
        
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        
        .welcome-card {
            background: white;
            border-radius: 15px;
            padding: 40px;
            margin-bottom: 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .welcome-card h2 {
            font-size: 32px;
            color: #333;
            margin-bottom: 15px;
        }
        
        .welcome-card p {
            font-size: 18px;
            color: #666;
        }
        
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
        }
        
        .menu-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            text-decoration: none;
            color: inherit;
            display: block;
        }
        
        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.15);
        }
        
        .menu-icon {
            font-size: 60px;
            margin-bottom: 20px;
            display: block;
        }
        
        .menu-card h3 {
            font-size: 24px;
            color: #333;
            margin-bottom: 10px;
        }
        
        .menu-card p {
            color: #666;
            font-size: 15px;
            line-height: 1.6;
        }
        
        .menu-card.destacado {
            border: 5px solid #5100d3ff;
            background: linear-gradient(135deg, #f8f9ff 0%, #fff 100%);
        }
        
        .menu-card.nuevo::after {
            content: '✨ Nuevo';
            position: absolute;
            top: 15px;
            right: 15px;
            background: #28a745;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .menu-card {
            position: relative;
        }
        
        @media (max-width: 768px) {
            .menu-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <h1>👤 Dashboard Visitante</h1>
        <div class="navbar-actions">
            <a href="<?= site_url('/') ?>" class="btn btn-home">
                🌐 Sitio publico
            </a>
            <a href="<?= site_url('auth/logout') ?>" class="btn btn-logout">
                ❌ Cerrar Sesión
            </a>
        </div>
    </nav>
    
    <div class="container">
        <div class="welcome-card">
            <h2>¡Bienvenido, <?= esc(session()->get('usuario_nombre')) ?>!</h2>
            <p>Panel de visitante - Accede a contenido exclusivo</p>
        </div>
        
        <div class="menu-grid">
            <!-- Ver perfil -->
            <a href="<?= base_url('visitante/perfil') ?>" class="menu-card destacado">
            <span class="menu-icon">👤</span>    
            <h3>Mi Cuenta</h3>
                <p>Ver y editar mi información</p>
            </a>
            <!-- Ver Proyectos -->
            <a href="<?= site_url('proyectos/portfolio') ?>" class="menu-card destacado">
                <span class="menu-icon">🎨</span>
                <h3>Ver Proyectos</h3>
                <p>Explora algunos de mis proyectos y trabajos realizados incluidos los que no se pueden publicar.</p>
            </a>
            
            <!-- Recursos y Documentos -->
            <a href="<?= site_url('recursos') ?>" class="menu-card nuevo">
                <span class="menu-icon">📄</span>
                <h3>Documentos</h3>
                <p>Descarga documentos, PDFs, currículum y material exclusivo</p>
            </a>
            
            <!-- Volver a Homepage -->
            <a href="<?= site_url('/') ?>" class="menu-card">
                <span class="menu-icon">🌐</span>
                <h3>Sitio Público</h3>
                <p>Vuelve a la página principal del sitio web</p>
            </a>
            
            
        </div>
       
    </div>
</body>
</html>
