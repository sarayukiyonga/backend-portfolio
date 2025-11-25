<?php

namespace App\Models;

use CodeIgniter\Model;

class ProyectoSeccionModel extends Model
{
    protected $table = 'proyecto_secciones';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'proyecto_id',
        'tipo_media',
        'media_url',
        'contenido',
        'orden'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    // Obtener secciones de un proyecto
    public function getSecciones($proyectoId)
    {
        return $this->where('proyecto_id', $proyectoId)
                    ->orderBy('orden', 'ASC')
                    ->findAll();
    }
    
    // Eliminar secciones de un proyecto
    public function eliminarSeccionesProyecto($proyectoId)
    {
        return $this->where('proyecto_id', $proyectoId)->delete();
    }
    
    // Obtener el siguiente orden
    public function getSiguienteOrden($proyectoId)
    {
        $result = $this->selectMax('orden')
                       ->where('proyecto_id', $proyectoId)
                       ->first();
        
        return ($result['orden'] ?? 0) + 1;
    }
}
