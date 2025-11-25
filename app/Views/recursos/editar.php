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
        
        .btn-back {
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 8px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s;
        }
        
        .btn-back:hover {
            background: rgba(255,255,255,0.3);
        }
        
        .container {
            max-width: 900px;
            margin: 30px auto;
            padding: 0 20px;
        }
        
        .form-container {
            background: white;
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .form-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .form-header h2 {
            font-size: 28px;
            color: #333;
            margin-bottom: 10px;
        }
        
        .form-header p {
            color: #666;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        
        .form-label.required::after {
            content: ' *';
            color: #dc3545;
        }
        
        .form-control {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 15px;
            transition: border-color 0.3s;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #667eea;
        }
        
        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }
        
        .form-help {
            font-size: 13px;
            color: #666;
            margin-top: 5px;
        }
        
        .current-file {
            background: #f8f9fa;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .current-file-icon {
            font-size: 50px;
        }
        
        .current-file-info h4 {
            color: #333;
            margin-bottom: 5px;
        }
        
        .current-file-info p {
            color: #666;
            font-size: 14px;
        }
        
        .file-upload {
            border: 2px dashed #e0e0e0;
            border-radius: 5px;
            padding: 30px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .file-upload:hover {
            border-color: #667eea;
            background: #f8f9ff;
        }
        
        .file-upload-icon {
            font-size: 50px;
            margin-bottom: 15px;
        }
        
        .file-upload input[type="file"] {
            display: none;
        }
        
        .file-name {
            margin-top: 10px;
            font-weight: 600;
            color: #28a745;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .checkbox-group input[type="checkbox"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }
        
        .info-box {
            background: #e7f3ff;
            border-left: 4px solid #667eea;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 25px;
        }
        
        .info-box h4 {
            color: #667eea;
            margin-bottom: 10px;
        }
        
        .info-box ul {
            margin-left: 20px;
        }
        
        .info-box li {
            margin-bottom: 5px;
            color: #555;
        }
        
        .stats-box {
            background: #fff3cd;
            border: 1px solid #ffc107;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 25px;
            display: flex;
            gap: 30px;
            justify-content: center;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-item strong {
            display: block;
            font-size: 24px;
            color: #856404;
        }
        
        .stat-item span {
            font-size: 13px;
            color: #856404;
        }
        
        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 30px;
        }
        
        .btn {
            padding: 12px 30px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .btn-submit:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }
        
        .btn-cancel {
            background: #6c757d;
            color: white;
        }
        
        .btn-cancel:hover {
            background: #5a6268;
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
        
        .alert-error ul {
            margin-left: 20px;
            margin-top: 10px;
        }
        
        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .stats-box {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <h1>✏️ Editar Recurso</h1>
        <a href="<?= site_url('recursos/admin') ?>" class="btn-back">
            ← Volver a Gestión
        </a>
    </nav>
    
    <div class="container">
        <div class="form-container">
            <div class="form-header">
                <h2>Editar Recurso</h2>
                <p>Actualiza la información del recurso</p>
            </div>
            
            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-error">
                    <strong>⚠️ Errores en el formulario:</strong>
                    <ul>
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <!-- Estadísticas -->
            <div class="stats-box">
                <div class="stat-item">
                    <strong><?= $recurso['descargas'] ?></strong>
                    <span>📥 Descargas</span>
                </div>
                <div class="stat-item">
                    <strong><?= date('d/m/Y', strtotime($recurso['created_at'])) ?></strong>
                    <span>📅 Fecha Subida</span>
                </div>
                <?php if ($recurso['tamanio']): ?>
                    <div class="stat-item">
                        <strong><?= number_format($recurso['tamanio'] / 1024, 2) ?> KB</strong>
                        <span>📦 Tamaño</span>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="info-box">
                <h4>ℹ️ Tipos de Visibilidad:</h4>
                <ul>
                    <li><strong>Todos:</strong> Cualquiera puede ver (público sin login)</li>
                    <li><strong>Solo Visitantes:</strong> Requiere estar logueado</li>
                    <li><strong>Solo Admin:</strong> Solo administradores</li>
                </ul>
            </div>
            
            <form action="<?= site_url('recursos/actualizar/' . $recurso['id']) ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <!-- Título -->
                <div class="form-group">
                    <label for="titulo" class="form-label required">Título del Recurso</label>
                    <input type="text" 
                           id="titulo" 
                           name="titulo" 
                           class="form-control" 
                           value="<?= old('titulo', $recurso['titulo']) ?>"
                           required>
                </div>
                
                <!-- Descripción -->
                <div class="form-group">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea id="descripcion" 
                              name="descripcion" 
                              class="form-control"><?= old('descripcion', $recurso['descripcion']) ?></textarea>
                    <div class="form-help">Opcional - Aparecerá en la tarjeta del recurso</div>
                </div>
                
                <!-- Tipo y Icono -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="tipo" class="form-label required">Tipo de Archivo</label>
                        <select id="tipo" name="tipo" class="form-control" required>
                            <option value="pdf" <?= old('tipo', $recurso['tipo']) == 'pdf' ? 'selected' : '' ?>>PDF</option>
                            <option value="documento" <?= old('tipo', $recurso['tipo']) == 'documento' ? 'selected' : '' ?>>Documento</option>
                            <option value="imagen" <?= old('tipo', $recurso['tipo']) == 'imagen' ? 'selected' : '' ?>>Imagen</option>
                            <option value="otro" <?= old('tipo', $recurso['tipo']) == 'otro' ? 'selected' : '' ?>>Otro</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="icono" class="form-label">Icono (Emoji)</label>
                        <input type="text" 
                               id="icono" 
                               name="icono" 
                               class="form-control" 
                               value="<?= old('icono', $recurso['icono']) ?>"
                               maxlength="10">
                        <div class="form-help">Ej: 📄 ✉️ 🎨 📊 📁</div>
                    </div>
                </div>
                
                <!-- Visibilidad y Orden -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="visible_para" class="form-label required">Visibilidad</label>
                        <select id="visible_para" name="visible_para" class="form-control" required>
                            <option value="todos" <?= old('visible_para', $recurso['visible_para']) == 'todos' ? 'selected' : '' ?>>🌐 Todos</option>
                            <option value="solo_visitantes" <?= old('visible_para', $recurso['visible_para']) == 'solo_visitantes' ? 'selected' : '' ?>>👥 Solo Visitantes</option>
                            <option value="solo_admin" <?= old('visible_para', $recurso['visible_para']) == 'solo_admin' ? 'selected' : '' ?>>🔒 Solo Admin</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="orden" class="form-label">Orden</label>
                        <input type="number" 
                               id="orden" 
                               name="orden" 
                               class="form-control" 
                               value="<?= old('orden', $recurso['orden']) ?>"
                               min="0">
                        <div class="form-help">Orden de aparición</div>
                    </div>
                </div>
                
                <!-- Archivo Actual -->
                <div class="form-group">
                    <label class="form-label">Archivo Actual</label>
                    <div class="current-file">
                        <div class="current-file-icon"><?= $recurso['icono'] ?></div>
                        <div class="current-file-info">
                            <h4><?= esc($recurso['archivo']) ?></h4>
                            <p>
                                Tipo: <?= strtoupper($recurso['tipo']) ?>
                                <?php if ($recurso['tamanio']): ?>
                                    | Tamaño: <?= number_format($recurso['tamanio'] / 1024, 2) ?> KB
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Cambiar Archivo (Opcional) -->
                <div class="form-group">
                    <label for="archivo" class="form-label">Cambiar Archivo (Opcional)</label>
                    <div class="file-upload" onclick="document.getElementById('archivo').click()">
                        <div class="file-upload-icon">📁</div>
                        <div>
                            <strong>Click para cambiar el archivo</strong>
                            <div class="form-help">Solo si quieres reemplazarlo | Máximo 10 MB</div>
                        </div>
                        <input type="file" 
                               id="archivo" 
                               name="archivo"
                               accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.gif,.zip"
                               onchange="mostrarNombreArchivo(this)">
                        <div class="file-name" id="fileName"></div>
                    </div>
                </div>
                
                <!-- Activo -->
                <div class="form-group">
                    <div class="checkbox-group">
                        <input type="checkbox" 
                               id="activo" 
                               name="activo" 
                               value="1"
                               <?= old('activo', $recurso['activo']) ? 'checked' : '' ?>>
                        <label for="activo" class="form-label" style="margin-bottom: 0;">
                            Recurso activo (visible para usuarios)
                        </label>
                    </div>
                </div>
                
                <!-- Acciones -->
                <div class="form-actions">
                    <a href="<?= site_url('recursos/admin') ?>" class="btn btn-cancel">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-submit">
                        💾 Actualizar Recurso
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        function mostrarNombreArchivo(input) {
            const fileName = document.getElementById('fileName');
            if (input.files && input.files[0]) {
                const size = (input.files[0].size / 1024).toFixed(2);
                fileName.textContent = `✅ Nuevo: ${input.files[0].name} (${size} KB)`;
            }
        }
    </script>
</body>
</html>
