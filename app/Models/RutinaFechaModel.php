<?php
namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class RutinaFechaModel extends Model {
    protected $table = 'rutinas_fechas';
    protected $allowedFields = ['id_rutina', 'fecha', 'realizado', 'created_at', 'updated_at'];
}
?>