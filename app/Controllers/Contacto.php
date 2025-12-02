<?php

namespace App\Controllers;

use App\Models\ContactoModel;

class Contacto extends BaseController
{
    protected $contactoModel;

    public function __construct()
    {
        $this->contactoModel = new ContactoModel();
        helper(['form', 'url']);
    }

    /**
     * Mostrar formulario de contacto público
     * GET /contacto
     */
    public function formulario()
    {
        return view('contacto/formulario');
    }

    /**
     * API: Enviar mensaje de contacto (Público)
     * POST /api/contacto/enviar
     */
    public function enviar()
    {
        // Verificar método
       if (strtolower($this->request->getMethod()) !== 'post') {
    return $this->response->setJSON([
        'status' => 'error',
        'message' => 'Método no permitido'
    ])->setStatusCode(405);
}

// Opcional: Solo aceptar peticiones AJAX
if (!$this->request->isAJAX()) {
    return $this->response->setJSON([
        'status' => 'error',
        'message' => 'Solo se aceptan peticiones AJAX'
    ])->setStatusCode(400);
}

        // Obtener datos del request
        $data = [
            'nombre'   => $this->request->getPost('nombre'),
            'email'    => $this->request->getPost('email'),
            'telefono' => $this->request->getPost('telefono'),
            'mensaje'  => $this->request->getPost('mensaje'),
            'ip_address' => $this->request->getIPAddress(),
            'user_agent' => $this->request->getUserAgent()->getAgentString()
        ];

        // Validar datos
        if (!$this->contactoModel->validate($data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Errores de validación',
                'errors' => $this->contactoModel->errors()
            ])->setStatusCode(400);
        }

        // Guardar en base de datos
        try {
            $contactoId = $this->contactoModel->insert($data);

            if (!$contactoId) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'No se pudo guardar el mensaje'
                ])->setStatusCode(500);
            }

            // Enviar email de notificación al admin
            $this->enviarEmailNotificacion($data, $contactoId);

            // Enviar email de confirmación al usuario
            $this->enviarEmailConfirmacion($data);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => '¡Gracias por contactarnos! Te responderemos pronto.',
                'data' => [
                    'id' => $contactoId
                ]
            ])->setStatusCode(201);

        } catch (\Exception $e) {
            log_message('error', 'Error al guardar contacto: ' . $e->getMessage());
            
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error al procesar tu mensaje. Por favor, inténtalo de nuevo.'
            ])->setStatusCode(500);
        }
    }

    /**
     * Enviar email de notificación al administrador
     * 
     * @param array $data Datos del contacto
     * @param int $contactoId ID del contacto guardado
     */
    private function enviarEmailNotificacion($data, $contactoId)
    {
        try {
            $email = \Config\Services::email();

            $email->setFrom(getenv('email.fromEmail'), getenv('email.fromName'));
            $email->setTo('admin@admin.com'); // Cambiar por el email del admin
            $email->setSubject('Nuevo mensaje de contacto - Portfolio');

            $mensaje = "Has recibido un nuevo mensaje de contacto:\n\n";
            $mensaje .= "ID: #" . $contactoId . "\n";
            $mensaje .= "Nombre: " . $data['nombre'] . "\n";
            $mensaje .= "Email: " . $data['email'] . "\n";
            $mensaje .= "Teléfono: " . ($data['telefono'] ?: 'No proporcionado') . "\n\n";
            $mensaje .= "Mensaje:\n" . $data['mensaje'] . "\n\n";
            $mensaje .= "---\n";
            $mensaje .= "IP: " . $data['ip_address'] . "\n";
            $mensaje .= "Fecha: " . date('d/m/Y H:i:s') . "\n";

            $email->setMessage($mensaje);

            $email->send();

        } catch (\Exception $e) {
            log_message('error', 'Error al enviar email de notificación: ' . $e->getMessage());
        }
    }

    /**
     * Enviar email de confirmación al usuario
     * 
     * @param array $data Datos del contacto
     */
    private function enviarEmailConfirmacion($data)
    {
        try {
            $email = \Config\Services::email();

            $email->setFrom(getenv('email.fromEmail'), getenv('email.fromName'));
            $email->setTo($data['email']);
            $email->setSubject('Hemos recibido tu mensaje - ' . getenv('email.fromName'));

            $mensaje = "Hola " . $data['nombre'] . ",\n\n";
            $mensaje .= "Gracias por ponerte en contacto con nosotros.\n\n";
            $mensaje .= "Hemos recibido tu mensaje y te responderemos lo antes posible.\n\n";
            $mensaje .= "Tu mensaje:\n";
            $mensaje .= "---\n";
            $mensaje .= $data['mensaje'] . "\n";
            $mensaje .= "---\n\n";
            $mensaje .= "Saludos,\n";
            $mensaje .= getenv('email.fromName');

            $email->setMessage($mensaje);

            $email->send();

        } catch (\Exception $e) {
            log_message('error', 'Error al enviar email de confirmación: ' . $e->getMessage());
        }
    }

    // ========================================
    // MÉTODOS ADMIN (requieren autenticación)
    // ========================================

    /**
     * Admin: Listar todos los contactos
     * GET /admin/contactos
     */
    public function index()
    {
        // Verificar autenticación admin
        if (!session()->has('usuario_id') || session()->get('usuario_rol') != 'admin') {
            return redirect()->to('/auth/login')->with('error', 'Acceso denegado');
        }

        $data['contactos'] = $this->contactoModel->getContactos();
        $data['estadisticas'] = $this->contactoModel->getEstadisticas();
        $data['titulo'] = 'Mensajes de Contacto';

        return view('admin/contactos/index', $data);
    }

    /**
     * Admin: Ver detalle de un contacto
     * GET /admin/contactos/ver/{id}
     */
    public function ver($id)
    {
        // Verificar autenticación admin
        if (!session()->has('usuario_id') || session()->get('usuario_rol') != 'admin') {
            return redirect()->to('/auth/login')->with('error', 'Acceso denegado');
        }

        $contacto = $this->contactoModel->find($id);

        if (!$contacto) {
            return redirect()->to('/admin/contactos')->with('error', 'Contacto no encontrado');
        }

        // Marcar como leído
        $this->contactoModel->marcarComoLeido($id);

        $data['contacto'] = $contacto;
        $data['titulo'] = 'Detalle de Contacto #' . $id;

        return view('admin/contactos/ver', $data);
    }

    /**
     * Admin: Eliminar contacto
     * GET /admin/contactos/eliminar/{id}
     */
    public function eliminar($id)
    {
        // Verificar autenticación admin
        if (!session()->has('usuario_id') || session()->get('usuario_rol') != 'admin') {
            return redirect()->to('/auth/login')->with('error', 'Acceso denegado');
        }

        if ($this->contactoModel->delete($id)) {
            return redirect()->to('/admin/contactos')->with('success', 'Contacto eliminado correctamente');
        }

        return redirect()->to('/admin/contactos')->with('error', 'No se pudo eliminar el contacto');
    }

    /**
     * Admin: Marcar como respondido (AJAX)
     * POST /admin/contactos/marcarRespondido/{id}
     */
    public function marcarRespondido($id)
    {
        // Verificar autenticación admin
        if (!session()->has('usuario_id') || session()->get('usuario_rol') != 'admin') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'No autorizado'
            ])->setStatusCode(401);
        }

        if ($this->contactoModel->marcarComoRespondido($id)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Marcado como respondido'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Error al actualizar'
        ])->setStatusCode(500);
    }
}
