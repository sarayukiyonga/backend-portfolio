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
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
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
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .badge {
            background: rgba(255,255,255,0.2);
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .btn-logout {
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 8px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s;
        }
        
        .btn-logout:hover {
            background: rgba(255,255,255,0.3);
        }
        
        .container {
            max-width: 1000px;
            margin: 30px auto;
            padding: 0 20px;
        }
        
        .welcome-card {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            text-align: center;
            margin-bottom: 30px;
        }
        
        .welcome-card h2 {
            color: #333;
            font-size: 32px;
            margin-bottom: 15px;
        }
        
        .welcome-card p {
            color: #666;
            font-size: 18px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .info-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .info-card h3 {
            color: #28a745;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .info-card p {
            color: #666;
            line-height: 1.6;
        }
        
        .menu-links {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }
        
        .menu-link {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-decoration: none;
            color: #333;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .menu-link:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .menu-link h4 {
            color: #28a745;
            margin-bottom: 10px;
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
    </style>
</head>
<body>
    <nav class="navbar">
        <h1>🌟 Panel de Visitante</h1>
        <div class="navbar-right">
            <div class="user-info">
                <span><?= session()->get('usuario_nombre') ?></span>
                <span class="badge">VISITANTE</span>
            </div>
            <a href="<?= base_url('auth/logout') ?>" class="btn-logout">Cerrar Sesión</a>
        </div>
    </nav>
    
    <div class="container">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>
        
        <div class="welcome-card">
            <h2>¡Bienvenido, <?= esc($usuario['nombre']) ?>!</h2>
            <p>Este es tu panel de visitante. Aquí podrás gestionar tu perfil y ver la información disponible.</p>
        </div>
        
        <div class="info-grid">
            <div class="info-card">
                <h3>👤 Tu Información</h3>
                <p><strong>Nombre:</strong> <?= esc($usuario['nombre']) ?></p>
                <p><strong>Email:</strong> <?= esc($usuario['email']) ?></p>
                <p><strong>Rol:</strong> <?= ucfirst($usuario['rol_nombre']) ?></p>
            </div>
            
            <div class="info-card">
                <h3>📅 Cuenta</h3>
                <p><strong>Registrado:</strong> <?= date('d/m/Y', strtotime($usuario['created_at'])) ?></p>
                <p><strong>Estado:</strong> <?= $usuario['activo'] ? 'Activo' : 'Inactivo' ?></p>
            </div>
        </div>
        
        <h2 style="margin-bottom: 20px; color: #333;">Menú</h2>
        <div class="menu-links">
            <a href="<?= base_url('visitante/perfil') ?>" class="menu-link">
                <h4>👤 Mi Perfil</h4>
                <p>Ver y editar mi información</p>
            </a>
            <a href="<?= site_url('proyectos/portfolio') ?>" class="menu-link">
                <h4>🎨 Ver Proyectos de Saray</h4>
                <p>Explorar el portfolio de proyectos</p>
            </a>
            <a href="#" class="menu-link">
                <h4>📚 Contenido</h4>
                <p>Ver contenido disponible</p>
            </a>
        </div>
    </div>
</body>
</html>
