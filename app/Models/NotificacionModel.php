<?php
namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class NotificacionModel extends Model {
    protected $table = 'notificaciones';
    protected $allowedFields = ['id_deportista', 'tipo', 'titulo', 'mensaje', 'imagen', 'leido', 'created_at', 'updated_at'];
}
?>