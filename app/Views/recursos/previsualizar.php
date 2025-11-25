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
            background: #2d3748;
            overflow: hidden;
        }
        
        .header {
            background: #1a202c;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.3);
        }
        
        .header h1 {
            font-size: 18px;
            font-weight: 600;
        }
        
        .header-actions {
            display: flex;
            gap: 10px;
        }
        
        .btn {
            padding: 8px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .btn-download {
            background: #28a745;
            color: white;
        }
        
        .btn-download:hover {
            background: #218838;
        }
        
        .btn-close {
            background: #dc3545;
            color: white;
        }
        
        .btn-close:hover {
            background: #c82333;
        }
        
        .pdf-container {
            width: 100%;
            height: calc(100vh - 60px);
            background: #2d3748;
        }
        
        iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
        
        .loading {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 60px);
            color: white;
            font-size: 24px;
        }
        
        .error-message {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 60px);
            color: white;
            text-align: center;
            padding: 20px;
        }
        
        .error-icon {
            font-size: 80px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📄 <?= esc($recurso['titulo']) ?></h1>
        <div class="header-actions">
            <a href="<?= site_url('recursos/descargar/' . $recurso['id']) ?>" 
               class="btn btn-download">
                ⬇️ Descargar
            </a>
            <a href="javascript:window.close()" class="btn btn-close">
                ✖ Cerrar
            </a>
        </div>
    </div>
    
    <div class="pdf-container">
        <?php 
        $rutaPDF = base_url('uploads/recursos/' . $recurso['archivo']);
        $rutaCompleta = FCPATH . 'uploads/recursos/' . $recurso['archivo'];
        
        if (file_exists($rutaCompleta)): 
        ?>
            <iframe 
                src="<?= $rutaPDF ?>#toolbar=1&navpanes=1&scrollbar=1" 
                type="application/pdf"
                title="<?= esc($recurso['titulo']) ?>">
                <div class="error-message">
                    <div class="error-icon">⚠️</div>
                    <h2>No se puede mostrar el PDF</h2>
                    <p>Tu navegador no soporta la visualización de PDFs</p>
                    <br>
                    <a href="<?= site_url('recursos/descargar/' . $recurso['id']) ?>" 
                       class="btn btn-download">
                        ⬇️ Descargar PDF
                    </a>
                </div>
            </iframe>
        <?php else: ?>
            <div class="error-message">
                <div class="error-icon">❌</div>
                <h2>Archivo no encontrado</h2>
                <p>El PDF no está disponible en este momento</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
