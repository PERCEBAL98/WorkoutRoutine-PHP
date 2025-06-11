<?php
namespace App\Controllers;

use App\Models\EjercicioModel;
use \Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use CodeIgniter\Files\File;
use Dompdf\Dompdf;
use Dompdf\Options;

class EjerciciosController extends BaseController
{
    protected $helpers = ['form'];
    protected $model;

    public function __construct()
    {
        $this->model = new EjercicioModel();
    }

    //--------------------------------------------------------------------------
    // *: carga la vista principal de ejercicios
    // <: [array] 
    //--------------------------------------------------------------------------
    public function index()
    {
        $data['datos'] = $this->model->obtenerEjerciciosPaginados(24, 0);
        $data['showFormEjercicios'] = true;

        return view('ejercicio/ejerciciosView', $data);
    }

    //--------------------------------------------------------------------------
    // *: 
    //--------------------------------------------------------------------------
    public function dashboard()
    {
        $data['datos'] = $this->model->findAll();

        return view('ejercicio/ejerciciosListView', $data);
    }

    //--------------------------------------------------------------------------
    // *: 
    //--------------------------------------------------------------------------
    public function nuevo()
    {
        // select nivel
        $optionsNivel = array();
        $optionsNivel[''] = "-- niveles --";
        $niveles = ["Principiante", "Intermedio", "Experto"];

        foreach ($niveles as $nivel) {
            $optionsNivel[strtolower($nivel)] = $nivel;
        }
        $data["optionsNivel"] = $optionsNivel;

        // select movimiento
        $optionsMovimiento = array();
        $optionsMovimiento[''] = "-- moviminetos --";
        $movimientos = ["Tirar", "Empujar", "Estático"];

        foreach ($movimientos as $movimiento) {
            $optionsMovimiento[strtolower($movimiento)] = $movimiento;
        }
        $data["optionsMovimiento"] = $optionsMovimiento;

        // select categoria
        $optionsCategoria = array();
        $optionsCategoria[''] = "-- categorias --";
        $categorias = ["Pliométricos", "Fuerza"];

        foreach ($categorias as $categoria) {
            $optionsCategoria[strtolower($categoria)] = $categoria;
        }
        $data["optionsCategoria"] = $optionsCategoria;

        // select mecánica
        $optionsMecanica = array();
        $optionsMecanica[''] = "-- mecánicas --";
        $mecanicas = ["Aislado", "Compuesto"];

        foreach ($mecanicas as $mecanica) {
            $optionsMecanica[strtolower($mecanica)] = $mecanica;
        }
        $data["optionsMecanica"] = $optionsMecanica;

        // select musculo primario
        $optionsMusculoPrimario = array();
        $optionsMusculoPrimario[''] = "-- músculos primarios --";
        $musculosPrimarios = [
            "Hombros", "Tríceps", "Bíceps", "Antebrazos",
            "Pecho", "Dorsales", "Abdominales", "Espalda", "Glúteos",
            "Abductores", "Aductores", "Isquiotibiales", "Cuádriceps", "Gemelos"
        ];

        foreach ($musculosPrimarios as $musculoPrimario) {
            $optionsMusculoPrimario[strtolower($musculoPrimario)] = $musculoPrimario;
        }
        $data["optionsMusculoPrimario"] = $optionsMusculoPrimario;

        // select musculo secundario
        $optionsMusculoSecundario = array();
        $optionsMusculoSecundario[''] = "-- músculos secundarios --";
        $musculosSecundarios = [
            "Hombros", "Tríceps", "Bíceps", "Antebrazos",
            "Pecho", "Dorsales", "Abdominales", "Espalda", "Glúteos",
            "Abductores", "Aductores", "Isquiotibiales", "Cuádriceps", "Gemelos"
        ];

        foreach ($musculosSecundarios as $musculoSecundario) {
            $optionsMusculoSecundario[strtolower($musculoSecundario)] = $musculoSecundario;
        }
        $data["optionsMusculoSecundario"] = $optionsMusculoSecundario;

        return view('ejercicio/ejerciciosNewView', $data);
    }

    //--------------------------------------------------------------------------
    // *: 
    //--------------------------------------------------------------------------
    public function crear()
    {
        $rules = [
            'nombre' => [
                'rules' => 'required|is_unique[ejercicios.nombre]',
                'errors' => [
                    'required' => 'Debes introducir un nombre.',
                    'is_unique' => 'El nombre del ejercicio ya existe.'
                ]
            ],
            'instrucciones' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Debes introducir las instrcciones.'
                ]
            ],
            'musculo_primario' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Debes seleccionar un músculo primario.'
                ]
            ],
            'nivel' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Debes seleccionar un nivel.'
                ]
            ],
            'movimiento' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Debes seleccionar un movimiento.'
                ]
            ],
            'categoria' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Debes seleccionar una categoría.'
                ]
            ],
            'mecanica' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Debes seleccionar una mecánica.'
                ]
            ]
        ];

        $datos = $this->request->getPost(array_keys($rules));

        if (!$this->validateData($datos, $rules)) {
            return redirect()->back()->withInput();
        }

        $nombre = $this->request->getvar('nombre');
        $instrucciones = $this->request->getvar('instrucciones');
        $musculo_primario = $this->request->getvar('musculo_primario');
        $nivel = $this->request->getvar('nivel');
        $movimiento = $this->request->getvar('movimiento');
        $categoria = $this->request->getvar('categoria');
        $mecanica = $this->request->getvar('mecanica');

        if ($this->request->getvar('musculo_secundario') != "") {
            $musculo_secundario = $this->request->getvar('musculo_secundario');
        } else {
            $musculo_secundario = null;
        }

        $newData = [
            'nombre' => $nombre,
            'instrucciones' => $instrucciones,
            'musculo_primario' => $musculo_primario,
            'musculo_secundario' => $musculo_secundario,
            'nivel' => $nivel,
            'movimiento' => $movimiento,
            'categoria' => $categoria,
            'mecanica' => $mecanica,
            'imagen_1' => "",
            'imagen_2' => ""
        ];

        if ($this->model->save($newData)) {
            if ($this->request->getFile('imagen_1') != "") {
                $idEjercicio = $this->model->getInsertID();
                $foto = $this->request->getFile('imagen_1');
                $ext = $foto->guessExtension();

                $nameFotoFolder = 'public/assets/img/exercises/' . str_replace(' ', '_', $nombre);
                $nameFotoFile = "0." . $ext;
                $foto->move(ROOTPATH . $nameFotoFolder, $nameFotoFile);

                $filepath = str_replace(' ', '_', $nombre) . '/' . $nameFotoFile;
                $this->model->where('id', $idEjercicio)->set(['imagen_1' => $filepath])->update();
            }
            if ($this->request->getFile('imagen_2') != "") {
                $idEjercicio = $this->model->getInsertID();
                $foto = $this->request->getFile('imagen_2');
                $ext = $foto->guessExtension();

                $nameFotoFolder = 'public/assets/img/exercises/' . str_replace(' ', '_', $nombre);
                $nameFotoFile = "1." . $ext;
                $foto->move(ROOTPATH . $nameFotoFolder, $nameFotoFile);

                $filepath = str_replace(' ', '_', $nombre) . '/' . $nameFotoFile;
                $this->model->where('id', $idEjercicio)->set(['imagen_2' => $filepath])->update();
            }
        }

        return redirect()->to('ejercicios/listado');
    }

    //--------------------------------------------------------------------------
    // *: 
    //--------------------------------------------------------------------------
    public function editar()
    {
        $id = desencriptar($this->request->getVar('id'));

        $data['datos'] = $this->model->where('id', $id)->first();

        // select nivel
        $optionsNivel = array();
        $optionsNivel[''] = "-- niveles --";
        $niveles = ["Principiante", "Intermedio", "Experto"];

        foreach ($niveles as $nivel) {
            $optionsNivel[strtolower($nivel)] = $nivel;
        }
        $data["optionsNivel"] = $optionsNivel;

        // select movimiento
        $optionsMovimiento = array();
        $optionsMovimiento[''] = "-- moviminetos --";
        $movimientos = ["Tirar", "Empujar", "Estático"];

        foreach ($movimientos as $movimiento) {
            $optionsMovimiento[strtolower($movimiento)] = $movimiento;
        }
        $data["optionsMovimiento"] = $optionsMovimiento;

        // select categoria
        $optionsCategoria = array();
        $optionsCategoria[''] = "-- categorias --";
        $categorias = ["Pliométricos", "Fuerza"];

        foreach ($categorias as $categoria) {
            $optionsCategoria[strtolower($categoria)] = $categoria;
        }
        $data["optionsCategoria"] = $optionsCategoria;

        // select mecánica
        $optionsMecanica = array();
        $optionsMecanica[''] = "-- mecánicas --";
        $mecanicas = ["Aislado", "Compuesto"];

        foreach ($mecanicas as $mecanica) {
            $optionsMecanica[strtolower($mecanica)] = $mecanica;
        }
        $data["optionsMecanica"] = $optionsMecanica;

        // select musculo primario
        $optionsMusculoPrimario = array();
        $optionsMusculoPrimario[''] = "-- músculos primarios --";
        $musculosPrimarios = [
            "Hombros", "Tríceps", "Bíceps", "Antebrazos",
            "Pecho", "Dorsales", "Abdominales", "Espalda", "Glúteos",
            "Abductores", "Aductores", "Isquiotibiales", "Cuádriceps", "Gemelos"
        ];

        foreach ($musculosPrimarios as $musculoPrimario) {
            $optionsMusculoPrimario[strtolower($musculoPrimario)] = $musculoPrimario;
        }
        $data["optionsMusculoPrimario"] = $optionsMusculoPrimario;

        // select musculo secundario
        $optionsMusculoSecundario = array();
        $optionsMusculoSecundario[''] = "-- músculos secundarios --";
        $musculosSecundarios = [
            "Hombros", "Tríceps", "Bíceps", "Antebrazos",
            "Pecho", "Dorsales", "Abdominales", "Espalda", "Glúteos",
            "Abductores", "Aductores", "Isquiotibiales", "Cuádriceps", "Gemelos"
        ];

        foreach ($musculosSecundarios as $musculoSecundario) {
            $optionsMusculoSecundario[strtolower($musculoSecundario)] = $musculoSecundario;
        }
        $data["optionsMusculoSecundario"] = $optionsMusculoSecundario;

        return view('ejercicio/ejerciciosEditView', $data);
    }

    //--------------------------------------------------------------------------
    // *: 
    //--------------------------------------------------------------------------
    public function actualizar()
    {
        $rules = [
            'nombre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Debes introducir un nombre.'
                ]
            ],
            'instrucciones' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Debes introducir las instrcciones.'
                ]
            ],
            'musculo_primario' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Debes seleccionar un músculo primario.'
                ]
            ],
            'nivel' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Debes seleccionar un nivel.'
                ]
            ],
            'movimiento' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Debes seleccionar un movimiento.'
                ]
            ],
            'categoria' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Debes seleccionar una categoría.'
                ]
            ],
            'mecanica' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Debes seleccionar una mecánica.'
                ]
            ]
        ];

        $datos = $this->request->getPost(array_keys($rules));

        if (!$this->validateData($datos, $rules)) {
            return redirect()->back()->withInput();
        }

        $nombre = $this->request->getvar('nombre');
        $instrucciones = $this->request->getvar('instrucciones');
        $musculo_primario = $this->request->getvar('musculo_primario');
        $nivel = $this->request->getvar('nivel');
        $movimiento = $this->request->getvar('movimiento');
        $categoria = $this->request->getvar('categoria');
        $mecanica = $this->request->getvar('mecanica');

        if ($this->request->getvar('musculo_secundario') != "") {
            $musculo_secundario = $this->request->getvar('musculo_secundario');
        } else {
            $musculo_secundario = null;
        }

        $newData = [
            'nombre' => $nombre,
            'instrucciones' => $instrucciones,
            'musculo_primario' => $musculo_primario,
            'musculo_secundario' => $musculo_secundario,
            'nivel' => $nivel,
            'movimiento' => $movimiento,
            'categoria' => $categoria,
            'mecanica' => $mecanica,
            'imagen_1' => "",
            'imagen_2' => ""
        ];

        if ($this->model->save($newData)) {
            if ($this->request->getFile('imagen_1') != "") {
                $idEjercicio = $this->model->getInsertID();
                $foto = $this->request->getFile('imagen_1');
                $ext = $foto->guessExtension();

                $nameFotoFolder = 'public/assets/img/exercises/' . str_replace(' ', '_', $nombre);
                $nameFotoFile = "0." . $ext;
                $foto->move(ROOTPATH . $nameFotoFolder, $nameFotoFile);

                $filepath = str_replace(' ', '_', $nombre) . '/' . $nameFotoFile;
                $this->model->where('id', $idEjercicio)->set(['imagen_1' => $filepath])->update();
            }
            if ($this->request->getFile('imagen_2') != "") {
                $idEjercicio = $this->model->getInsertID();
                $foto = $this->request->getFile('imagen_2');
                $ext = $foto->guessExtension();

                $nameFotoFolder = 'public/assets/img/exercises/' . str_replace(' ', '_', $nombre);
                $nameFotoFile = "1." . $ext;
                $foto->move(ROOTPATH . $nameFotoFolder, $nameFotoFile);

                $filepath = str_replace(' ', '_', $nombre) . '/' . $nameFotoFile;
                $this->model->where('id', $idEjercicio)->set(['imagen_2' => $filepath])->update();
            }
        }

        return redirect()->to('ejercicios/listado');
    }

    //--------------------------------------------------------------------------
    // *: elimina un ejercicio por su id
    // >: [int GET_BODY] id
    // <: true si todo va bien
    //    false si no se ha podido eliminar
    //--------------------------------------------------------------------------
    public function eliminar()
    {
        $id = desencriptar($this->request->getVar(index: 'id'));
        $registro = $this->model->find($id);

        if ($registro) {            
            $basePath = ROOTPATH . 'public/assets/img/exercises/';
            $folder = explode('/', $registro['imagen_1'])[0];
            $carpeta = $basePath . $folder;

            if (is_dir($carpeta)) {
                $archivos = array_diff(scandir($carpeta), ['.', '..']);

                foreach ($archivos as $archivo) {
                    $ruta = $carpeta . DIRECTORY_SEPARATOR . $archivo;
                    if (is_file($ruta)) {
                        unlink($ruta);
                    }
                }

                rmdir($carpeta);
            }
        }

        return $this->model->delete($this->request->getVar('id'))
            ? $this->response->setJSON(['success' => true])
            : $this->response->setJSON(['success' => false]);
    }

    //--------------------------------------------------------------------------
    // *: obtiene y devulve ejercicios con paginación
    // >: [int $pagina] número de página para la paginación (por defecto 0)
    // <: [JSON] lista de ejercicios
    //--------------------------------------------------------------------------
    public function cargarEjercicios($pagina = 0) 
    {
        $limite = 24;
        $offset = $pagina * $limite;

        $ejercicios = $this->model->obtenerEjerciciosPaginados($limite, $offset);

        return $this->response->setJSON($ejercicios);
    }

    //--------------------------------------------------------------------------
    // *: obtiene y devulve ejercicios filtrados con paginación
    // >: [int $pagina] número de página para la paginación (por defecto 0)
    //    [array GET_BODY] lista de filtros
    // <: [JSON] lista de ejercicios
    //--------------------------------------------------------------------------
    public function cargarEjerciciosConFiltros($pagina = 0)
    {
        $filtros = $this->request->getGet();
        unset($filtros['busqueda']);
        $busqueda = $this->request->getGet('busqueda');
        $limite = 24;
        $offset = $pagina * $limite;

        $ejercicios = $this->model->obtenerEjerciciosPaginadosConFiltros($limite, $offset, $filtros, $busqueda);

        return $this->response->setJSON($ejercicios);
    }

    //--------------------------------------------------------------------------
    // *: obtiene y devuelve si encuentra buscando por ID un ejercicio, en caso
    //    contrario devuelve mensaje de error
    // >: [int $id] ID del ejercicio a obtener
    // <: [JSON] datos del ejercicio o mensaje de error
    //--------------------------------------------------------------------------
    public function obtenerEjercicioPorId($id)
    {
        $ejercicio = $this->model->find(desencriptar($id));

        if (!$ejercicio) {
            return $this->response->setJSON(['error' => 'Ejercicio no encontrado']);
        }

        return $this->response->setJSON($ejercicio);
    }
}
