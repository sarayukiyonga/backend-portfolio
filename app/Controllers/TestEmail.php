<?php

namespace App\Controllers;

class TestEmail extends BaseController
{
    public function index()
    {
        $email = \Config\Services::email();
        
        // CAMBIA ESTO por tu email personal
        $tuEmailPersonal = 'sarayonga@gmail.com';
        
        $email->setTo($tuEmailPersonal);
        $email->setSubject('Prueba CDMON - ' . date('d/m/Y H:i:s'));
        $email->setMessage('
            <h1>¡Funciona!</h1>
            <p>Este email se envió desde info@saraymartinez.com usando CDMON.</p>
            <p>Servidor: smtp.cdmon.net</p>
            <p>Si ves esto, ¡la configuración es correcta! ✅</p>
        ');
        
        if ($email->send()) {
            echo '<h1 style="color: green;">✅ Email enviado correctamente!</h1>';
            echo '<p>Revisa tu bandeja: ' . $tuEmailPersonal . '</p>';
        } else {
            echo '<h1 style="color: red;">❌ Error</h1>';
            echo '<pre>' . $email->printDebugger() . '</pre>';
        }
    }
}