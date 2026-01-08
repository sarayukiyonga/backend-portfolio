<?php

namespace App\Controllers;

use App\Models\ProyectoModel;
use App\Models\ProyectoSeccionModel;
use App\Models\ProyectoGaleriaModel;

class Proyectos extends BaseController
{
    protected $proyectoModel;
    protected $seccionModel;
    protected $galeriaModel;
    
    public function __construct()
    {
        $this->proyectoModel = new ProyectoModel();
        $this->seccionModel = new ProyectoSeccionModel();
        $this->galeriaModel = new ProyectoGaleriaModel();
        helper(['form', 'url', 'filesystem']);
    }
    
    // Verificar que el usuario sea admin
    private function verificarAdmin()
    {
        if (!session()->has('usuario_id') || session()->get('usuario_rol') != 'admin') {
            return redirect()->to('/auth/login')->with('error', 'Acceso denegado');
        }
        return null;
    }
    
    // ========== MÉTODOS PÚBLICOS ==========
    
    /**
     * Portfolio para visitantes autenticados
     * Muestra proyectos PUBLICADOS con visibilidad AUTENTICADO o PÚBLICO
     */
    public function portfolio()
    {
        // Verificar autenticación
        if (!session()->has('usuario_id')) {
            return redirect()->to('/auth/login')->with('error', 'Debes iniciar sesión para ver el portfolio');
        }
        
        $proyectos = $this->proyectoModel->listarProyectosAutenticados();
        
        $data = [
            'titulo' => 'Portfolio de Proyectos',
            'proyectos' => $proyectos,
            'esAdmin' => session()->get('usuario_rol') == 'admin'
        ];
        
        return view('proyectos/portfolio', $data);
    }
    
    /**
     * Ver detalle de proyecto (visitantes autenticados)
     */
    public function detalle($id)
    {
        // Verificar autenticación
        if (!session()->has('usuario_id')) {
            return redirect()->to('/auth/login')->with('error', 'Debes iniciar sesión');
        }
        
        $proyecto = $this->proyectoModel->getProyectoCompleto($id);
        
        if (!$proyecto) {
            return redirect()->to('/proyectos/portfolio')->with('error', 'Proyecto no encontrado');
        }
        
        // Verificar permisos
        $usuarioRol = session()->get('usuario_rol');
        $puedeVer = $this->proyectoModel->puedeVer($id, $usuarioRol, true);
        
        if (!$puedeVer) {
            return redirect()->to('/proyectos/portfolio')->with('error', 'No tienes permiso para ver este proyecto');
        }
        
        $data = [
            'titulo' => $proyecto['nombre'],
            'proyecto' => $proyecto,
            'esAdmin' => $usuarioRol == 'admin'
        ];
        
        return view('proyectos/detalle', $data);
    }
    
    /**
     * Portfolio PÚBLICO (sin autenticación)
     * Muestra solo proyectos PUBLICADOS con visibilidad PÚBLICO
     */
    public function publico()
    {
        $proyectos = $this->proyectoModel->listarProyectosPublicos();
        
        $data = [
            'titulo' => 'Nuestros Proyectos',
            'proyectos' => $proyectos
        ];
        
        return view('proyectos/publico', $data);
    }
    
    /**
     * Ver detalle de proyecto público (sin autenticación)
     */
    public function publicoDetalle($id)
    {
        $proyecto = $this->proyectoModel->getProyectoCompleto($id);
        
        if (!$proyecto) {
            return redirect()->to('/proyectos/publico')->with('error', 'Proyecto no encontrado');
        }
        
        // Verificar que sea público
        if ($proyecto['estado'] !== 'publicado' || $proyecto['visibilidad'] !== 'publico') {
            return redirect()->to('/proyectos/publico')->with('error', 'Proyecto no disponible');
        }
        
        $data = [
            'titulo' => $proyecto['nombre'],
            'proyecto' => $proyecto
        ];
        
        return view('proyectos/publico_detalle', $data);
    }
    
    // ========== MÉTODOS ADMIN ==========
    
    /**
     * Panel de gestión de proyectos (Admin)
     * Con filtros por estado y visibilidad
     */
    public function index()
    {
        $redirect = $this->verificarAdmin();
        if ($redirect) return $redirect;
        
        // Filtros
        $filtroEstado = $this->request->getGet('estado');
        $filtroVisibilidad = $this->request->getGet('visibilidad');
        
        if ($filtroEstado) {
            $proyectos = $this->proyectoModel->listarPorEstado($filtroEstado);
        } elseif ($filtroVisibilidad) {
            $proyectos = $this->proyectoModel->listarPorVisibilidad($filtroVisibilidad);
        } else {
            $proyectos = $this->proyectoModel->listarTodosProyectos();
        }
        
        // Estadísticas
        $estadisticas = [
            'estados' => $this->proyectoModel->contarPorEstado(),
            'visibilidades' => $this->proyectoModel->contarPorVisibilidad()
        ];
        
        $data = [
            'titulo' => 'Gestión de Proyectos',
            'proyectos' => $proyectos,
            'estadisticas' => $estadisticas,
            'filtroActual' => $filtroEstado ?: $filtroVisibilidad ?: 'todos'
        ];
        
        return view('proyectos/index', $data);
    }
    
    /**
     * Ver proyecto completo (Admin)
     */
    public function ver($id)
    {
        $redirect = $this->verificarAdmin();
        if ($redirect) return $redirect;
        
        $proyecto = $this->proyectoModel->getProyectoCompleto($id);
        
        if (!$proyecto) {
            return redirect()->to('/proyectos')->with('error', 'Proyecto no encontrado');
        }
        
        $data = [
            'titulo' => 'Ver Proyecto: ' . $proyecto['nombre'],
            'proyecto' => $proyecto
        ];
        
        return view('proyectos/ver', $data);
    }
    
    /**
     * Crear proyecto - mostrar formulario
     */
    public function crear()
    {
        $redirect = $this->verificarAdmin();
        if ($redirect) return $redirect;
        
        $data = [
            'titulo' => 'Crear Proyecto'
        ];
        
        return view('proyectos/crear', $data);
    }
    
    /**
     * Guardar proyecto nuevo
     */
    public function guardar()
    {
        $redirect = $this->verificarAdmin();
        if ($redirect) return $redirect;
        
        $validation = \Config\Services::validation();
        
        $rules = [
            'nombre' => 'required|min_length[3]',
            'descripcion' => 'required',
            'estado' => 'required|in_list[borrador,publicado,archivado]',
            'visibilidad' => 'required|in_list[privado,autenticado,publico]',
            'imagen_principal' => 'uploaded[imagen_principal]|max_size[imagen_principal,5120]|is_image[imagen_principal]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        // Subir imagen principal
        $imagenPrincipal = $this->request->getFile('imagen_principal');
        $nombreImagen = $imagenPrincipal->getRandomName();
        $imagenPrincipal->move(WRITEPATH . '../public/uploads/proyectos', $nombreImagen);
        
        // Guardar proyecto
        $dataProyecto = [
            'nombre' => $this->request->getPost('nombre'),
            'imagen_principal' => $nombreImagen,
            'descripcion' => $this->request->getPost('descripcion'),
            'caso_estudio' => $this->request->getPost('caso_estudio'),
            'cliente' => $this->request->getPost('cliente'),
            'anio' => $this->request->getPost('anio'),
            'orden' => $this->request->getPost('orden') ?: $this->proyectoModel->getSiguienteOrden(),
            'activo' => 1, // Mantener por compatibilidad
            'estado' => $this->request->getPost('estado'),
            'visibilidad' => $this->request->getPost('visibilidad')
        ];
        
        $proyectoId = $this->proyectoModel->insert($dataProyecto);
        
        // Guardar secciones
        $this->guardarSecciones($proyectoId);
        
        // Guardar galería
        $this->guardarGaleria($proyectoId);
        
        $mensaje = 'Proyecto creado correctamente';
        if ($dataProyecto['estado'] == 'borrador') {
            $mensaje .= ' como BORRADOR';
        }
        
        return redirect()->to('/proyectos')->with('success', $mensaje);
    }
    
    /**
     * Editar proyecto - mostrar formulario
     */
    public function editar($id)
    {
        $redirect = $this->verificarAdmin();
        if ($redirect) return $redirect;
        
        $proyecto = $this->proyectoModel->getProyectoCompleto($id);
        
        if (!$proyecto) {
            return redirect()->to('/proyectos')->with('error', 'Proyecto no encontrado');
        }
        
        $data = [
            'titulo' => 'Editar Proyecto',
            'proyecto' => $proyecto
        ];
        
        return view('proyectos/editar', $data);
    }
    
    /**
     * Actualizar proyecto
     */
    public function actualizar($id)
    {
        $redirect = $this->verificarAdmin();
        if ($redirect) return $redirect;
        
        $proyecto = $this->proyectoModel->find($id);
        
        if (!$proyecto) {
            return redirect()->to('/proyectos')->with('error', 'Proyecto no encontrado');
        }
        
        $validation = \Config\Services::validation();
        
        $rules = [
            'nombre' => 'required|min_length[3]',
            'descripcion' => 'required',
            'estado' => 'required|in_list[borrador,publicado,archivado]',
            'visibilidad' => 'required|in_list[privado,autenticado,publico]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        // Actualizar datos básicos
        $dataProyecto = [
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'caso_estudio' => $this->request->getPost('caso_estudio'),
            'cliente' => $this->request->getPost('cliente'),
            'anio' => $this->request->getPost('anio'),
            'orden' => $this->request->getPost('orden') ?: $this->proyectoModel->getSiguienteOrden(),
            'estado' => $this->request->getPost('estado'),
            'visibilidad' => $this->request->getPost('visibilidad')
        ];
        
        // Cambiar imagen principal si se subió una nueva
        $imagenPrincipal = $this->request->getFile('imagen_principal');
        if ($imagenPrincipal && $imagenPrincipal->isValid() && !$imagenPrincipal->hasMoved()) {
            // Eliminar imagen anterior
            if ($proyecto['imagen_principal']) {
                $rutaAntigua = WRITEPATH . '../public/uploads/proyectos/' . $proyecto['imagen_principal'];
                if (file_exists($rutaAntigua)) {
                    unlink($rutaAntigua);
                }
            }
            
            // Subir nueva imagen
            $nombreImagen = $imagenPrincipal->getRandomName();
            $imagenPrincipal->move(WRITEPATH . '../public/uploads/proyectos', $nombreImagen);
            $dataProyecto['imagen_principal'] = $nombreImagen;
        }
        
        $this->proyectoModel->update($id, $dataProyecto);
        
        // Actualizar secciones
        $this->actualizarSecciones($id);
        
        // Actualizar galería
        $this->actualizarGaleria($id);
        
        return redirect()->to('/proyectos')->with('success', 'Proyecto actualizado correctamente');
    }
    
    /**
     * Cambiar estado de un proyecto (AJAX)
     */
    public function cambiarEstado($id)
    {
        $redirect = $this->verificarAdmin();
        if ($redirect) return $redirect;
        
        $nuevoEstado = $this->request->getPost('estado');
        
        if (!in_array($nuevoEstado, ['borrador', 'publicado', 'archivado'])) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['success' => false, 'message' => 'Estado inválido']);
            }
            return redirect()->back()->with('error', 'Estado inválido');
        }
        
        if ($this->proyectoModel->cambiarEstado($id, $nuevoEstado)) {
            $mensaje = 'Estado cambiado a: ' . ucfirst($nuevoEstado);
            
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['success' => true, 'message' => $mensaje]);
            }
            return redirect()->back()->with('success', $mensaje);
        }
        
        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Error al cambiar estado']);
        }
        return redirect()->back()->with('error', 'Error al cambiar estado');
    }
    
    /**
     * Cambiar visibilidad de un proyecto (AJAX)
     */
    public function cambiarVisibilidad($id)
    {
        $redirect = $this->verificarAdmin();
        if ($redirect) return $redirect;
        
        $nuevaVisibilidad = $this->request->getPost('visibilidad');
        
        if (!in_array($nuevaVisibilidad, ['privado', 'autenticado', 'publico'])) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['success' => false, 'message' => 'Visibilidad inválida']);
            }
            return redirect()->back()->with('error', 'Visibilidad inválida');
        }
        
        if ($this->proyectoModel->cambiarVisibilidad($id, $nuevaVisibilidad)) {
            $mensaje = 'Visibilidad cambiada a: ' . ucfirst($nuevaVisibilidad);
            
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['success' => true, 'message' => $mensaje]);
            }
            return redirect()->back()->with('success', $mensaje);
        }
        
        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Error al cambiar visibilidad']);
        }
        return redirect()->back()->with('error', 'Error al cambiar visibilidad');
    }
    
    /**
     * Eliminar proyecto
     */
    public function eliminar($id)
    {
        $redirect = $this->verificarAdmin();
        if ($redirect) return $redirect;
        
        $proyecto = $this->proyectoModel->getProyectoCompleto($id);
        
        if (!$proyecto) {
            return redirect()->to('/proyectos')->with('error', 'Proyecto no encontrado');
        }
        
        // Eliminar imagen principal
        if ($proyecto['imagen_principal']) {
            $ruta = WRITEPATH . '../public/uploads/proyectos/' . $proyecto['imagen_principal'];
            if (file_exists($ruta)) {
                unlink($ruta);
            }
        }
        
        // Eliminar imágenes de secciones
        foreach ($proyecto['secciones'] as $seccion) {
            if ($seccion['tipo_media'] == 'imagen' && $seccion['media_url']) {
                $ruta = WRITEPATH . '../public/uploads/proyectos/secciones/' . $seccion['media_url'];
                if (file_exists($ruta)) {
                    unlink($ruta);
                }
            }
        }
        
        // Eliminar imágenes de galería
        foreach ($proyecto['galeria'] as $imagen) {
            $ruta = WRITEPATH . '../public/uploads/proyectos/galeria/' . $imagen['imagen'];
            if (file_exists($ruta)) {
                unlink($ruta);
            }
        }
        
        // Eliminar proyecto (CASCADE elimina secciones y galería)
        $this->proyectoModel->delete($id);
        
        return redirect()->to('/proyectos')->with('success', 'Proyecto eliminado correctamente');
    }
    
    /**
     * Eliminar imagen de galería (AJAX)
     */
    public function eliminarImagenGaleria($id)
    {
        $redirect = $this->verificarAdmin();
        if ($redirect) {
            return $this->response->setJSON(['success' => false, 'message' => 'No autorizado']);
        }
        
        $imagen = $this->galeriaModel->find($id);
        
        if (!$imagen) {
            return $this->response->setJSON(['success' => false, 'message' => 'Imagen no encontrada']);
        }
        
        // Eliminar archivo físico
        $ruta = WRITEPATH . '../public/uploads/proyectos/galeria/' . $imagen['imagen'];
        if (file_exists($ruta)) {
            unlink($ruta);
        }
        
        // Eliminar registro
        $this->galeriaModel->delete($id);
        
        return $this->response->setJSON(['success' => true, 'message' => 'Imagen eliminada']);
    }
    
    /**
     * Eliminar sección (AJAX)
     */
    public function eliminarSeccion($id)
    {
        $redirect = $this->verificarAdmin();
        if ($redirect) {
            return $this->response->setJSON(['success' => false, 'message' => 'No autorizado']);
        }
        
        $seccion = $this->seccionModel->find($id);
        
        if (!$seccion) {
            return $this->response->setJSON(['success' => false, 'message' => 'Sección no encontrada']);
        }
        
        // Eliminar imagen si existe
        if ($seccion['tipo_media'] == 'imagen' && $seccion['media_url']) {
            $ruta = WRITEPATH . '../public/uploads/proyectos/secciones/' . $seccion['media_url'];
            if (file_exists($ruta)) {
                unlink($ruta);
            }
        }
        
        // Eliminar registro
        $this->seccionModel->delete($id);
        
        return $this->response->setJSON(['success' => true, 'message' => 'Sección eliminada']);
    }
    
    /**
     * Subir imagen desde TinyMCE (AJAX)
     */
    public function subirImagenTinymce()
    {
        if (!session()->has('usuario_id') || session()->get('usuario_rol') != 'admin') {
            return $this->response->setJSON(['error' => 'No autorizado'])->setStatusCode(403);
        }
        
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['error' => 'Petición inválida'])->setStatusCode(400);
        }
        
        $validation = \Config\Services::validation();
        
        $rules = [
            'file' => 'uploaded[file]|max_size[file,5120]|is_image[file]'
        ];
        
        if (!$this->validate($rules)) {
            $errors = $this->validator->getErrors();
            return $this->response->setJSON(['error' => implode(', ', $errors)])->setStatusCode(400);
        }
        
        $file = $this->request->getFile('file');
        
        if (!$file || !$file->isValid() || $file->hasMoved()) {
            return $this->response->setJSON(['error' => 'Archivo inválido'])->setStatusCode(400);
        }
        
        try {
            $uploadPath = WRITEPATH . '../public/uploads/tinymce';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            $newName = $file->getRandomName();
            
            if ($file->move($uploadPath, $newName)) {
                return $this->response->setJSON([
                    'location' => base_url('uploads/tinymce/' . $newName)
                ]);
            } else {
                return $this->response->setJSON(['error' => 'No se pudo guardar'])->setStatusCode(500);
            }
            
        } catch (\Exception $e) {
            log_message('error', 'Error subiendo imagen TinyMCE: ' . $e->getMessage());
            return $this->response->setJSON(['error' => 'Error: ' . $e->getMessage()])->setStatusCode(500);
        }
    }
    
    // ========== MÉTODOS AUXILIARES PRIVADOS ==========
    
    /**
     * Guardar secciones de contenido
     */
    private function guardarSecciones($proyectoId)
    {
        $secciones = $this->request->getPost('secciones');
        
        if (!$secciones || !is_array($secciones)) {
            return;
        }
        
        $orden = 1;
        foreach ($secciones as $seccion) {
            $tipoMedia = $seccion['tipo_media'] ?? 'imagen';
            $mediaUrl = null;
            
            if ($tipoMedia == 'imagen' && isset($seccion['media_file'])) {
                $file = $this->request->getFile('secciones.' . ($orden - 1) . '.media_file');
                
                if ($file && $file->isValid()) {
                    $mediaUrl = $file->getRandomName();
                    $file->move(WRITEPATH . '../public/uploads/proyectos/secciones', $mediaUrl);
                }
            } elseif ($tipoMedia == 'video') {
                $mediaUrl = $seccion['media_url'] ?? null;
            }
            
            $data = [
                'proyecto_id' => $proyectoId,
                'titulo' => $seccion['titulo'] ?? '',
                'tipo_media' => $tipoMedia,
                'media_url' => $mediaUrl,
                'contenido' => $seccion['contenido'] ?? '',
                'orden' => $orden++
            ];
            
            $this->seccionModel->insert($data);
        }
    }
    
    /**
     * Actualizar secciones de contenido
     */
    private function actualizarSecciones($proyectoId)
    {
        $seccionesIds = $this->request->getPost('secciones_ids') ?? [];
        
        // Eliminar secciones que no están en el array de IDs mantenidos
        $seccionesActuales = $this->seccionModel->getSecciones($proyectoId);
        foreach ($seccionesActuales as $seccionActual) {
            if (!in_array($seccionActual['id'], $seccionesIds)) {
                // Eliminar imagen si existe
                if ($seccionActual['tipo_media'] == 'imagen' && $seccionActual['media_url']) {
                    $rutaImagen = WRITEPATH . '../public/uploads/proyectos/secciones/' . $seccionActual['media_url'];
                    if (file_exists($rutaImagen)) {
                        unlink($rutaImagen);
                    }
                }
                $this->seccionModel->delete($seccionActual['id']);
            }
        }
        
        $secciones = $this->request->getPost('secciones') ?? [];
        $orden = 1;
        
        foreach ($secciones as $index => $seccion) {
            // Obtener datos de la sección
            $seccionId = $seccion['id'] ?? null;
            $tipoMedia = $seccion['tipo_media'] ?? 'imagen';
            $mediaUrlActual = $seccion['media_url_actual'] ?? null;
            $mediaUrl = null;
            
            // Obtener archivo si se subió uno nuevo
            $file = $this->request->getFile('secciones.' . $index . '.media_file');
            
            if ($tipoMedia == 'imagen') {
                // Si se subió un nuevo archivo
                if ($file && $file->isValid() && !$file->hasMoved()) {
                    // Eliminar imagen anterior si existe
                    if ($mediaUrlActual) {
                        $rutaAntigua = WRITEPATH . '../public/uploads/proyectos/secciones/' . $mediaUrlActual;
                        if (file_exists($rutaAntigua)) {
                            unlink($rutaAntigua);
                        }
                    }
                    
                    // Subir nueva imagen
                    $mediaUrl = $file->getRandomName();
                    $file->move(WRITEPATH . '../public/uploads/proyectos/secciones', $mediaUrl);
                } else {
                    // Mantener imagen actual si existe
                    $mediaUrl = $mediaUrlActual;
                }
            } elseif ($tipoMedia == 'video') {
                // Para videos, usar la URL proporcionada
                $mediaUrl = $seccion['media_url'] ?? '';
                
                // Si había una imagen anterior (cambio de imagen a video), eliminarla
                if ($seccionId && $mediaUrlActual) {
                    $rutaAntigua = WRITEPATH . '../public/uploads/proyectos/secciones/' . $mediaUrlActual;
                    if (file_exists($rutaAntigua)) {
                        unlink($rutaAntigua);
                    }
                }
            }
            
            $data = [
                'proyecto_id' => $proyectoId,
                'titulo' => $seccion['titulo'] ?? '',
                'tipo_media' => $tipoMedia,
                'media_url' => $mediaUrl,
                'contenido' => $seccion['contenido'] ?? '',
                'orden' => $orden++
            ];
            
            if ($seccionId) {
                // Actualizar sección existente
                $this->seccionModel->update($seccionId, $data);
            } else {
                // Insertar nueva sección
                $this->seccionModel->insert($data);
            }
        }
    }
    
    /**
     * Guardar galería de imágenes
     */
    private function guardarGaleria($proyectoId)
    {
        $galeria = $this->request->getFileMultiple('galeria');
        
        if (!$galeria) {
            return;
        }
        
        foreach ($galeria as $imagen) {
            if ($imagen->isValid() && !$imagen->hasMoved()) {
                $nombreImagen = $imagen->getRandomName();
                $imagen->move(WRITEPATH . '../public/uploads/proyectos/galeria', $nombreImagen);
                
                $this->galeriaModel->insert([
                    'proyecto_id' => $proyectoId,
                    'imagen' => $nombreImagen
                ]);
            }
        }
    }
    
    /**
     * Actualizar galería de imágenes (solo agregar nuevas)
     */
    private function actualizarGaleria($proyectoId)
    {
        $this->guardarGaleria($proyectoId);
    }
    
    /**
     * Actualizar orden de proyectos (AJAX)
     */
    public function actualizarOrden()
    {
        $redirect = $this->verificarAdmin();
        if ($redirect) return $redirect;
        
        // Verificar que sea una petición AJAX
        if (!$this->request->isAJAX() && !$this->request->getHeaderLine('X-Requested-With')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Solicitud inválida']);
        }
        
        // Leer datos del POST
        $ordenes = $this->request->getPost('ordenes');
        
        // Si no viene como array directo, intentar leer como JSON
        if (!$ordenes || !is_array($ordenes)) {
            $json = $this->request->getJSON(true);
            if ($json && isset($json['ordenes'])) {
                $ordenes = $json['ordenes'];
            }
        }
        
        // Validar datos
        if (empty($ordenes) || !is_array($ordenes)) {
            log_message('error', 'Datos inválidos en actualizarOrden. POST completo: ' . json_encode($this->request->getPost()));
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Datos inválidos. No se recibieron órdenes válidos.',
                'debug' => [
                    'post_ordenes' => $this->request->getPost('ordenes'),
                    'post_completo' => $this->request->getPost()
                ]
            ]);
        }
        
        // Validar que todos los valores sean numéricos
        foreach ($ordenes as $proyectoId => $orden) {
            if (!is_numeric($proyectoId) || !is_numeric($orden)) {
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Los IDs y órdenes deben ser numéricos'
                ]);
            }
        }
        
        try {
            $this->proyectoModel->actualizarOrden($ordenes);
            return $this->response->setJSON(['success' => true, 'message' => 'Orden actualizado correctamente']);
        } catch (\Exception $e) {
            log_message('error', 'Error al actualizar orden: ' . $e->getMessage());
            log_message('error', 'Stack trace: ' . $e->getTraceAsString());
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Error al actualizar el orden: ' . $e->getMessage()
            ]);
        }
    }
}

