<?php
namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class RutinaEjercicioModel extends Model {
    protected $table = 'rutinas_ejercicios';
    protected $allowedFields = ['id_rutina', 'id_ejercicio', 'orden', 'created_at', 'updated_at'];


    public function guardarEjerciciosRutina($id_rutina, $ejercicios) 
    {
        $this->where('id_rutina', $id_rutina)->delete();

        foreach ($ejercicios as $ejercicio) {
            $this->insert([
                'id_rutina' => $id_rutina,
                'id_ejercicio' => desencriptar($ejercicio['id']),
                'orden' => $ejercicio['orden']
            ]);
        }
    }
}
?>