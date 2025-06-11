<?php

namespace App\Controllers;

use App\Models\DeportistaLogroModel;
use App\Models\DeportistaModel;
use App\Models\EjercicioModel;
use App\Models\LogroModel;
use App\Models\RoleModel;
use App\Models\RutinaEjercicioModel;
use App\Models\RutinaFechaModel;
use App\Models\RutinaModel;
use \Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use CodeIgniter\Files\File;
use Dompdf\Dompdf;
use Dompdf\Options;

class DeportistasController extends BaseController
{
    protected $helpers = ['form'];
    protected $model;
    protected $modelRoles;
    protected $modelRutinas;
    protected $modelRutinasEjercicios;
    protected $modelLogro;
    protected $modelDeportistaLogro;
    protected $rutinaFechaModel;

    public function __construct()
    {
        $this->model = new DeportistaModel();
        $this->modelRoles = new RoleModel();
        $this->modelRutinas = new RutinaModel();
        $this->modelRutinasEjercicios = new RutinaEjercicioModel();
        $this->modelLogro = new LogroModel();
        $this->modelDeportistaLogro = new DeportistaLogroModel();
        $this->rutinaFechaModel = new RutinaFechaModel();
    }

    public function terminosCondiciones()
    {
        return view('terminosCondicionesView');
    }

    public function privacidad()
    {
        return view('privacidadView');
    }

    public function cookies()
    {
        return view('cookiesView');
    }

    public function avisoLegal()
    {
        return view('avisoLegalView');
    }

    public function index()
    {
        $data['datos'] = $this->model->find(session()->get('id'));

        return view('usuario/perfilView', $data);
    }

    public function cambiarAvatar()
    {
        $id = session()->get('id');
        $avatar = $this->request->getVar('avatar');
    
        $success = $this->model->update($id, ['avatar' => $avatar]);

        if ($success) {
            session()->set('avatar', $avatar);
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false]);
        }
    }

    public function cambiarPassword()
    {
        $id = session()->get('id');
        $contrasenaActual = $this->request->getPost('actual');
        $nueva = $this->request->getPost('contraseña');
        $confirmar = $this->request->getPost('confirmar_contraseña');

        if (!$contrasenaActual || !$nueva || !$confirmar) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Todos los campos son obligatorios'
            ]);
        }

        if (strlen($nueva) < 8) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'La nueva contraseña debe tener al menos 8 caracteres'
            ]);
        }

        if ($nueva !== $confirmar) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Las contraseñas no coinciden'
            ]);
        }

        $usuario = $this->model->find($id);

        if (!$usuario || !password_verify($contrasenaActual, $usuario['contraseña'])) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'La contraseña actual es incorrecta.'
            ]);
        }

        $hashedPassword = password_hash($nueva, PASSWORD_DEFAULT);
        $this->model->update($id, ['contraseña' => $hashedPassword]);

        return $this->response->setJSON([
            'status' => 'ok',
            'message' => 'La contraseña se ha cambiado correctamente.'
        ]);
    }

    public function ajustes()
    {
        return view('ajustesView');
    }

    public function preguntas()
    {
        return view('preguntasView');
    }

    public function dashboard()
    {
        $data['datos'] = $this->model->select('deportistas.*, roles.nombre as rol')
            ->join('roles', 'deportistas.id_rol = roles.id')
            ->findAll();

        return view('usuario/usuariosListView', $data);
    }

    public function nuevo()
    {
        $options = array();
        $options[''] = "-- roles --";

        $roles = $this->modelRoles->findAll();

        foreach($roles as $rol) {
            $options[$rol["id"]] = $rol["nombre"];
        }

        $data["optionsRoles"] = $options;
        return view('usuario/usuariosNewView', $data);
    }

    public function crear()
    {
        $rules = [
            'nombre' => [
                'rules' => 'required|is_unique[deportistas.nombre]',
                'errors' => [
                    'required' => 'El nombre es obligatorio.',
                    'is_unique' => 'El nombre ya está registrado.'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[deportistas.email]',
                'errors' => [
                    'required' => 'El email es obligatorio.',
                    'valid_email' => 'Debes ingresar un email válido.',
                    'is_unique' => 'El email ya está registrado.'
                ]
            ],
            'id_rol' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Debes seleccionar un rol.'
                ]
            ],
            'contraseña' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'La contraseña es obligatoria.',
                    'min_length' => 'La contraseña debe tener al menos 6 caracteres.'
                ]
            ]
        ];

        $datos = $this->request->getPost(array_keys($rules));
        if (!$this->validateData($datos, $rules)) {
            return redirect()->back()->withInput();
        }

        $nombre = $this->request->getVar("nombre");
        $email = $this->request->getVar("email");
        $id_rol = $this->request->getVar("id_rol");
        $password = $this->request->getVar("contraseña");

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $this->model->save([
            'nombre' => $nombre,
            'email' => $email,
            'contraseña' => $hashedPassword,
            'id_rol' => $id_rol,
        ]);

        $idUsuario = $this->model->getInsertID();
        $logros = $this->modelLogro->findAll();
        $this->modelDeportistaLogro->cargarLogrosDeportistas($idUsuario, $logros);

        return redirect()->to('usuarios/listado');
    }


    public function editar()
    {
        $id = desencriptar($this->request->getvar('id'));

        $data['datos'] = $this->model->where('id', $id)->first();

        $options = array();
        $options[''] = "-- roles --";

        $roles = $this->modelRoles->findAll();

        foreach($roles as $rol) {
            $options[$rol["id"]] = $rol["nombre"];
        }

        $data["optionsRoles"] = $options;
        return view('usuario/usuariosEditView', $data);
    } 

    public function actualizar()
    {
        $rules = [
            'nombre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El nombre es obligatorio.'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'El email es obligatorio.',
                    'valid_email' => 'Debes ingresar un email válido.'
                ]
            ],
            'id_rol' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Debes seleccionar un rol.'
                ]
            ]
        ];

        $datos = $this->request->getPost(array_keys($rules));
        if (!$this->validateData($datos, $rules)) {
            return redirect()->back()->withInput();
        }

        $id = desencriptar($this->request->getvar('id'));
        $nombre = $this->request->getVar("nombre");
        $email = $this->request->getVar("email");
        $id_rol = $this->request->getVar("id_rol");

        $this->model->where('id', $id)->set(['nombre'=>$nombre, 'email' => $email, 'id_rol' => $id_rol])->update();

        return redirect()->to('usuarios/listado');
    }

    public function eliminar()
    {
        $id = desencriptar($this->request->getvar('id'));

        $this->modelDeportistaLogro->where('id_deportista', $id)->delete();

        $rutinas = $this->modelRutinas->where('id_deportista', $id)->findAll();
        $rutinaIds = array_column($rutinas, 'id');
        if (!empty($rutinaIds)) {
            $this->modelRutinasEjercicios->whereIn('id_rutina', $rutinaIds)->delete();
        }
        $this->modelRutinas->where('id_deportista', $id)->delete();

        return $this->model->delete($id)
            ? $this->response->setJSON(['success' => true])
            : $this->response->setJSON(['success' => false]);
    }

    //--------------------------------------------------------------------------
    // *: carga la vista de calendario
    // <: [array] 
    //--------------------------------------------------------------------------
    public function calendario()
    {
        $data['datos'] = $this->modelRutinas->findAll();

        return view('calendarioView', $data);
    }

    public function detalleCalendario()
    {
        $fecha = $this->request->getPost('fecha');

        if (!$fecha) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Fecha no proporcionada']);
        }

        $rutinas = $this->rutinaFechaModel->select('rutinas.id, rutinas.nombre, rutinas.descripcion, rutinas.nivel, rutinas.created_at as fecha')
            ->join('rutinas', 'rutinas_fechas.id_rutina = rutinas.id')
            ->where('rutinas.id_deportista', session()->get('id'))
            ->where('rutinas_fechas.fecha', $fecha)
            ->findAll();

        foreach ($rutinas as &$rutina) {
            $rutina['id'] = encriptar($rutina['id']);
        }
        return $this->response->setJSON($rutinas);
    }
}