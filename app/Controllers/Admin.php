<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\RolModel;
use App\Models\ProyectoModel;

class Admin extends BaseController
{
    protected $usuarioModel;
    protected $rolModel;
    protected $proyectoModel;
    
    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->rolModel = new RolModel();
        $this->proyectoModel = new ProyectoModel();
        helper(['form', 'url']);
    }
    
    // Verificar que el usuario sea admin
    private function verificarAdmin()
    {
        if (!session()->has('usuario_id') || session()->get('usuario_rol') != 'admin') {
            return redirect()->to('/auth/login')->with('error', 'Acceso denegado. Solo administradores.');
        }
        return null;
    }
    
    // Dashboard del admin CON ESTADÍSTICAS DE PROYECTOS
    public function dashboard()
    {
        $redirect = $this->verificarAdmin();
        if ($redirect) return $redirect;
        
        $usuarios = $this->usuarioModel->listarUsuarios();
        
        // Contar usuarios pendientes de aprobación
        $pendientes = array_filter($usuarios, function($u) {
            return $u['activo'] == 0;
        });
        
        // ========== ESTADÍSTICAS DE PROYECTOS ==========
        $proyectos = $this->proyectoModel->findAll();
        
        // Proyectos activos
        $proyectosActivos = array_filter($proyectos, function($p) {
            return $p['activo'] == 1;
        });
        
        // Proyectos inactivos
        $proyectosInactivos = array_filter($proyectos, function($p) {
            return $p['activo'] == 0;
        });
        
        // Proyectos del año actual
        $proyectosEsteAnio = array_filter($proyectos, function($p) {
            return $p['anio'] == date('Y');
        });
        
        // Proyecto más reciente
        $proyectoReciente = null;
        if (!empty($proyectos)) {
            usort($proyectos, function($a, $b) {
                return strtotime($b['created_at']) - strtotime($a['created_at']);
            });
            $proyectoReciente = $proyectos[0];
        }
        
        $data = [
            'titulo' => 'Panel de Administración',
            'usuarios' => $usuarios,
            'pendientes' => count($pendientes),
            
            // Estadísticas de proyectos
            'totalProyectos' => count($proyectos),
            'proyectosActivos' => count($proyectosActivos),
            'proyectosInactivos' => count($proyectosInactivos),
            'proyectosEsteAnio' => count($proyectosEsteAnio),
            'proyectoReciente' => $proyectoReciente
        ];
        
        return view('admin/dashboard', $data);
    }
    
    // ========== RESTO DE MÉTODOS (sin cambios) ==========
    
    public function usuarios()
    {
        $redirect = $this->verificarAdmin();
        if ($redirect) return $redirect;
        
        $usuarios = $this->usuarioModel->listarUsuarios();
        
        $data = [
            'titulo' => 'Gestión de Usuarios',
            'usuarios' => $usuarios
        ];
        
        return view('admin/usuarios', $data);
    }
    
    public function usuariosPendientes()
    {
        $redirect = $this->verificarAdmin();
        if ($redirect) return $redirect;
        
        $usuarios = $this->usuarioModel->listarUsuarios();
        
        $pendientes = array_filter($usuarios, function($u) {
            return $u['activo'] == 0;
        });
        
        $data = [
            'titulo' => 'Usuarios Pendientes de Aprobación',
            'usuarios' => array_values($pendientes)
        ];
        
        return view('admin/usuarios_pendientes', $data);
    }
    
    public function aprobarUsuario($id)
    {
        $redirect = $this->verificarAdmin();
        if ($redirect) return $redirect;
        
        $usuario = $this->usuarioModel->find($id);
        
        if (!$usuario) {
            return redirect()->to('/admin/usuariosPendientes')->with('error', 'Usuario no encontrado.');
        }
        
        $this->usuarioModel->update($id, ['activo' => 1]);
        
        // Enviar email de aprobación
        $this->enviarEmailAprobacion($usuario);
        
        return redirect()->to('/admin/usuariosPendientes')->with('success', 'Usuario aprobado correctamente.');
    }
    
    public function rechazarUsuario($id)
    {
        $redirect = $this->verificarAdmin();
        if ($redirect) return $redirect;
        
        $usuario = $this->usuarioModel->find($id);
        
        if (!$usuario) {
            return redirect()->to('/admin/usuariosPendientes')->with('error', 'Usuario no encontrado.');
        }
        
        // Enviar email de rechazo antes de eliminar
        $this->enviarEmailRechazo($usuario);
        
        $this->usuarioModel->delete($id);
        
        return redirect()->to('/admin/usuariosPendientes')->with('success', 'Usuario rechazado y eliminado.');
    }
    
    // Método para enviar email de aprobación
    private function enviarEmailAprobacion($usuario)
    {
        try {
            $email = \Config\Services::email();
            
            $email->setTo($usuario['email']);
            $email->setSubject('Tu cuenta ha sido aprobada');
            
            $mensaje = view('emails/cuenta_aprobada', ['usuario' => $usuario]);
            $email->setMessage($mensaje);
            
            if ($email->send()) {
                log_message('info', 'Email de aprobación enviado a: ' . $usuario['email']);
            } else {
                log_message('error', 'Error al enviar email de aprobación: ' . $email->printDebugger(['headers']));
            }
        } catch (\Exception $e) {
            log_message('error', 'Excepción al enviar email de aprobación: ' . $e->getMessage());
        }
    }
    
    // Método para enviar email de rechazo
    private function enviarEmailRechazo($usuario)
    {
        try {
            $email = \Config\Services::email();
            
            $email->setTo($usuario['email']);
            $email->setSubject('Actualización sobre tu registro');
            
            $mensaje = view('emails/cuenta_rechazada', ['usuario' => $usuario]);
            $email->setMessage($mensaje);
            
            if ($email->send()) {
                log_message('info', 'Email de rechazo enviado a: ' . $usuario['email']);
            } else {
                log_message('error', 'Error al enviar email de rechazo: ' . $email->printDebugger(['headers']));
            }
        } catch (\Exception $e) {
            log_message('error', 'Excepción al enviar email de rechazo: ' . $e->getMessage());
        }
    }
    
    public function crearUsuario()
    {
        $redirect = $this->verificarAdmin();
        if ($redirect) return $redirect;
        
        $roles = $this->rolModel->findAll();
        
        $data = [
            'titulo' => 'Crear Usuario',
            'roles' => $roles
        ];
        
        return view('admin/crear_usuario', $data);
    }
    
    public function guardarUsuario()
    {
        $redirect = $this->verificarAdmin();
        if ($redirect) return $redirect;
        
        $validation = \Config\Services::validation();
        
        $rules = [
            'nombre' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|is_unique[usuarios.email]',
            'password' => 'required|min_length[6]',
            'rol_id' => 'required|is_natural_no_zero'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'rol_id' => $this->request->getPost('rol_id'),
            'activo' => 1
        ];
        
        $this->usuarioModel->insert($data);
        
        return redirect()->to('/admin/usuarios')->with('success', 'Usuario creado correctamente.');
    }
    
    public function editarUsuario($id)
    {
        $redirect = $this->verificarAdmin();
        if ($redirect) return $redirect;
        
        $usuario = $this->usuarioModel->getUsuarioCompleto($id);
        
        if (!$usuario) {
            return redirect()->to('/admin/usuarios')->with('error', 'Usuario no encontrado.');
        }
        
        $roles = $this->rolModel->findAll();
        
        $data = [
            'titulo' => 'Editar Usuario',
            'usuario' => $usuario,
            'roles' => $roles
        ];
        
        return view('admin/editar_usuario', $data);
    }
    
    public function actualizarUsuario($id)
    {
        $redirect = $this->verificarAdmin();
        if ($redirect) return $redirect;
        
        $usuario = $this->usuarioModel->find($id);
        
        if (!$usuario) {
            return redirect()->to('/admin/usuarios')->with('error', 'Usuario no encontrado.');
        }
        
        $validation = \Config\Services::validation();
        
        $rules = [
            'nombre' => 'required|min_length[3]|max_length[100]',
            'email' => "required|valid_email|is_unique[usuarios.email,id,{$id}]",
            'rol_id' => 'required|is_natural_no_zero'
        ];
        
        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[6]';
        }
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'email' => $this->request->getPost('email'),
            'rol_id' => $this->request->getPost('rol_id')
        ];
        
        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }
        
        $this->usuarioModel->update($id, $data);
        
        return redirect()->to('/admin/usuarios')->with('success', 'Usuario actualizado correctamente.');
    }
    
    public function eliminarUsuario($id)
    {
        $redirect = $this->verificarAdmin();
        if ($redirect) return $redirect;
        
        if ($id == session()->get('usuario_id')) {
            return redirect()->to('/admin/usuarios')->with('error', 'No puedes eliminar tu propia cuenta.');
        }
        
        $usuario = $this->usuarioModel->find($id);
        
        if (!$usuario) {
            return redirect()->to('/admin/usuarios')->with('error', 'Usuario no encontrado.');
        }
        
        $this->usuarioModel->delete($id);
        
        return redirect()->to('/admin/usuarios')->with('success', 'Usuario eliminado correctamente.');
    }
    
    public function cambiarEstado($id)
    {
        $redirect = $this->verificarAdmin();
        if ($redirect) return $redirect;
        
        $usuario = $this->usuarioModel->find($id);
        
        if (!$usuario) {
            return redirect()->to('/admin/usuarios')->with('error', 'Usuario no encontrado.');
        }
        
        $nuevoEstado = $usuario['activo'] == 1 ? 0 : 1;
        $this->usuarioModel->update($id, ['activo' => $nuevoEstado]);
        
        $mensaje = $nuevoEstado == 1 ? 'Usuario activado.' : 'Usuario desactivado.';
        
        return redirect()->to('/admin/usuarios')->with('success', $mensaje);
    }
}