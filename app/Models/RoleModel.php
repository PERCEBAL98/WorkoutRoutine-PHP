<?php
namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class RoleModel extends Model {
    protected $table = 'roles';
    protected $allowedFields = ['nombre', 'created_at', 'updated_at'];
}
?>