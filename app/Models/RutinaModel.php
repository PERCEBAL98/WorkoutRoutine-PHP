<?php
namespace App\Models;
use App\Models\RutinaEjercicioModel;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
use Exception;

class RutinaModel extends Model {
    protected $table = 'rutinas';
    protected $allowedFields = ['id_deportista', 'descanso', 'duracion', 'repeticiones', 'vueltas', 'descripcion', 'fecha', 'nivel', 'nombre', 'favorito', 'created_at', 'updated_at'];

    //--------------------------------------------------------------------------
    // *: 
    // >: 
    // <: 
    //--------------------------------------------------------------------------
    public function listaRutinas() {
        $rutinas = $this
            ->join('deportistas', 'rutinas.id_deportista=deportistas.id', 'INNER')
            ->select('rutinas.id, rutinas.id_deportista, deportistas.usuario, rutinas.descanso, rutinas.duracion, rutinas.repeticiones, rutinas.vueltas, rutinas.descripcion, rutinas.fecha, rutinas.nivel, rutinas.nombre')
            ->where('id_deportista', session()->get('id'))
            ->findAll();
    
        return $rutinas;
    }

    //--------------------------------------------------------------------------
    // *: obtiene rutinas con paginación
    // >: [int $limite] cantidad de rutinas a obtener
    //    [int $offset] posición de comienzo
    // <: [array] lista de rutinas
    //--------------------------------------------------------------------------
    public function obtenerRutinasPaginadas($limite, $offset) {
        $rutinas = $this->where('id_deportista', session()->get('id'))->findAll($limite, $offset);
        foreach ($rutinas as &$rutina) {
            $rutina['id'] = encriptar($rutina['id']);
        }
    
        return $rutinas;
    }

    //--------------------------------------------------------------------------
    // *: obtiene ejercicios filtrados con paginación
    // >: [int $limite] cantidad de ejercicios a obtener
    //    [int $offset] posición de comienzo
    //    [array] lista de filtros
    // <: [array] lista de ejercicios
    //--------------------------------------------------------------------------
    public function obtenerRutinasPaginadasConFiltros($limite, $offset, $filtros = [], $busqueda = null) {
        $this->where('id_deportista', session()->get('id'));
        if (!empty($filtros)) {
            foreach ($filtros as $campo => $valor) {
                if ($valor !== null) {
                    if ($campo === 'fecha') {
                        $hoy = date('Y-m-d');
                        $this->where('DATE(' . $campo . ') >=', $valor);
                        $this->where('DATE(' . $campo . ') <=', $hoy);
                    }
                    else {
                        $this->where($campo, $valor);
                    }
                }
            }
        }

        if (!empty($busqueda)) {
            $this->groupStart()
                 ->like('nombre', $busqueda)
                 ->orLike('descripcion', $busqueda)
                 ->orLike('nivel', $busqueda)
            ->groupEnd();
        }

        $rutinas = $this->findAll($limite, $offset);
        foreach ($rutinas as &$rutina) {
            $rutina['id'] = encriptar($rutina['id']);
        }
    
        return $rutinas;
    }

    //--------------------------------------------------------------------------
    // *: crea una rutina con los ejercicios correspondientes mediante un
    //    transacción para añadir todo correctamente
    // >: [array $rutina_data] lista con los datos de la rutina
    //    [array $ejercicios_ids] lista con ids de los ejercicios de la rutina
    // <: [BOOLEAN] false si ha fallado la transación
    //    [INT] id de la ruitna insertada si ha ido bien la transacción
    //--------------------------------------------------------------------------
    public function crearRutinaConEjercicios($rutina_data, $ejercicios_ids) {
        $this->db->transStart();
        try {
            if (!$this->insert($rutina_data)) {
                throw new \Exception("Error al insertar la rutina.");
            }
            $rutina_id = $this->db->insertID();

            $ejercicios_data = [];
            foreach ($ejercicios_ids as $ejercicio_id) {
                $ejercicios_data[] = [
                    'id_rutina' => $rutina_id,
                    'id_ejercicio' => $ejercicio_id
                ];
            }

            if (!empty($ejercicios_data)) {
                $this->db->table('rutinas_ejercicios')->insertBatch($ejercicios_data);
            }

            $this->db->transComplete();

            if ($this->db->transStatus() === FALSE) {
                throw new \Exception("Error en la transacción de la rutina.");
            }
    
            return $rutina_id;
        } catch (\Exception $e) {
            $this->db->transRollback();
            return false;
        }
    }

    //--------------------------------------------------------------------------
    // *: 
    // >: 
    // <: 
    //--------------------------------------------------------------------------
    public function guardarDatosRutina($id, $nombre, $descripcion, $vueltas, $repeticiones, $duracion, $descanso) {
        $this->update($id, [
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'vueltas' => $vueltas,
            'repeticiones' => $repeticiones,
            'duracion' => $duracion,
            'descanso' => $descanso,
        ]);
    }
}
?>