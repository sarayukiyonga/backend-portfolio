<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Proyecto</title>
    
    <!-- TinyMCE desde CDN -->
    <script src="https://cdn.tiny.cloud/1/byy3zrxsooum73ae4zqsfuzkgouoj88keyqa3m3vze8u6579/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>
    
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
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }
        
        .form-card {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .form-title {
            font-size: 20px;
            color: #667eea;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #667eea;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        
        .form-group label .required {
            color: #dc3545;
        }
        
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
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
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        .file-input-wrapper {
            position: relative;
        }
        
        .file-input-wrapper input[type="file"] {
            display: none;
        }
        
        .file-input-label {
            display: block;
            padding: 12px;
            background: #f8f9fa;
            border: 2px dashed #ddd;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .file-input-label:hover {
            background: #e9ecef;
            border-color: #667eea;
        }
        
        .file-preview {
            margin-top: 10px;
            max-width: 300px;
        }
        
        .file-preview img {
            width: 100%;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .imagen-actual {
            margin-top: 10px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        
        .imagen-actual img {
            max-width: 300px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .secciones-container {
            margin-top: 20px;
        }
        
        .seccion-item {
            background: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            position: relative;
        }
        
        .seccion-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .seccion-titulo {
            font-weight: 600;
            color: #667eea;
        }
        
        .btn-remove-seccion {
            background: #dc3545;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
        }
        
        .btn-remove-seccion:hover {
            background: #c82333;
        }
        
        .tipo-media-selector {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }
        
        .tipo-media-selector label {
            display: flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
        }
        
        .btn-add {
            background: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-add:hover {
            background: #218838;
        }
        
        .galeria-preview {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }
        
        .galeria-item {
            position: relative;
        }
        
        .galeria-item img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 5px;
        }
        
        .galeria-item-edit {
            position: relative;
            text-align: center;
        }
        
        .galeria-item-edit img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 5px;
            margin-bottom: 8px;
        }
        
        .galeria-item-edit button {
            background: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            cursor: pointer;
        }
        
        .galeria-item-edit button:hover {
            background: #c82333;
        }
        
        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
        
        .btn-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 40px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
        }
        
        .btn-submit:hover {
            opacity: 0.9;
        }
        
        .btn-cancel {
            background: #6c757d;
            color: white;
            padding: 12px 30px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
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
        
        .help-text {
            font-size: 12px;
            color: #999;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <h1>✏️ Editar: <?= esc($proyecto['nombre']) ?></h1>
        <a href="<?= site_url('proyectos') ?>" class="btn-back">← Volver</a>
    </nav>
    
    <div class="container">
        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-error">
                <strong>Errores:</strong>
                <ul style="margin: 10px 0 0 20px;">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <form action="<?= site_url('proyectos/actualizar/' . $proyecto['id']) ?>" 
              method="POST" enctype="multipart/form-data" id="formProyecto">
            <?= csrf_field() ?>
            
            <!-- Información Básica -->
            <div class="form-card">
                <h2 class="form-title">📝 Información Básica</h2>
                
                <div class="form-group">
                    <label>Nombre del Proyecto <span class="required">*</span></label>
                    <input type="text" name="nombre" class="form-control" 
                           value="<?= esc($proyecto['nombre']) ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Imagen Principal</label>
                    <?php if ($proyecto['imagen_principal']): ?>
                        <div class="imagen-actual">
                            <p style="margin-bottom: 10px;"><strong>Imagen actual:</strong></p>
                            <img src="<?= base_url('uploads/proyectos/' . $proyecto['imagen_principal']) ?>" 
                                 alt="Imagen actual">
                            <p style="margin-top: 10px; font-size: 13px; color: #666;">
                                Selecciona una nueva imagen solo si deseas cambiarla
                            </p>
                        </div>
                    <?php endif; ?>
                    <div class="file-input-wrapper" style="margin-top: 10px;">
                        <input type="file" name="imagen_principal" id="imagen_principal" 
                               accept="image/*" onchange="previewImage(this, 'preview-principal')">
                        <label for="imagen_principal" class="file-input-label">
                            📷 Click para cambiar imagen principal<br>
                            <small class="help-text">Tamaño máximo: 5MB (opcional)</small>
                        </label>
                        <div id="preview-principal" class="file-preview"></div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Descripción Corta <span class="required">*</span></label>
                    <textarea name="descripcion" class="form-control" required><?= esc($proyecto['descripcion']) ?></textarea>
                    <small class="help-text">Una descripción breve del proyecto (2-3 líneas)</small>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Cliente</label>
                        <input type="text" name="cliente" class="form-control" 
                               value="<?= esc($proyecto['cliente']) ?>">
                    </div>
                    
                    <div class="form-group">
                        <label>Año</label>
                        <input type="number" name="anio" class="form-control" 
                               min="2000" max="2100" value="<?= $proyecto['anio'] ?>">
                    </div>
                </div>
            </div>
            
            <!-- Continúa en la siguiente parte... -->
            <!-- Caso de Estudio -->
            <div class="form-card">
                <h2 class="form-title">📄 Caso de Estudio</h2>
                
                <div class="form-group">
                    <label>Contenido del Caso de Estudio</label>
                    <textarea name="caso_estudio" class="form-control tinymce"><?= $proyecto['caso_estudio'] ?></textarea>
                    <small class="help-text">Describe el proyecto en detalle, objetivos, proceso, resultados...</small>
                </div>
            </div>
            
            <!-- Secciones de Contenido -->
            <div class="form-card">
                <h2 class="form-title">📑 Secciones de Contenido</h2>
                <p style="color: #666; margin-bottom: 20px;">Gestiona las secciones con imágenes o videos y su contenido</p>
                
                <?php if (!empty($proyecto['secciones'])): ?>
                    <div style="background: #fff3cd; padding: 15px; border-radius: 5px; margin-bottom: 20px; border-left: 4px solid #ffc107;">
                        <p style="margin: 0; color: #856404;">
                            <strong>⚠️ Secciones existentes:</strong> <?= count($proyecto['secciones']) ?> sección(es)<br>
                            Para modificar, puedes eliminar secciones específicas y agregar nuevas, o editarlas directamente en la base de datos.
                        </p>
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <h4 style="margin-bottom: 10px;">Secciones Actuales:</h4>
                        <?php foreach ($proyecto['secciones'] as $index => $seccion): ?>
                            <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 10px; display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <strong>Sección <?= $index + 1 ?></strong>
                                    - <?= $seccion['tipo_media'] == 'imagen' ? '📷 Imagen' : '🎥 Video' ?>
                                    <?php if ($seccion['media_url']): ?>
                                        <span style="color: #28a745;">✓ Con media</span>
                                    <?php endif; ?>
                                </div>
                                <a href="<?= site_url('proyectos/eliminarSeccion/' . $seccion['id']) ?>" 
                                   onclick="return confirm('¿Eliminar esta sección?')"
                                   style="background: #dc3545; color: white; padding: 5px 10px; border-radius: 4px; text-decoration: none; font-size: 13px;">
                                    🗑️ Eliminar
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                <div id="secciones-container" class="secciones-container">
                    <!-- Las nuevas secciones se agregarán aquí dinámicamente -->
                </div>
                
                <button type="button" class="btn-add" onclick="agregarSeccion()">
                    ➕ Agregar Nueva Sección
                </button>
            </div>
            
            <!-- Galería de Imágenes -->
            <div class="form-card">
                <h2 class="form-title">🖼️ Galería de Imágenes</h2>
                
                <?php if (!empty($proyecto['galeria'])): ?>
                    <h4 style="margin-bottom: 15px;">Imágenes Actuales (<?= count($proyecto['galeria']) ?>):</h4>
                    <div class="galeria-preview">
                        <?php foreach ($proyecto['galeria'] as $img): ?>
                            <div class="galeria-item-edit" id="galeria-<?= $img['id'] ?>">
                                <img src="<?= base_url('uploads/proyectos/galeria/' . $img['imagen']) ?>" 
                                     alt="Galería">
                                <button type="button" onclick="eliminarImagenGaleria(<?= $img['id'] ?>)">
                                    🗑️ Eliminar
                                </button>
                                <input type="hidden" name="galeria_ids[]" value="<?= $img['id'] ?>">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <hr style="margin: 20px 0;">
                <?php endif; ?>
                
                <div class="form-group">
                    <label>Agregar Más Imágenes a la Galería</label>
                    <div class="file-input-wrapper">
                        <input type="file" name="galeria[]" id="galeria" 
                               accept="image/*" multiple onchange="previewGaleria(this)">
                        <label for="galeria" class="file-input-label">
                            🖼️ Click para seleccionar múltiples imágenes<br>
                            <small class="help-text">Puedes seleccionar varias imágenes a la vez</small>
                        </label>
                    </div>
                    <div id="galeria-preview" class="galeria-preview"></div>
                </div>
            </div>
            <!-- Después de los campos existentes y antes de la imagen principal -->

<div class="form-group">
    <label for="estado" class="form-label">📊 Estado del Proyecto *</label>
    <select name="estado" id="estado" class="form-control" required>
        <option value="borrador" <?= isset($proyecto) && $proyecto['estado'] == 'borrador' ? 'selected' : '' ?>>
            📝 Borrador (Solo admin)
        </option>
        <option value="publicado" <?= isset($proyecto) && $proyecto['estado'] == 'publicado' ? 'selected' : '' ?>>
            ✅ Publicado (Visible según visibilidad)
        </option>
        <option value="archivado" <?= isset($proyecto) && $proyecto['estado'] == 'archivado' ? 'selected' : '' ?>>
            📦 Archivado (Oculto)
        </option>
    </select>
</div>

<div class="form-group">
    <label for="visibilidad" class="form-label">👁️ Visibilidad *</label>
    <select name="visibilidad" id="visibilidad" class="form-control" required>
        <option value="privado" <?= isset($proyecto) && $proyecto['visibilidad'] == 'privado' ? 'selected' : '' ?>>
            🔒 Privado (Solo admin)
        </option>
        <option value="autenticado" <?= isset($proyecto) && $proyecto['visibilidad'] == 'autenticado' ? 'selected' : '' ?>>
            👥 Autenticado (Admin + Visitantes)
        </option>
        <option value="publico" <?= isset($proyecto) && $proyecto['visibilidad'] == 'publico' ? 'selected' : '' ?>>
            🌐 Público (Frontend sin login)
        </option>
    </select>
</div>

<div class="info-box" style="background: #e7f3ff; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
    <strong>ℹ️ Combinaciones comunes:</strong>
    <ul style="margin: 10px 0 0 20px;">
        <li><strong>Borrador + Privado:</strong> En desarrollo, solo tú lo ves</li>
        <li><strong>Publicado + Autenticado:</strong> Portfolio privado, requiere login</li>
        <li><strong>Publicado + Público:</strong> Se muestra en la web pública</li>
    </ul>
</div>
            <!-- Acciones -->
            <div class="form-actions">
                <a href="<?= site_url('proyectos') ?>" class="btn-cancel">Cancelar</a>
                <button type="submit" class="btn-submit">💾 Guardar Cambios</button>
            </div>
        </form>
    </div>
    
    <script>
        let seccionCounter = 0;
        
        // Inicializar TinyMCE
        // Inicializar TinyMCE
        function initTinyMCE(selector) {
         tinymce.init({
        selector: selector,
        plugins: 'lists link image table code help wordcount autolink anchor charmap codesample emoticons media ai searchreplace visualblocks wordcount autocorrect a11ychecker  tinymcespellchecker',
        toolbar: 'undo redo | formatselect | bold italic underline strikethrough | addcomment showcomments | alignleft aligncenter alignright alignjustify lineheight | spellcheckdialog a11ycheck | checklist numlist bullist indent outdent | emoticons charmap | link image | removeformat code',
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',
        mergetags_list: [
            { value: 'First.Name', title: 'First Name' },
            { value: 'Email', title: 'Email' },
        ],
        ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
        height: 400,
        menubar: true,
        branding: false,
        content_style: 'body { font-family: Arial, sans-serif; font-size: 14px; }',
        promotion: false,
        
        // ===== CONFIGURACIÓN DE SUBIDA DE IMÁGENES =====
        
        // Habilitar subida automática
        automatic_uploads: true,
        
        // Tamaño máximo de archivo (en bytes) - 5MB
        file_picker_types: 'image',
        
        // Handler de subida de imágenes
        images_upload_handler: function (blobInfo, success, failure, progress) {
            var xhr, formData;
            
            // Crear petición XMLHttpRequest
            xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            
            // URL del endpoint
            xhr.open('POST', '<?= site_url("proyectos/subirImagenTinymce") ?>');
            
            // Headers necesarios
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            
            // Mostrar progreso de subida
            xhr.upload.onprogress = function (e) {
                if (typeof progress === 'function') {
                    progress(e.loaded / e.total * 100);
                }
            };
            
            // Cuando la subida termine
            xhr.onload = function() {
                var json;
                
                // Verificar código de respuesta
                if (xhr.status === 403) {
                    failure('No tienes permisos para subir imágenes', { remove: true });
                    return;
                }
                
                if (xhr.status < 200 || xhr.status >= 300) {
                    failure('Error HTTP: ' + xhr.status);
                    return;
                }
                
                // Parse JSON
                try {
                    json = JSON.parse(xhr.responseText);
                } catch (e) {
                    failure('Respuesta inválida del servidor');
                    return;
                }
                
                // Verificar que tenga la ubicación de la imagen
                if (!json || typeof json.location != 'string') {
                    if (json.error) {
                        failure(json.error);
                    } else {
                        failure('Respuesta inválida: ' + xhr.responseText);
                    }
                    return;
                }
                
                // Éxito - insertar imagen
                success(json.location);
            };
            
            // Si hay error de red
            xhr.onerror = function () {
                failure('Error de red. La imagen no se pudo subir. Código: ' + xhr.status);
            };
            
            // Preparar datos del formulario
            formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());
            
            // CSRF Token para CodeIgniter
            formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');
            
            // Enviar
            xhr.send(formData);
        },
        
        // Validación antes de subir
        images_upload_base_path: '',
        images_reuse_filename: false,
        
        // Mensaje de error personalizado
        images_upload_credentials: false
    });
}
        
        // Inicializar TinyMCE para caso de estudio
        document.addEventListener('DOMContentLoaded', function() {
            initTinyMCE('textarea.tinymce');
        });
        
        // Preview de imagen principal
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            preview.innerHTML = '';
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        // Preview de galería
        function previewGaleria(input) {
            const preview = document.getElementById('galeria-preview');
            preview.innerHTML = '';
            
            if (input.files) {
                Array.from(input.files).forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'galeria-item';
                        div.innerHTML = `<img src="${e.target.result}" alt="Imagen ${index + 1}">`;
                        preview.appendChild(div);
                    };
                    reader.readAsDataURL(file);
                });
            }
        }
        
        // Agregar nueva sección
        function agregarSeccion() {
            const container = document.getElementById('secciones-container');
            const seccionNum = seccionCounter++;
            
            const seccionHTML = `
                <div class="seccion-item" id="seccion-${seccionNum}">
                    <div class="seccion-header">
                        <span class="seccion-titulo">Nueva Sección ${seccionNum + 1}</span>
                        <button type="button" class="btn-remove-seccion" onclick="eliminarSeccion(${seccionNum})">
                            🗑️ Eliminar
                        </button>
                    </div>
                    
                    <div class="form-group">
                        <label>Tipo de Media</label>
                        <div class="tipo-media-selector">
                            <label>
                                <input type="radio" name="secciones[${seccionNum}][tipo_media]" 
                                       value="imagen" checked onchange="toggleMediaInput(${seccionNum}, 'imagen')">
                                📷 Imagen
                            </label>
                            <label>
                                <input type="radio" name="secciones[${seccionNum}][tipo_media]" 
                                       value="video" onchange="toggleMediaInput(${seccionNum}, 'video')">
                                🎥 Video
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group" id="media-imagen-${seccionNum}">
                        <label>Imagen de la Sección</label>
                        <div class="file-input-wrapper">
                            <input type="file" name="secciones[${seccionNum}][media_file]" 
                                   id="seccion-img-${seccionNum}" accept="image/*"
                                   onchange="previewImage(this, 'preview-seccion-${seccionNum}')">
                            <label for="seccion-img-${seccionNum}" class="file-input-label">
                                📷 Seleccionar imagen
                            </label>
                            <div id="preview-seccion-${seccionNum}" class="file-preview"></div>
                        </div>
                    </div>
                    
                    <div class="form-group" id="media-video-${seccionNum}" style="display: none;">
                        <label>URL del Video</label>
                        <input type="url" name="secciones[${seccionNum}][media_url]" 
                               class="form-control" placeholder="https://www.youtube.com/watch?v=...">
                        <small class="help-text">YouTube, Vimeo, etc.</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Contenido de la Sección</label>
                        <textarea name="secciones[${seccionNum}][contenido]" 
                                  class="form-control tinymce-seccion-${seccionNum}"></textarea>
                    </div>
                </div>
            `;
            
            container.insertAdjacentHTML('beforeend', seccionHTML);
            
            // Inicializar TinyMCE para esta sección
            setTimeout(() => {
                initTinyMCE(`.tinymce-seccion-${seccionNum}`);
            }, 100);
        }
        
        // Eliminar sección
        function eliminarSeccion(num) {
            if (confirm('¿Eliminar esta sección?')) {
                const editor = tinymce.get(`secciones[${num}][contenido]`);
                if (editor) {
                    editor.remove();
                }
                
                const seccion = document.getElementById(`seccion-${num}`);
                seccion.remove();
                
                renumerarSecciones();
            }
        }
        
        // Cambiar entre imagen y video
        function toggleMediaInput(num, tipo) {
            const imagenDiv = document.getElementById(`media-imagen-${num}`);
            const videoDiv = document.getElementById(`media-video-${num}`);
            
            if (tipo === 'imagen') {
                imagenDiv.style.display = 'block';
                videoDiv.style.display = 'none';
            } else {
                imagenDiv.style.display = 'none';
                videoDiv.style.display = 'block';
            }
        }
        
        // Renumerar secciones visualmente
        function renumerarSecciones() {
            const secciones = document.querySelectorAll('.seccion-item');
            secciones.forEach((seccion, index) => {
                const titulo = seccion.querySelector('.seccion-titulo');
                if (titulo.textContent.includes('Nueva Sección')) {
                    titulo.textContent = `Nueva Sección ${index + 1}`;
                }
            });
        }
        
        // Eliminar imagen de galería (AJAX)
        function eliminarImagenGaleria(id) {
            if (!confirm('¿Eliminar esta imagen de la galería?')) return;
            
            fetch(`<?= site_url('proyectos/eliminarImagenGaleria/') ?>${id}`, {
                method: 'DELETE',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    '<?= csrf_header() ?>': '<?= csrf_hash() ?>'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById(`galeria-${id}`).remove();
                    alert('Imagen eliminada correctamente');
                } else {
                    alert('Error al eliminar: ' + data.message);
                }
            })
            .catch(error => {
                alert('Error de conexión');
                console.error(error);
            });
        }
        
        // Validación antes de enviar
        document.getElementById('formProyecto').addEventListener('submit', function(e) {
            tinymce.triggerSave();
        });
    </script>
</body>
</html>