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
                <h2>Subir Nuevo Recurso</h2>
                <p>Completa la información del recurso a subir</p>
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
            
            <div class="info-box">
                <h4>ℹ️ Tipos de Visibilidad:</h4>
                <ul>
                    <li><strong>Todos:</strong> Cualquiera puede ver (público sin login)</li>
                    <li><strong>Solo Visitantes:</strong> Requiere estar logueado</li>
                    <li><strong>Solo Admin:</strong> Solo administradores</li>
                </ul>
            </div>
            
            <form action="<?= site_url('recursos/guardar') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <!-- Título -->
                <div class="form-group">
                    <label for="titulo" class="form-label required">Título del Recurso</label>
                    <input type="text" 
                           id="titulo" 
                           name="titulo" 
                           class="form-control" 
                           placeholder="Ej: Currículum Vitae"
                           value="<?= old('titulo') ?>"
                           required>
                </div>
                
                <!-- Descripción -->
                <div class="form-group">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea id="descripcion" 
                              name="descripcion" 
                              class="form-control" 
                              placeholder="Describe brevemente el contenido del recurso"><?= old('descripcion') ?></textarea>
                    <div class="form-help">Opcional - Aparecerá en la tarjeta del recurso</div>
                </div>
                
                <!-- Tipo y Icono -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="tipo" class="form-label required">Tipo de Archivo</label>
                        <select id="tipo" name="tipo" class="form-control" required>
                            <option value="pdf" <?= old('tipo') == 'pdf' ? 'selected' : '' ?>>PDF</option>
                            <option value="documento" <?= old('tipo') == 'documento' ? 'selected' : '' ?>>Documento (Word, Excel)</option>
                            <option value="imagen" <?= old('tipo') == 'imagen' ? 'selected' : '' ?>>Imagen</option>
                            <option value="otro" <?= old('tipo') == 'otro' ? 'selected' : '' ?>>Otro</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="icono" class="form-label">Icono (Emoji)</label>
                        <input type="text" 
                               id="icono" 
                               name="icono" 
                               class="form-control" 
                               placeholder="📄"
                               value="<?= old('icono', '📄') ?>"
                               maxlength="10">
                        <div class="form-help">Ej: 📄 ✉️ 🎨 📊 📁</div>
                    </div>
                </div>
                
                <!-- Visibilidad y Orden -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="visible_para" class="form-label required">Visibilidad</label>
                        <select id="visible_para" name="visible_para" class="form-control" required>
                            <option value="todos" <?= old('visible_para') == 'todos' ? 'selected' : '' ?>>🌐 Todos (Público)</option>
                            <option value="solo_visitantes" <?= old('visible_para', 'solo_visitantes') == 'solo_visitantes' ? 'selected' : '' ?>>👥 Solo Visitantes</option>
                            <option value="solo_admin" <?= old('visible_para') == 'solo_admin' ? 'selected' : '' ?>>🔒 Solo Admin</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="orden" class="form-label">Orden</label>
                        <input type="number" 
                               id="orden" 
                               name="orden" 
                               class="form-control" 
                               placeholder="0"
                               value="<?= old('orden', '0') ?>"
                               min="0">
                        <div class="form-help">Orden de aparición (menor primero)</div>
                    </div>
                </div>
                
                <!-- Archivo -->
                <div class="form-group">
                    <label for="archivo" class="form-label required">Archivo</label>
                    <div class="file-upload" onclick="document.getElementById('archivo').click()">
                        <div class="file-upload-icon">📁</div>
                        <div>
                            <strong>Click para seleccionar archivo</strong>
                            <div class="form-help">Máximo 10 MB</div>
                        </div>
                        <input type="file" 
                               id="archivo" 
                               name="archivo" 
                               required
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
                               <?= old('activo', '1') ? 'checked' : '' ?>>
                        <label for="activo" class="form-label" style="margin-bottom: 0;">
                            Recurso activo (visible inmediatamente)
                        </label>
                    </div>
                </div>
                
                <!-- Acciones -->
                <div class="form-actions">
                    <a href="<?= site_url('recursos/admin') ?>" class="btn btn-cancel">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-submit">
                        💾 Subir Recurso
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
                fileName.textContent = `✅ ${input.files[0].name} (${size} KB)`;
            }
        }
    </script>
    <?php include(APPPATH . 'Views/components/sidebar_js.php'); ?>
</body>
</html>

