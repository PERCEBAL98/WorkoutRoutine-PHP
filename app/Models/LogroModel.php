<?php
namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class LogroModel extends Model {
    protected $table = 'logros';
    protected $allowedFields = ['nombre', 'nivel', 'puntos', 'created_at', 'updated_at'];

    public function cargarLogrosAgrupados($id_usuario)
    {
        return $this->select('
                deportistas_logros.id_logro, 
                deportistas_logros.puntos AS puntos_actuales,
                deportistas_logros.completado,
                logros.nombre AS nombre_logro,
                logros.nivel AS nivel_logro,
                logros.puntos AS puntos_maximos
            ')
            ->join('logros', 'logros.id = deportistas_logros.id_logro', 'inner')
            ->where('deportistas_logros.id_deportista', $id_usuario)
            ->orderBy('logros.id', 'ASC') // Si lo deseas, puedes ordenar los logros por su ID
            ->findAll();
    }
}
?>