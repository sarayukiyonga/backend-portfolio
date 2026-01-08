<?php
$pageTitle = 'Proyecto Privado';
$pageDescription = 'Este proyecto requiere autenticación para ser visualizado.';
$currentPage = 'proyectos';
include 'includes/header.php';
?>
    <div class="container">
        <!-- Overlay de Proyecto Privado -->
        <div class="proyecto-privado-overlay">
            <div class="overlay-content">
                <div class="overlay-icon">🔒</div>
                <h1><?= isset($esPrivado) && $esPrivado ? 'Proyecto Exclusivo' : 'Proyecto Privado' ?></h1>
                <p class="overlay-description">
                    <?php if (isset($esPrivado) && $esPrivado): ?>
                        Este proyecto está disponible solo para administradores.
                    <?php else: ?>
                        Este proyecto está disponible solo para usuarios registrados.
                    <?php endif; ?>
                </p>
                
                <div class="proyecto-info-basica">
                    <h2><?= esc($proyecto['nombre']) ?></h2>
                    <p><?= esc($proyecto['descripcion']) ?></p>
                    <div class="proyecto-meta">
                        <?php if ($proyecto['cliente']): ?>
                            <span>👤 <strong>Cliente:</strong> <?= esc($proyecto['cliente']) ?></span>
                        <?php endif; ?>
                        <?php if ($proyecto['anio']): ?>
                            <span>📅 <strong>Año:</strong> <?= $proyecto['anio'] ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="overlay-actions">
                    <a href="<?= site_url('auth/login') ?>" class="btn btn-primary btn-large">
                        🔑 Iniciar Sesión
                    </a>
                    <p style="margin: 20px 0 10px; color: #666;">
                        ¿No tienes una cuenta?
                    </p>
                    <a href="<?= site_url('auth/registro') ?>" class="btn btn-secondary">
                        📝 Registrarse
                    </a>
                </div>
                
                <div class="overlay-footer">
                    <a href="<?= site_url('proyectos/publico') ?>" class="link-back">
                        ← Volver a Proyectos
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        .proyecto-privado-overlay {
            min-height: 70vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }
        
        .overlay-content {
            max-width: 600px;
            width: 100%;
            background: white;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .overlay-icon {
            font-size: 80px;
            margin-bottom: 20px;
        }
        
        .overlay-content h1 {
            font-size: 32px;
            margin-bottom: 15px;
            color: #333;
        }
        
        .overlay-description {
            font-size: 18px;
            color: #666;
            margin-bottom: 30px;
        }
        
        .proyecto-info-basica {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 12px;
            margin: 30px 0;
            text-align: left;
        }
        
        .proyecto-info-basica h2 {
            font-size: 24px;
            margin-bottom: 15px;
            color: #333;
        }
        
        .proyecto-info-basica p {
            color: #666;
            margin-bottom: 15px;
            line-height: 1.6;
        }
        
        .proyecto-meta {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin-top: 15px;
        }
        
        .proyecto-meta span {
            color: #555;
            font-size: 14px;
        }
        
        .overlay-actions {
            margin: 30px 0;
        }
        
        .btn-large {
            padding: 15px 40px;
            font-size: 18px;
            font-weight: 600;
        }
        
        .btn-secondary {
            display: inline-block;
            padding: 12px 30px;
            background: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: background 0.3s;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
        }
        
        .overlay-footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
        }
        
        .link-back {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }
        
        .link-back:hover {
            color: #764ba2;
            text-decoration: underline;
        }
    </style>
<?php 
include 'includes/footer.php'; 
?>
