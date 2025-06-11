<?php

namespace App\Controllers;

use App\Models\RutinaEjercicioModel;
use App\Models\EjercicioModel;
use App\Models\RutinaFechaModel;
use App\Models\RutinaModel;
use App\Services\RutinaService;
use \Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use CodeIgniter\Files\File;
use Dompdf\Dompdf;
use Dompdf\Options;
use function PHPUnit\Framework\returnArgument;

class RutinasController extends BaseController
{
    protected $helpers = ['form'];
    protected $rutinaModel;
    protected $ejercicioModel;
    protected $rutinaService;
    protected $rutinaFechaModel;

    public function __construct()
    {
        $this->rutinaEjercicioModel = new RutinaEjercicioModel();
        $this->rutinaModel = new RutinaModel();
        $this->ejercicioModel = new EjercicioModel();
        $this->rutinaService = new RutinaService();
        $this->rutinaFechaModel = new RutinaFechaModel();
    }

    //--------------------------------------------------------------------------
    // *: carga la vista principal de rutinas
    // >: 
    // <: [array] 
    //--------------------------------------------------------------------------
    public function index()
    {
        $data['datos'] = $this->rutinaModel->obtenerRutinasPaginadas(24, 0);
        $data['showFormRutinas'] = true;

        return view('rutina/rutinasView', $data);
    }

    //--------------------------------------------------------------------------
    // *: 
    // >: 
    // <: 
    //--------------------------------------------------------------------------
    public function añadirFavorito()
    {
        $id = desencriptar($this->request->getVar('id'));

        $rutina = $this->rutinaModel->find($id);
        if (!$rutina) {
            return $this->response->setJSON(['success' => false, 'error' => 'Rutina no encontrada']);
        }

        $nuevoValor = $rutina['favorito'] == 1 ? 0 : 1;

        $this->rutinaModel->update($id, ['favorito' => $nuevoValor]);

        return $this->response->setJSON([
            'success' => true,
            'favorito' => $nuevoValor
        ]);
    }

    //--------------------------------------------------------------------------
    // *: 
    // >: 
    // <: 
    //--------------------------------------------------------------------------
    public function eliminar()
    {
        $id = desencriptar($this->request->getVar(index: 'id'));

        return $this->rutinaModel->delete($id)
            ? $this->response->setJSON(['success' => true])
            : $this->response->setJSON(['success' => false]);
    }

    //--------------------------------------------------------------------------
    // *: 
    // >: 
    // <: 
    //--------------------------------------------------------------------------
    public function exportar()
    {
        $datos = $this->rutinaModel->listaRutinas();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Deportista');
        $sheet->setCellValue('B1', 'Rutina');
        $sheet->setCellValue('C1', 'Descripción');
        $sheet->setCellValue('D1', 'Nivel');
        $sheet->setCellValue('E1', 'Fecha Creación');
        $sheet->setCellValue('F1', 'Duración');
        $sheet->setCellValue('G1', 'Descanso');
        $sheet->setCellValue('H1', 'Vueltas');
        $sheet->setCellValue('I1', 'Repeticiones');
        $count = 2;

        foreach ($datos as $dato) {
            $sheet->setCellValue('A' . $count, $dato["usuario"]);
            $sheet->setCellValue('B' . $count, $dato["nombre"]);
            $sheet->setCellValue('C' . $count, $dato['descripcion']);
            $sheet->setCellValue('D' . $count, $dato["nivel"]);
            $sheet->setCellValue('E' . $count, formatear_fecha_hora_español($dato["fecha"]));
            $sheet->setCellValue('F' . $count, $dato['duracion']);
            $sheet->setCellValue('G' . $count, $dato["descanso"]);
            $sheet->setCellValue('H' . $count, $dato["vueltas"]);
            $sheet->setCellValue('I' . $count, $dato['repeticiones']);
            $count++;
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save('rutinas.xlsx');
        
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=rutinas.xlsx");
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate");
        header("Content-Length: " . filesize("rutinas.xlsx"));
        ob_clean();
        readfile("rutinas.xlsx");

        exit;
    }

    //--------------------------------------------------------------------------
    // *: obtiene y devulve rutinas con paginación
    // >: [int $pagina] número de página para la paginación (por defecto 0)
    // <: [JSON] lista de rutinas
    //--------------------------------------------------------------------------
    public function cargarRutinas($pagina = 0) 
    {
        $limite = 24;
        $offset = $pagina * $limite;

        $rutinas = $this->rutinaModel->obtenerRutinasPaginadas($limite, $offset);

        return $this->response->setJSON($rutinas);
    }

    //--------------------------------------------------------------------------
    // *: obtiene y devulve rutinas filtrados con paginación
    // >: [int $pagina] número de página para la paginación (por defecto 0)
    //    [array GET_BODY] lista de filtros
    // <: [JSON] lista de rutinas
    //--------------------------------------------------------------------------
    public function cargarRutinasConFiltros($pagina = 0)
    {
        $filtros = $this->request->getGet();
        unset($filtros['busqueda']);
        $busqueda = $this->request->getGet('busqueda');
        $limite = 24;
        $offset = $pagina * $limite;

        if (isset($filtros['fecha'])) {
            if ($filtros['fecha'] == 'dia') {
                $filtros['fecha'] = date('Y-m-d');
            }
            elseif ($filtros['fecha'] == 'semana') {
                $filtros['fecha'] = date('Y-m-d', strtotime('-1 week'));
            }
            elseif ($filtros['fecha'] == 'mes') {
                $filtros['fecha'] = date('Y-m-d', strtotime('-1 month'));
            }
        }

        $rutinas = $this->rutinaModel->obtenerRutinasPaginadasConFiltros($limite, $offset, $filtros, $busqueda);

        return $this->response->setJSON($rutinas);
    }

    //--------------------------------------------------------------------------
    // *: 
    // >: 
    // <: 
    //--------------------------------------------------------------------------
    public function verRutina()
    {
        $idRutina = desencriptar($this->request->getGet('ver'));

        $data['rutina'] = $this->rutinaModel->where('id', $idRutina)->where('id_deportista', session()->get('id'))->first();
        $data['ejercicios'] = $this->ejercicioModel->obtenerEjerciciosPorIdRutina($idRutina);

        return view('rutina/verRutinaView', $data);
    }

    //--------------------------------------------------------------------------
    // *: 
    // >: 
    // <: 
    //--------------------------------------------------------------------------
    public function guardarRutina()
    {
        $data = json_decode($this->request->getBody(), true);
        if (!$data) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'No se recibieron datos válidos'
            ]);
        }
        $id = desencriptar($data["id"]);

        if (!empty($id)) {
            $nombre = $data["nombre"];
            $descripcion = $data["descripcion"];
            $vueltas = (int) $data["vueltas"];
            $repeticiones = (int) $data["repeticiones"];
            $duracion = (int) $data["duracion"];
            $descanso = (int) $data["descanso"];
            $this->rutinaModel->update($id, [
                'nombre' => $nombre,
                'descripcion' => $descripcion,
                'vueltas' => $vueltas,
                'repeticiones' => $repeticiones,
                'duracion' => $duracion,
                'descanso' => $descanso
            ]);

            $ejercicios = $data["ejercicios"];
            $this->rutinaEjercicioModel->guardarEjerciciosRutina($id, $ejercicios);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Rutina guardada con éxito'
        ]);
    }  

    //--------------------------------------------------------------------------
    // *: 
    // >: 
    // <: 
    //--------------------------------------------------------------------------
    public function obtenerRutinaPorId($rutinaId)
    {
        $idRutina = desencriptar($rutinaId);

        $rutina = $this->rutinaModel->where('id', $idRutina)->where('id_deportista', session()->get('id'))->first();
        if (!$rutina) {
            return $this->response->setJSON(['error' => 'Rutina no encontrada']);
        }
        $rutina['duracion'] = (int) $rutina['duracion'];
        $rutina['descanso'] = (int) $rutina['descanso'];
        
        $ejercicios = $this->ejercicioModel->obtenerEjerciciosPorIdRutina($idRutina);
        if (!$ejercicios) {
            return $this->response->setJSON(['error' => 'Ejercicios no encontrados']);
        }

        return $this->response->setJSON([
            'rutina' => $rutina,
            'ejercicios' => $ejercicios
        ]);
    }

    //--------------------------------------------------------------------------
    // *: 
    // >: 
    // <: 
    //--------------------------------------------------------------------------
    public function realizarRutina()
    {
        if ($this->request->getGet('tipo') == "repeticiones") {
            return view('rutina/repeticionesRutinaView');
        }
        else if ($this->request->getGet('tipo') == "tiempo") {
            return view('rutina/tiempoRutinaView');
        }
    }

    //--------------------------------------------------------------------------
    // *: 
    // >: 
    // <: 
    //--------------------------------------------------------------------------
    public function automaticamente()
    {
        return view('rutina/rutinaAutomaticamenteView');
    }

    public function crearAutomaticamente()
    {
        $rules = [
            'nivel' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Debes seleccionar un nivel.',
                ]
            ],
            'musculo_primario' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Debes seleccionar un músculo primario.',
                ]
            ]
        ];

        $datos = $this->request->getPost(array_keys($rules));
        if (!$this->validateData($datos, $rules)) {
            return $this->response->setJSON(['success' => false, 'errors' => $this->validator->getErrors()])->setStatusCode(422);
        }

        $rutina = $this->rutinaService->crearRutinaAutomatica(session()->get('id'), $this->request->getPost());

        return $this->response->setJSON(['success' => true, 'id' => encriptar(strval($rutina)) ?? null]);
    }

    //--------------------------------------------------------------------------
    // *: 
    // >: 
    // <: 
    //--------------------------------------------------------------------------
    public function personalizada()
    {
        $data['ejercicios'] = $this->ejercicioModel->obtenerEjerciciosPaginados(24, 0);
        $data['showFormEjercicios'] = true;

        return view('rutina/rutinaPersonalizadaView', $data);
    }

    public function crearPersonalizada()
    {
        $idsEncriptados = $this->request->getPost('ejercicios');
        $ids = [];

        if (is_array($idsEncriptados)) {
            foreach ($idsEncriptados as $idEnc) {
                $ids[] = desencriptar($idEnc);
            }
        }

        $rutina = $this->rutinaService->crearRutinaPersonalizada(session()->get('id'), $ids);
        
        return $this->response->setJSON(['success' => true, 'id' => encriptar(strval($rutina)) ?? null]);
    }

    public function cargarRutinasCalendario()
    {
        $rutinas = $this->rutinaFechaModel->select('rutinas_fechas.fecha, rutinas_fechas.realizado, rutinas.id, rutinas.nivel')
            ->join('rutinas', 'rutinas_fechas.id_rutina = rutinas.id')
            ->where('rutinas.id_deportista', session()->get('id'))
            ->findAll();;
            
        $eventos = [];
        foreach ($rutinas as $rutina) {
            $color = '#e0e0e0';
            if ($rutina['nivel'] == 'principiante') {
                $color = '#fafaaa';
            } elseif ($rutina['nivel'] == 'intermedio') {
                $color = '#fac8aa';
            } elseif ($rutina['nivel'] == 'experto') {
                $color = '#faaaaa';
            }

            $eventos[] = [
                'title' => $rutina['realizado'] ? 'Rutina realizada' : 'Rutina pendiente',
                'start' => $rutina['fecha'],
                'textColor' => '#3C3C43',
                'backgroundColor' => $color,
                'borderColor' => $color,
                'url' => base_url('/rutina?ver=' . encriptar($rutina['id']))
            ];
        }

        return $this->response->setJSON($eventos);
    }

    public function completarRutinasCalendario()
    {
        $data = json_decode($this->request->getBody(), true);
        if (!$data) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'No se recibieron datos válidos'
            ]);
        }
        $id = desencriptar($data["id"]);

        $rutinaExistente = $this->rutinaFechaModel
            ->where('fecha', date('Y-m-d'))
            ->where('id_rutina', $id)
            ->where('realizado', 0)
            ->first();

        if ($rutinaExistente) {
            $this->rutinaFechaModel->update($rutinaExistente['id'], ['realizado' => 1]);
        } else {
            $this->rutinaFechaModel->insert([
                'id_rutina' => $id,
                'fecha' => date('Y-m-d'),
                'realizado' => 1
            ]);
        }

        return $this->response->setJSON(['status' => 'ok']);
    }
}