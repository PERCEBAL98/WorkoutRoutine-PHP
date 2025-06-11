<?php
namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class EjercicioModel extends Model {
    protected $table = 'ejercicios';
    protected $allowedFields = ['nombre', 'movimiento', 'nivel', 'mecanica', 'musculo_primario', 'musculo_secundario', 'instrucciones', 'categoria', 'imagen_1', 'imagen_2', 'imagen_3', 'created_at', 'updated_at'];

    //--------------------------------------------------------------------------
    // *: 
    // >: 
    // <: 
    //--------------------------------------------------------------------------
    public function obtenerEjerciciosConFiltros($filtros) 
    {
        foreach ($filtros as $campo => $valor) {
            if (!empty($valor)) {
                $this->where($campo, $valor);
            }
        }

        return $this->findAll();
    }

    //--------------------------------------------------------------------------
    // *: obtiene ejercicios con paginación
    // >: [int $limite] cantidad de ejercicios a obtener
    //    [int $offset] posición de comienzo
    // <: [array] lista de ejercicios
    //--------------------------------------------------------------------------
    public function obtenerEjerciciosPaginados($limite, $offset) 
    {
        $ejercicios = $this->findAll($limite, $offset);
        foreach ($ejercicios as &$ejercicio) {
            $ejercicio['id'] = encriptar($ejercicio['id']);
        }
    
        return $ejercicios;
    }

    //--------------------------------------------------------------------------
    // *: obtiene ejercicios filtrados con paginación
    // >: [int $limite] cantidad de ejercicios a obtener
    //    [int $offset] posición de comienzo
    //    [array] lista de filtros
    // <: [array] lista de ejercicios
    //--------------------------------------------------------------------------
    public function obtenerEjerciciosPaginadosConFiltros($limite, $offset, $filtros = [], $busqueda = null) 
    {
        if (!empty($filtros)) {
            foreach ($filtros as $campo => $valor) {
                if ($valor !== null) {
                    if ($campo === 'musculo_secundario') {
                        $this->like($campo, $valor);
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
                 ->orLike('instrucciones', $busqueda)
                 ->orLike('movimiento', $busqueda)
                 ->orLike('nivel', $busqueda)
                 ->orLike('mecanica', $busqueda)
                 ->orLike('musculo_primario', $busqueda)
                 ->orLike('musculo_secundario', $busqueda)
                 ->orLike('categoria', $busqueda)
            ->groupEnd();
        }

        $ejercicios = $this->findAll($limite, $offset);
        foreach ($ejercicios as &$ejercicio) {
            $ejercicio['id'] = encriptar($ejercicio['id']);
        }
    
        return $ejercicios;
    }

    public function obtenerEjerciciosPorIdRutina($idRutina) 
    {
        $ejercicios = $this
            ->join('rutinas_ejercicios', 'ejercicios.id = rutinas_ejercicios.id_ejercicio')
            ->where('rutinas_ejercicios.id_rutina', $idRutina)
            ->orderBy('rutinas_ejercicios.orden', 'ASC')
            ->get()
            ->getResultArray();

        foreach ($ejercicios as &$ejercicio) {
            $ejercicio['id'] = encriptar($ejercicio['id']);
        }

        return $ejercicios;
    }

    //--------------------------------------------------------------------------
    // *: 
    // >: 
    // <: 
    //--------------------------------------------------------------------------
    public function obtenerNivelesPorIds($ids) 
    {
        $niveles = $this
            ->select('nivel')
            ->whereIn('id', $ids)
            ->findAll();

        return array_column($niveles, 'nivel');
    }

    //--------------------------------------------------------------------------
    // *: 
    // >: 
    // <: 
    //--------------------------------------------------------------------------
    public function obtenerNombresPorIds($ids) 
    {
        $nombres = $this
            ->select('nombre')
            ->whereIn('id', $ids)
            ->findAll();

        return array_column($nombres, 'nombre');
    }
}
?>