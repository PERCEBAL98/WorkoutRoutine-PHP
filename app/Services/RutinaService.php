<?php
namespace App\Services;

use App\Models\EjercicioModel;
use App\Models\RutinaModel;
use ReturnTypeWillChange;

class RutinaService
{
    protected $rutinaModel;
    protected $ejercicioModel;

    public function __construct()
    {
        $this->rutinaModel = new RutinaModel();
        $this->ejercicioModel = new EjercicioModel();
    }

    //--------------------------------------------------------------------------
    // *: carga la vista principal de rutinas
    // <: [array] 
    //--------------------------------------------------------------------------
    public function crearRutinaAutomatica($deportista_id, $filtros)
    {
        $ejercicios_ids = $this->generarListaIdsEjercicios($filtros);

        $nombres_ejercicios = $this->ejercicioModel->obtenerNombresPorIds($ejercicios_ids);
        $rutina_data = $this->generarDatosRutina($deportista_id, $filtros['nivel'], $filtros['musculo_primario'], $nombres_ejercicios);

        return $this->rutinaModel->crearRutinaConEjercicios($rutina_data, $ejercicios_ids);
    }


    //--------------------------------------------------------------------------
    // *: obtener datos de la rutina y crearla
    // >: [INT] id del deportista
    //    [array $ejercicios_ids] lista de ids de ejercicios
    // <: [BOOLEAN] false si ha fallado la función
    //    [INT] id de la ruitna insertada si ha ido bien la función
    //--------------------------------------------------------------------------
    public function crearRutinaPersonalizada($deportista_id, $ejercicios_ids)
    {
        if (empty($ejercicios_ids) || count($ejercicios_ids) < 3)
            return false;

        $nivel = $this->determinarNivel($ejercicios_ids);
        $musculo_primario = $this->ejercicioModel->select('musculo_primario')->where('id', $ejercicios_ids[0])->first()['musculo_primario'] ?? null;
        $nombres_ejercicios = $this->ejercicioModel->obtenerNombresPorIds($ejercicios_ids);

        $rutina_data = $this->generarDatosRutina($deportista_id, $nivel, $musculo_primario, $nombres_ejercicios);

        return $this->rutinaModel->crearRutinaConEjercicios($rutina_data, $ejercicios_ids);
    }

    //--------------------------------------------------------------------------
    // *: crear rutina
    // >: [array $rutina_data] lista de datos sobre la rutina
    //    [array $ejercicios_ids] lista de ids de ejercicios
    // <: [BOOLEAN] false si ha fallado la función
    //    [INT] id de la ruitna insertada si ha ido bien la función
    //--------------------------------------------------------------------------
    public function crearRutinaAdministracion($rutina_data, $ejercicios_ids)
    {
        if (empty($ejercicios_ids))
            return false;
        return $this->rutinaModel->crearRutinaConEjercicios($rutina_data, $ejercicios_ids);
    }

    //--------------------------------------------------------------------------
    // *: 
    // >: [array $filtros] 
    // <: [array] 
    //--------------------------------------------------------------------------
    private function generarListaIdsEjercicios($filtros)
    {
        $ejercicios_ajustados = $this->ajustarCantidadEjercicios($filtros);

        return array_column($ejercicios_ajustados, 'id');
    }

    //--------------------------------------------------------------------------
    // *: 
    // >: [array $ejercicios] 
    // <: [array] 
    //--------------------------------------------------------------------------
    private function ajustarCantidadEjercicios($filtros)
    {
        $cantidad_nivel = [
            'principiante' => 3,
            'intermedio' => 4,
            'experto' => 5
        ];

        $niveles = ['experto', 'intermedio', 'principiante'];
        $nivel_inicial = $filtros['nivel'];
        $cantidad_necesaria = $cantidad_nivel[$nivel_inicial] ?? 3;

        $nivel_index = array_search($nivel_inicial, $niveles);

        $filtros_a_relajar = ['mecanica', 'movimiento', 'categoria'];

        $ejercicios_finales = [];

        $filtros_sin_secundario = $filtros;
        unset($filtros_sin_secundario['musculo_secundario']);

        for ($i = $nivel_index; $i < count($niveles); $i++) {
            $nivel_actual = $niveles[$i];
            $filtros_sin_secundario['nivel'] = $nivel_actual;

            for ($j = 0; $j <= count($filtros_a_relajar); $j++) {
                $filtros_relajados = $filtros_sin_secundario;
                for ($k = 0; $k < $j; $k++) {
                    unset($filtros_relajados[$filtros_a_relajar[$k]]);
                }
                $filtros_relajados = $this->limpiarFiltrosVacios($filtros_relajados);

                $ejercicios_nivel = $this->ejercicioModel->obtenerEjerciciosConFiltros($filtros_relajados);

                foreach ($ejercicios_nivel as $ej) {
                    if (!in_array($ej['id'], array_column($ejercicios_finales, 'id'))) {
                        $ejercicios_finales[] = $ej;
                    }
                }

                if (count($ejercicios_finales) >= $cantidad_necesaria) {
                    break 2;
                }
            }
        }

        if (count($ejercicios_finales) < $cantidad_necesaria && !empty($filtros['musculo_secundario'])) {
            $filtros_secundario = [
                'nivel' => $nivel_inicial,
                'musculo_primario' => $filtros['musculo_secundario']
            ];

            $ejercicios_secundario = $this->ejercicioModel->obtenerEjerciciosConFiltros($filtros_secundario);

            foreach ($ejercicios_secundario as $ej) {
                if (!in_array($ej['id'], array_column($ejercicios_finales, 'id'))) {
                    $ejercicios_finales[] = $ej;
                }
                if (count($ejercicios_finales) >= $cantidad_necesaria) {
                    break;
                }
            }
        }

        shuffle($ejercicios_finales);
        return array_slice($ejercicios_finales, 0, $cantidad_necesaria);
    }

    private function limpiarFiltrosVacios($filtros)
    {
        return array_filter($filtros, fn($v) => !empty($v));
    }

    //--------------------------------------------------------------------------
    // *: genera los campos que va a tener una rutina
    // >: [INT $deportista_id] id del usuario
    //    [String $nivel] cadena de texto del nivel de la rutina
    //    [array $nombres_ejercicios] lista de nombres de ejercicios
    // <: [array] lista con todos los campos de una rutina rellenos
    //--------------------------------------------------------------------------
    private function generarDatosRutina($deportista_id, $nivel, $musculo_primario, $nombres_ejercicios)
    {
        $configuracion_rutina = $this->obtenerDatosRutinaPorNivel($nivel, $musculo_primario, $nombres_ejercicios);
        return array_merge($configuracion_rutina, [
            'id_deportista' => $deportista_id,
            'nivel' => $nivel,
            'fecha' => date("Y-m-d"),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
    }

    //--------------------------------------------------------------------------
    // *: genera datos de la rutina dependiendo del nivel de los ejercicios
    // >: [String] cadena de texto con el nivel
    //    [Array] lista de nombres de ejercicios
    // <: [Array] lista personalizada dependiendo del nivel
    //--------------------------------------------------------------------------
    private function obtenerDatosRutinaPorNivel($nivel, $musculo_primario, $nombres_ejercicios)
    {
        $descripcion = "Ejercicios: " . implode(", ", $nombres_ejercicios) . ".";
        $fecha_formateada = formatear_fecha_hora_español(date("Y-m-d H:i:s"));

        $datos_nivel = [
            'principiante' => [
                'descanso' => 30,
                'duracion' => 30,
                'repeticiones' => 8,
                'vueltas' => 3,
                'descripcion' => $descripcion,
                'nombre' => "Rutina $musculo_primario, $fecha_formateada."
            ],
            'intermedio' => [
                'descanso' => 30,
                'duracion' => 45,
                'repeticiones' => 12,
                'vueltas' => 4,
                'descripcion' => $descripcion,
                'nombre' => "Rutina $musculo_primario, $fecha_formateada."
            ],
            'experto' => [
                'descanso' => 30,
                'duracion' => 60,
                'repeticiones' => 15,
                'vueltas' => 5,
                'descripcion' => $descripcion,
                'nombre' => "Rutina $musculo_primario, $fecha_formateada."
            ]
        ];

        return $datos_nivel[$nivel] ?? [];
    }

    //--------------------------------------------------------------------------
    // *: determina el nivel general de la rutina basandose en los niveles de
    //    los ejercicios. Prioriza el nivel más frecuente, en caso de que
    //    ninguno supere el 50% se elige el nivel más alto disponible
    // >: [array] lista de ids de ejercicios
    // <: [String] cadena de texto con el nivel 
    //--------------------------------------------------------------------------
    private function determinarNivel($ejercicios_ids)
    {
        $niveles = $this->ejercicioModel->obtenerNivelesPorIds($ejercicios_ids);
        $conteo_niveles = array_count_values($niveles);
        $total_ejercicios = count($niveles);

        foreach ($conteo_niveles as $nivel => $cantidad) {
            if ($cantidad / $total_ejercicios > 0.5) {
                return $nivel;
            }
        }

        if (in_array("experto", $niveles))
            return "experto";
        if (in_array("intermedio", $niveles))
            return "intermedio";
        return "principiante";
    }
}
