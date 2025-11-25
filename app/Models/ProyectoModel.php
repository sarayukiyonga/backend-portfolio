<?php

namespace App\Models;

use CodeIgniter\Model;

class ProyectoModel extends Model
{
    protected $table = 'proyectos';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nombre', 
        'imagen_principal', 
        'descripcion', 
        'caso_estudio', 
        'cliente', 
        'anio', 
        'orden', 
        'activo',
        'estado',        // NUEVO
        'visibilidad'    // NUEVO
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    /**
     * Obtener proyecto completo con secciones y galería
     */
    public function getProyectoCompleto($id)
    {
        $proyecto = $this->find($id);
        
        if (!$proyecto) {
            return null;
        }
        
        $seccionModel = new ProyectoSeccionModel();
        $galeriaModel = new ProyectoGaleriaModel();
        
        $proyecto['secciones'] = $seccionModel->getSecciones($id);
        $proyecto['galeria'] = $galeriaModel->getGaleria($id);
        
        return $proyecto;
    }
    
    /**
     * Listar TODOS los proyectos (solo para admin)
     */
    public function listarTodosProyectos()
    {
        return $this->orderBy('created_at', 'DESC')->findAll();
    }
    
    /**
     * Listar proyectos PUBLICADOS con visibilidad AUTENTICADO o PÚBLICO
     * Para visitantes logueados
     */
    public function listarProyectosAutenticados()
    {
        return $this->where('estado', 'publicado')
                    ->whereIn('visibilidad', ['autenticado', 'publico'])
                    ->orderBy('orden', 'ASC')
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
    
    /**
     * Listar proyectos PUBLICADOS con visibilidad PÚBLICA
     * Para el frontend sin autenticación
     */
    public function listarProyectosPublicos()
    {
        return $this->where('estado', 'publicado')
                    ->where('visibilidad', 'publico')
                    ->orderBy('orden', 'ASC')
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
    
    /**
     * Listar proyectos por estado (para admin)
     */
    public function listarPorEstado($estado)
    {
        return $this->where('estado', $estado)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
    
    /**
     * Listar proyectos por visibilidad (para admin)
     */
    public function listarPorVisibilidad($visibilidad)
    {
        return $this->where('visibilidad', $visibilidad)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
    
    /**
     * Contar proyectos por estado
     */
    public function contarPorEstado()
    {
        return [
            'borrador' => $this->where('estado', 'borrador')->countAllResults(),
            'publicado' => $this->where('estado', 'publicado')->countAllResults(),
            'archivado' => $this->where('estado', 'archivado')->countAllResults()
        ];
    }
    
    /**
     * Contar proyectos por visibilidad
     */
    public function contarPorVisibilidad()
    {
        return [
            'privado' => $this->where('visibilidad', 'privado')->countAllResults(),
            'autenticado' => $this->where('visibilidad', 'autenticado')->countAllResults(),
            'publico' => $this->where('visibilidad', 'publico')->countAllResults()
        ];
    }
    
    /**
     * Cambiar estado de un proyecto
     */
    public function cambiarEstado($id, $nuevoEstado)
    {
        if (!in_array($nuevoEstado, ['borrador', 'publicado', 'archivado'])) {
            return false;
        }
        
        return $this->update($id, ['estado' => $nuevoEstado]);
    }
    
    /**
     * Cambiar visibilidad de un proyecto
     */
    public function cambiarVisibilidad($id, $nuevaVisibilidad)
    {
        if (!in_array($nuevaVisibilidad, ['privado', 'autenticado', 'publico'])) {
            return false;
        }
        
        return $this->update($id, ['visibilidad' => $nuevaVisibilidad]);
    }
    
    /**
     * Verificar si un proyecto puede ser visto por un usuario
     */
    public function puedeVer($proyectoId, $usuarioRol = null, $estaAutenticado = false)
    {
        $proyecto = $this->find($proyectoId);
        
        if (!$proyecto) {
            return false;
        }
        
        // Admin puede ver todo
        if ($usuarioRol === 'admin') {
            return true;
        }
        
        // Solo proyectos publicados pueden verse
        if ($proyecto['estado'] !== 'publicado') {
            return false;
        }
        
        // Verificar visibilidad
        switch ($proyecto['visibilidad']) {
            case 'privado':
                // Solo admin (ya verificado arriba)
                return false;
                
            case 'autenticado':
                // Requiere estar logueado
                return $estaAutenticado;
                
            case 'publico':
                // Cualquiera puede ver
                return true;
                
            default:
                return false;
        }
    }
    
    /**
     * MANTENER COMPATIBILIDAD - Método antiguo
     * @deprecated Usar listarProyectosAutenticados() o listarProyectosPublicos()
     */
    public function listarProyectosActivos()
    {
        // Por compatibilidad, retorna proyectos publicados y autenticados/públicos
        return $this->listarProyectosAutenticados();
    }
}
