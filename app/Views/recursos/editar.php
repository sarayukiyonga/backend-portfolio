<!DOCTYPE html>
<html lang="es">
<head>
    <?php include(APPPATH . 'Views/components/head.php'); ?>
</head>
<body>
    <?php include(APPPATH . 'Views/components/sidebar.php'); ?>
   <div class="main-content">
       <?php include(APPPATH . 'Views/components/navbar.php'); ?>
   
    <div class="container">
                <div class="navbar-actions">
            <a href="<?= site_url('recursos/admin') ?>" class="btn-back">
            ← Volver a Gestión
        </a>
        </div>

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
    <?php include(APPPATH . 'Views/components/sidebar_js.php'); ?>
</body>
</html>

