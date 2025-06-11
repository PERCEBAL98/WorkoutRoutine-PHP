<?php
namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class DeportistaModel extends Model {
    protected $table = 'deportistas';
    protected $allowedFields = ['nombre', 'email', 'contraseña', 'avatar', 'plan', 'id_rol', 'created_at', 'updated_at'];

    public function obtenerUsuarioLogin($usuario) 
    {
        return $this->join('roles', 'deportistas.id_rol = roles.id')
            ->select('deportistas.id, deportistas.nombre, deportistas.contraseña, deportistas.email, deportistas.avatar, deportistas.plan, deportistas.id_rol, roles.nombre AS rol_nombre')
            ->where('deportistas.nombre', $usuario)
            ->orWhere('deportistas.email', $usuario)
            ->orderBy('deportistas.id', 'DESC')->first();
    }
}
?>