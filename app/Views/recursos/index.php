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
        
        .btn-back {
            background: rgba(255,255,255,0.2);
            color: white;
        }
        
        .btn-back:hover {
            background: rgba(255,255,255,0.3);
        }
        
        .btn-admin {
            background: rgba(255,255,255,0.9);
            color: #667eea;
            font-weight: 600;
        }
        
        .btn-admin:hover {
            background: white;
        }
        
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }
        
        .header-section {
            background: white;
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .header-section h2 {
            font-size: 32px;
            color: #333;
            margin-bottom: 10px;
        }
        
        .header-section p {
            font-size: 16px;
            color: #666;
        }
        
        .recursos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 25px;
        }
        
        .recurso-card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .recurso-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }
        
        .recurso-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }
        
        .recurso-icon {
            font-size: 50px;
        }
        
        .recurso-info {
            flex: 1;
        }
        
        .recurso-titulo {
            font-size: 20px;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }
        
        .recurso-tipo {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .tipo-pdf {
            background: #ffebee;
            color: #c62828;
        }
        
        .tipo-documento {
            background: #e3f2fd;
            color: #1565c0;
        }
        
        .recurso-descripcion {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 15px;
        }
        
        .recurso-meta {
            display: flex;
            gap: 15px;
            font-size: 13px;
            color: #999;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }
        
        .recurso-meta span {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .recurso-acciones {
            display: flex;
            gap: 10px;
        }
        
        .btn-accion {
            flex: 1;
            padding: 10px;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .btn-previsualizar {
            background: #667eea;
            color: white;
        }
        
        .btn-previsualizar:hover {
            background: #5568d3;
        }
        
        .btn-descargar {
            background: #28a745;
            color: white;
        }
        
        .btn-descargar:hover {
            background: #218838;
        }
        
        .empty-state {
            text-align: center;
            padding: 80px 20px;
            background: white;
            border-radius: 10px;
        }
        
        .empty-state-icon {
            font-size: 80px;
            margin-bottom: 20px;
        }
        
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        @media (max-width: 768px) {
            .recursos-grid {
                grid-template-columns: 1fr;
            }
            
            .recurso-acciones {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <h1>📄 Recursos y Documentos</h1>
        <div class="navbar-actions">
            <?php if ($esAdmin): ?>
                <a href="<?= site_url('recursos/admin') ?>" class="btn btn-admin">
                    🛠️ Panel Admin
                </a>
            <?php endif; ?>
            <a href="<?= site_url(session()->get('usuario_rol') == 'admin' ? 'admin/dashboard' : 'visitante/dashboard') ?>" class="btn btn-back">
                ← Dashboard
            </a>
        </div>
    </nav>
    
    <div class="container">
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-error">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>
        
        <div class="header-section">
            <h2>Recursos Disponibles</h2>
            <p>Documentos y archivos para descargar</p>
        </div>
        
        <?php if (!empty($recursos)): ?>
            <div class="recursos-grid">
                <?php foreach ($recursos as $recurso): ?>
                    <div class="recurso-card">
                        <div class="recurso-header">
                            <div class="recurso-icon"><?= $recurso['icono'] ?></div>
                            <div class="recurso-info">
                                <h3 class="recurso-titulo"><?= esc($recurso['titulo']) ?></h3>
                                <span class="recurso-tipo tipo-<?= $recurso['tipo'] ?>">
                                    <?= strtoupper($recurso['tipo']) ?>
                                </span>
                            </div>
                        </div>
                        
                        <?php if ($recurso['descripcion']): ?>
                            <p class="recurso-descripcion">
                                <?= esc($recurso['descripcion']) ?>
                            </p>
                        <?php endif; ?>
                        
                        <div class="recurso-meta">
                            <?php if ($recurso['tamanio']): ?>
                                <span>
                                    📦 <?= number_format($recurso['tamanio'] / 1024, 0) ?> KB
                                </span>
                            <?php endif; ?>
                            <span>
                                📥 <?= $recurso['descargas'] ?> descargas
                            </span>
                            <span>
                                📅 <?= date('d/m/Y', strtotime($recurso['created_at'])) ?>
                            </span>
                        </div>
                        
                        <div class="recurso-acciones">
                            <?php if ($recurso['tipo'] == 'pdf'): ?>
                                <a href="<?= site_url('recursos/previsualizar/' . $recurso['id']) ?>" 
                                   class="btn-accion btn-previsualizar"
                                   target="_blank">
                                    👁️ Ver PDF
                                </a>
                            <?php endif; ?>
                            <a href="<?= site_url('recursos/descargar/' . $recurso['id']) ?>" 
                               class="btn-accion btn-descargar">
                                ⬇️ Descargar
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-state-icon">📭</div>
                <h2>No hay recursos disponibles</h2>
                <p>Vuelve pronto para ver nuevos recursos</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
