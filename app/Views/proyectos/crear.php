<!DOCTYPE html>
<html lang="es">
<head>
    <?php include(APPPATH . 'Views/components/head.php');?>
      <script src="https://cdn.tiny.cloud/1/byy3zrxsooum73ae4zqsfuzkgouoj88keyqa3m3vze8u6579/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>

</head>
<body>
     <?php include(APPPATH . 'Views/components/sidebar.php'); ?>
   <div class="main-content">
       <?php include(APPPATH . 'Views/components/navbar.php'); ?>
    <div class="container">
         <a href="<?= site_url('proyectos') ?>" class="btn-back">← Volver</a>
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
        
        <form action="<?= site_url('proyectos/guardar') ?>" method="POST" enctype="multipart/form-data" id="formProyecto">
            <?= csrf_field() ?>
            
            <!-- Información Básica -->
            <div class="form-card">
                <h2 class="form-title">📝 Información Básica</h2>
                
                <div class="form-group">
                    <label>Nombre del Proyecto <span class="required">*</span></label>
                    <input type="text" name="nombre" class="form-control" 
                           value="<?= old('nombre') ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Imagen Principal <span class="required">*</span></label>
                    <div class="file-input-wrapper">
                        <input type="file" name="imagen_principal" id="imagen_principal" 
                               accept="image/*" required onchange="previewImage(this, 'preview-principal')">
                        <label for="imagen_principal" class="file-input-label">
                            📷 Click para seleccionar imagen principal<br>
                            <small class="help-text">Tamaño máximo: 5MB</small>
                        </label>
                        <div id="preview-principal" class="file-preview"></div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Descripción Corta <span class="required">*</span></label>
                    <textarea name="descripcion" class="form-control" required><?= old('descripcion') ?></textarea>
                    <small class="help-text">Una descripción breve del proyecto (2-3 líneas)</small>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Cliente</label>
                        <input type="text" name="cliente" class="form-control" 
                               value="<?= old('cliente') ?>">
                    </div>
                    
                    <div class="form-group">
                        <label>Año</label>
                        <input type="number" name="anio" class="form-control" 
                               min="2000" max="2100" value="<?= old('anio', date('Y')) ?>">
                    </div>
                </div>
            </div>
            
            <!-- CONTINÚA EN PARTE 2 -->
            <!-- Caso de Estudio -->
            <div class="form-card">
                <h2 class="form-title">📄 Caso de Estudio</h2>
                
                <div class="form-group">
                    <label>Contenido del Caso de Estudio</label>
                    <textarea name="caso_estudio" class="form-control tinymce"><?= old('caso_estudio') ?></textarea>
                    <small class="help-text">Describe el proyecto en detalle, objetivos, proceso, resultados...</small>
                </div>
            </div>
            
            <!-- Secciones de Contenido -->
            <div class="form-card">
                <h2 class="form-title">📑 Secciones de Contenido</h2>
                <p style="color: #666; margin-bottom: 20px;">Agrega secciones con imágenes o videos y su contenido correspondiente</p>
                
                <div id="secciones-container" class="secciones-container">
                    <!-- Las secciones se agregarán aquí dinámicamente -->
                </div>
                
                <button type="button" class="btn-add" onclick="agregarSeccion()">
                    ➕ Agregar Sección
                </button>
            </div>
            
            <!-- Galería de Imágenes -->
            <div class="form-card">
                <h2 class="form-title">🖼️ Galería de Imágenes</h2>
                
                <div class="form-group">
                    <label>Imágenes de la Galería</label>
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
                <button type="submit" class="btn-submit">💾 Guardar Proyecto</button>
            </div>
        </form>
    </div>
</div>    
    <script>
        let seccionCounter = 0;
        
        // Inicializar TinyMCE
        function initTinyMCE(selector) {
         tinymce.init({
        selector: selector,
        plugins: 'lists link image table code help wordcount autolink anchor charmap codesample emoticons media searchreplace visualblocks wordcount',
        toolbar: 'undo redo | formatselect | bold italic underline strikethrough | addcomment showcomments | alignleft aligncenter alignright alignjustify lineheight | checklist numlist bullist indent outdent | emoticons charmap | link image | removeformat code',
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
                        <span class="seccion-titulo">Sección ${seccionNum + 1}</span>
                        <button type="button" class="btn-remove-seccion" onclick="eliminarSeccion(${seccionNum})">
                            🗑️ Eliminar
                        </button>
                    </div>
                    
                    <div class="form-group">
                        <label>Título de la Sección</label>
                        <input type="text" name="secciones[${seccionNum}][titulo]" 
                               class="form-control" placeholder="Ej: Proceso de Diseño">
                        <small class="help-text">Título que se mostrará para esta sección</small>
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
                // Destruir TinyMCE de esta sección
                tinymce.get(`secciones[${num}][contenido]`)?.remove();
                
                const seccion = document.getElementById(`seccion-${num}`);
                seccion.remove();
                
                // Renumerar secciones
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
                titulo.textContent = `Sección ${index + 1}`;
            });
        }
        
        // Validación antes de enviar
        document.getElementById('formProyecto').addEventListener('submit', function(e) {
            // Actualizar contenido de TinyMCE antes de enviar
            tinymce.triggerSave();
        });
    </script>
    <?php include(APPPATH . 'Views/components/sidebar_js.php'); ?>
</body>
</html>
