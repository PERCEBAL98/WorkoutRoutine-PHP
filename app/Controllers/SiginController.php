<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\DeportistaModel;
use App\Models\LogroModel;
use App\Models\DeportistaLogroModel;

class SiginController extends BaseController
{
    protected $helpers = ['form'];
    protected $deportistaModel;
    protected $logroModel;
    protected $deportistaLogroModel;

    public function __construct()
    {
        $this->deportistaModel = new DeportistaModel();
        $this->logroModel = new LogroModel();
        $this->deportistaLogroModel = new DeportistaLogroModel();
    }

    public function index() {
        if (session()->get('id_rol') == 1) {
            return redirect()->to('/ejercicios/listado');
        } else {
            return redirect()->to('/ejercicios');
        }
    }

    public function login() {
        return view('loginView');
    }

    public function loginAuth()
    {
        if (!$this->validate([
            'usuario' => 'required',
            'contraseña' => 'required',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $usuario = $this->request->getVar("usuario");
        $password = $this->request->getVar("contraseña");

        $data = $this->deportistaModel->obtenerUsuarioLogin($usuario);

        if ($data) {
            $hashedPassword = $data["contraseña"];
            if (password_verify($password, $hashedPassword)) {
                $ses_data = [
                    'id' => $data['id'],
                    'usuario' => $data['nombre'],
                    'email' => $data['email'],
                    'avatar' => $data['avatar'],
                    'plan' => $data['plan'],
                    'id_rol' => $data['id_rol'],
                    'rol' => $data['rol_nombre']
                ];
                $session = session();
                $session->set($ses_data);

                $this->deportistaLogroModel->actualizarLogrosDiasConectado();

                return redirect()->to('/');
            }
        }

        return redirect()->to('/sigin')->with('error', 'Usuario o contraseña incorrectos');
    }

    public function register()
    {
        return view('registerView');
    }

    // Registrar un nuevo usuario
    public function registerUser()
    {
        if (!$this->validate([
            'usuario' => 'required|is_unique[deportistas.nombre]',
            'email' => 'required|valid_email|is_unique[deportistas.email]',
            'contraseña' => 'required|min_length[6]',
            'confirmar_contraseña' => 'required|matches[contraseña]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $usuario = $this->request->getVar("usuario");
        $email = $this->request->getVar("email");
        $password = $this->request->getVar("contraseña");

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $usuario = $this->deportistaModel->save([
            'nombre' => $usuario,
            'email' => $email,
            'contraseña' => $hashedPassword,
            'id_rol' => 2,
        ]);

        $idUsuario = $this->deportistaModel->getInsertID();
        $logros = $this->logroModel->findAll();
        $this->deportistaLogroModel->cargarLogrosDeportistas($idUsuario, $logros);

        return redirect()->to('/sigin')->with('success', 'Registro exitoso. Por favor, inicia sesión.');
    }

    public function logout()
    {
        $session = session();
        $ses_data = [
            'id' => '',
            'usuario' => '',
            'email' => '',
            'avatar' => '',
            'id_roles' => '',
            'role' => ''
        ];
        $session->set($ses_data);
        $session->destroy();
        return redirect()->to('/');
    }
}
