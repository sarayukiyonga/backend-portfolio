<?php

namespace App\Controllers;

use App\Models\RecursoModel;

class Recursos extends BaseController
{
    protected $recursoModel;
    
    public function __construct()
    {
        $this->recursoModel = new RecursoModel();
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
    
    // ========== MÉTODOS PARA VISITANTES ==========
    
    /**
     * Ver recursos disponibles (visitantes)
     */
    public function index()
    {
        // Verificar autenticación
        if (!session()->has('usuario_id')) {
            return redirect()->to('/auth/login');
        }
        
        $usuarioRol = session()->get('usuario_rol');
        
        // Admin ve todo, visitantes solo lo permitido
        if ($usuarioRol == 'admin') {
            $recursos = $this->recursoModel->getRecursosActivos('admin');
        } else {
            $recursos = $this->recursoModel->getRecursosActivos('solo_visitantes');
        }
        
        $data = [
            'titulo' => 'Recursos y Documentos',
            'recursos' => $recursos,
            'esAdmin' => $usuarioRol == 'admin'
        ];
        
        return view('recursos/index', $data);
    }
    
    /**
     * Descargar recurso
     */
    public function descargar($id)
    {
        // Verificar autenticación
        if (!session()->has('usuario_id')) {
            return redirect()->to('/auth/login');
        }
        
        $recurso = $this->recursoModel->find($id);
        
        if (!$recurso) {
            return redirect()->back()->with('error', 'Recurso no encontrado');
        }
        
        // Verificar permisos
        $usuarioRol = session()->get('usuario_rol');
        
        if ($usuarioRol != 'admin') {
            if ($recurso['visible_para'] == 'solo_admin' || $recurso['activo'] == 0) {
                return redirect()->back()->with('error', 'No tienes permiso para descargar este recurso');
            }
        }
        
        $rutaArchivo = WRITEPATH . '../public/uploads/recursos/' . $recurso['archivo'];
        
        if (!file_exists($rutaArchivo)) {
            return redirect()->back()->with('error', 'Archivo no encontrado');
        }
        
        // Incrementar contador
        $this->recursoModel->incrementarDescarga($id);
        
        // Descargar archivo
        return $this->response->download($rutaArchivo, null);
    }
    
    /**
     * Previsualizar PDF
     */
    public function previsualizar($id)
    {
        // Verificar autenticación
        if (!session()->has('usuario_id')) {
            return redirect()->to('/auth/login');
        }
        
        $recurso = $this->recursoModel->find($id);
        
        if (!$recurso || $recurso['tipo'] != 'pdf') {
            return redirect()->back()->with('error', 'Recurso no disponible');
        }
        
        // Verificar permisos
        $usuarioRol = session()->get('usuario_rol');
        
        if ($usuarioRol != 'admin') {
            if ($recurso['visible_para'] == 'solo_admin' || $recurso['activo'] == 0) {
                return redirect()->back()->with('error', 'No tienes permiso');
            }
        }
        
        $data = [
            'titulo' => $recurso['titulo'],
            'recurso' => $recurso
        ];
        
        return view('recursos/previsualizar', $data);
    }
    
    // ========== MÉTODOS ADMIN ==========
    
    /**
     * Panel de gestión (Admin)
     */
    public function admin()
    {
        $redirect = $this->verificarAdmin();
        if ($redirect) return $redirect;
        
        $recursos = $this->recursoModel->getTodosRecursos();
        $estadisticas = $this->recursoModel->getEstadisticas();
        
        $data = [
            'titulo' => 'Gestión de Recursos',
            'recursos' => $recursos,
            'estadisticas' => $estadisticas
        ];
        
        return view('recursos/admin', $data);
    }
    
    /**
     * Crear recurso - formulario
     */
    public function crear()
    {
        $redirect = $this->verificarAdmin();
        if ($redirect) return $redirect;
        
        $data = [
            'titulo' => 'Subir Nuevo Recurso'
        ];
        
        return view('recursos/crear', $data);
    }
    
    /**
     * Guardar recurso
     */
    public function guardar()
    {
        $redirect = $this->verificarAdmin();
        if ($redirect) return $redirect;
        
        $validation = \Config\Services::validation();
        
        $rules = [
            'titulo' => 'required|min_length[3]',
            'tipo' => 'required|in_list[pdf,documento,imagen,otro]',
            'visible_para' => 'required|in_list[todos,solo_visitantes,solo_admin]',
            'archivo' => 'uploaded[archivo]|max_size[archivo,10240]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        // Subir archivo
        $archivo = $this->request->getFile('archivo');
        $nombreArchivo = $archivo->getRandomName();
        
        $uploadPath = WRITEPATH . '../public/uploads/recursos';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }
        
        $archivo->move($uploadPath, $nombreArchivo);
        
        // Guardar en BD
        $data = [
            'titulo' => $this->request->getPost('titulo'),
            'descripcion' => $this->request->getPost('descripcion'),
            'tipo' => $this->request->getPost('tipo'),
            'archivo' => $nombreArchivo,
            'tamanio' => $archivo->getSize(),
            'icono' => $this->request->getPost('icono') ?: '📄',
            'visible_para' => $this->request->getPost('visible_para'),
            'activo' => $this->request->getPost('activo') ? 1 : 0,
            'orden' => $this->request->getPost('orden') ?: 0
        ];
        
        $this->recursoModel->insert($data);
        
        return redirect()->to('/recursos/admin')->with('success', 'Recurso subido correctamente');
    }
    
    /**
     * Editar recurso - formulario
     */
    public function editar($id)
    {
        $redirect = $this->verificarAdmin();
        if ($redirect) return $redirect;
        
        $recurso = $this->recursoModel->find($id);
        
        if (!$recurso) {
            return redirect()->to('/recursos/admin')->with('error', 'Recurso no encontrado');
        }
        
        $data = [
            'titulo' => 'Editar Recurso',
            'recurso' => $recurso
        ];
        
        return view('recursos/editar', $data);
    }
    
    /**
     * Actualizar recurso
     */
    public function actualizar($id)
    {
        $redirect = $this->verificarAdmin();
        if ($redirect) return $redirect;
        
        $recurso = $this->recursoModel->find($id);
        
        if (!$recurso) {
            return redirect()->to('/recursos/admin')->with('error', 'Recurso no encontrado');
        }
        
        $validation = \Config\Services::validation();
        
        $rules = [
            'titulo' => 'required|min_length[3]',
            'tipo' => 'required|in_list[pdf,documento,imagen,otro]',
            'visible_para' => 'required|in_list[todos,solo_visitantes,solo_admin]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $data = [
            'titulo' => $this->request->getPost('titulo'),
            'descripcion' => $this->request->getPost('descripcion'),
            'tipo' => $this->request->getPost('tipo'),
            'icono' => $this->request->getPost('icono') ?: '📄',
            'visible_para' => $this->request->getPost('visible_para'),
            'activo' => $this->request->getPost('activo') ? 1 : 0,
            'orden' => $this->request->getPost('orden') ?: 0
        ];
        
        // Si se subió nuevo archivo
        $archivo = $this->request->getFile('archivo');
        if ($archivo && $archivo->isValid() && !$archivo->hasMoved()) {
            // Eliminar archivo anterior
            $rutaAntigua = WRITEPATH . '../public/uploads/recursos/' . $recurso['archivo'];
            if (file_exists($rutaAntigua)) {
                unlink($rutaAntigua);
            }
            
            // Subir nuevo
            $nombreArchivo = $archivo->getRandomName();
            $archivo->move(WRITEPATH . '../public/uploads/recursos', $nombreArchivo);
            
            $data['archivo'] = $nombreArchivo;
            $data['tamanio'] = $archivo->getSize();
        }
        
        $this->recursoModel->update($id, $data);
        
        return redirect()->to('/recursos/admin')->with('success', 'Recurso actualizado correctamente');
    }
    
    /**
     * Eliminar recurso
     */
    public function eliminar($id)
    {
        $redirect = $this->verificarAdmin();
        if ($redirect) return $redirect;
        
        $recurso = $this->recursoModel->find($id);
        
        if (!$recurso) {
            return redirect()->to('/recursos/admin')->with('error', 'Recurso no encontrado');
        }
        
        // Eliminar archivo físico
        $rutaArchivo = WRITEPATH . '../public/uploads/recursos/' . $recurso['archivo'];
        if (file_exists($rutaArchivo)) {
            unlink($rutaArchivo);
        }
        
        // Eliminar registro
        $this->recursoModel->delete($id);
        
        return redirect()->to('/recursos/admin')->with('success', 'Recurso eliminado correctamente');
    }
    
    /**
     * Cambiar estado (AJAX)
     */
    public function cambiarEstado($id)
    {
        $redirect = $this->verificarAdmin();
        if ($redirect) {
            return $this->response->setJSON(['success' => false, 'message' => 'No autorizado']);
        }
        
        $activo = $this->request->getPost('activo');
        
        if ($this->recursoModel->cambiarEstado($id, $activo)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Estado actualizado']);
        }
        
        return $this->response->setJSON(['success' => false, 'message' => 'Error al actualizar']);
    }
}
