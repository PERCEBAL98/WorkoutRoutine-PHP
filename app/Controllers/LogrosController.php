<?php

namespace App\Controllers;

use App\Models\DeportistaModel;
use App\Models\LogroModel;
use App\Models\DeportistaLogroModel;

class LogrosController extends BaseController
{
    protected $helpers = ['form'];
    protected $model;
    protected $modelDeportistaLogro;
    protected $modelDeportista;

    public function __construct()
    {
        $this->model = new LogroModel();
        $this->modelDeportistaLogro = new DeportistaLogroModel();
        $this->modelDeportista = new DeportistaModel();
    }

    //--------------------------------------------------------------------------
    // *: carga la vista de calendario
    // <: [array] 
    //--------------------------------------------------------------------------
    public function index()
    {
        $logros = $this->model->select('
                    logros.id,
                    logros.nombre AS nombre_logro,
                    logros.nivel AS nivel_logro,
                    logros.puntos AS puntos_maximos,
                    deportistas_logros.puntos AS puntos_actuales,
                    deportistas_logros.completado,
                ')
                ->join('deportistas_logros', 'deportistas_logros.id_logro = logros.id', 'inner')
                ->where('deportistas_logros.id_deportista', session()->get('id'))
                ->orderBy('logros.id', 'ASC')
                ->findAll();

            $logrosAgrupados = [];
            foreach ($logros as $logro) {
                $logrosAgrupados[$logro['nombre_logro']][] = $logro;
            }

        $data['datos'] = $logrosAgrupados;

        return view('logro/logrosView', $data);
    }

    public function obtenerLogros()
    {
        $logros = $this->model->select('
                    logros.id,
                    logros.nombre AS nombre_logro,
                    logros.nivel AS nivel_logro,
                    logros.puntos AS puntos_maximos,
                    deportistas_logros.puntos AS puntos_actuales,
                    deportistas_logros.completado,
                ')
                ->join('deportistas_logros', 'deportistas_logros.id_logro = logros.id', 'inner')
                ->where('deportistas_logros.id_deportista', session()->get('id'))
                ->orderBy('logros.id', 'ASC')
                ->findAll();

            $logrosAgrupados = [];
            foreach ($logros as $logro) {
                $logrosAgrupados[$logro['nombre_logro']][] = $logro;
            }

        $response = $logrosAgrupados;

        return $this->response->setJSON($response);
    }

    public function actualizarLogrosRutinasRealizadas() {
        $this->modelDeportistaLogro->actualizarRutinasRealizadas();
    }

    public function dashboard()
    {
        $data['datos'] = $this->model->groupBy('nombre')->findAll();

        return view('logro/logrosListView', $data);
    }
    
    public function nuevo()
    {
        return view('logro/logrosNewView');
    }

    public function crear()
    {
        $rules = [
            'nombre' => [
                'rules' => 'required|is_unique[logros.nombre]',
                'errors' => [
                    'required' => 'Debes introducir un nombre para el logro.',
                    'is_unique' => 'El nombre del logro ya existe.'
                ]
            ],
            'puntos_facil' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Debes introducir la cantidad de puntos.',
                    'integer' => 'Los puntos deben ser un número entero.'
                ]
            ],
            'puntos_normal' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Debes introducir la cantidad de puntos.',
                    'integer' => 'Los puntos deben ser un número entero.'
                ]
            ],
            'puntos_dificil' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Debes introducir la cantidad de puntos.',
                    'integer' => 'Los puntos deben ser un número entero.'
                ]
            ]
        ];

        $facil = (int)$this->request->getVar('puntos_facil');
        $normal = (int)$this->request->getVar('puntos_normal');
        $dificil = (int)$this->request->getVar('puntos_dificil');
        $erroresExtra = [];

        if ($facil > $normal) {
            $erroresExtra['puntos_facil'] = 'Fácil no puede ser mayor que Normal.';
        }

        if ($normal > $dificil) {
            $erroresExtra['puntos_normal'] = 'Normal no puede ser mayor que Difícil.';
        }

        if ($dificil < $normal) {
            $erroresExtra['puntos_dificil'] = 'Difícil no puede ser menor que Normal.';
        }

        $datos = $this->request->getPost(array_keys($rules));
        if (!$this->validateData($datos, $rules)) {
            return redirect()->back()->withInput()->with('erroresExtra', $erroresExtra);
        }

        $logrosCreados = [];
        $usuarios = $this->modelDeportista->select('id')->findAll();
        $nombre = $this->request->getvar('nombre');

        $logrosCreados[] = $this->model->insert(['nombre' => $nombre, 'nivel' => 1, 'puntos' => $facil], true);
        $logrosCreados[] = $this->model->insert(['nombre' => $nombre, 'nivel' => 2, 'puntos' => $normal], true);
        $logrosCreados[] = $this->model->insert(['nombre' => $nombre, 'nivel' => 3, 'puntos' => $dificil], true);

        $this->modelDeportistaLogro->insertBatchDeportistasLogros($logrosCreados, $usuarios);
        return redirect()->to('logros/listado');
    }

    public function editar()
    {
        $id = desencriptar($this->request->getvar('id'));
        $registro = $this->model->find($id);
        $logros = $this->model->where('nombre', $registro['nombre'])->findAll();

        $data['datos'] = [
            'id' => $id,
            'nombre' => $logros[0]['nombre'],
            'puntos_facil' => 0,
            'puntos_normal' => 0,
            'puntos_dificil' => 0
        ];

        foreach ($logros as $logro) {
            switch ($logro['nivel']) {
                case 1:
                    $data['datos']['puntos_facil'] = $logro['puntos'];
                    break;
                case 2:
                    $data['datos']['puntos_normal'] = $logro['puntos'];
                    break;
                case 3:
                    $data['datos']['puntos_dificil'] = $logro['puntos'];
                    break;
            }
        }

        return view('logro/logrosEditView', $data);
    } 

    public function actualizar()
    {
        $rules = [
            'nombre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Debes introducir un nombre para el logro.',
                    'is_unique' => 'El nombre del logro ya existe.'
                ]
            ],
            'puntos_facil' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Debes introducir la cantidad de puntos.',
                    'integer' => 'Los puntos deben ser un número entero.'
                ]
            ],
            'puntos_normal' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Debes introducir la cantidad de puntos.',
                    'integer' => 'Los puntos deben ser un número entero.'
                ]
            ],
            'puntos_dificil' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Debes introducir la cantidad de puntos.',
                    'integer' => 'Los puntos deben ser un número entero.'
                ]
            ]
        ];

        $facil = (int)$this->request->getVar('puntos_facil');
        $normal = (int)$this->request->getVar('puntos_normal');
        $dificil = (int)$this->request->getVar('puntos_dificil');
        $erroresExtra = [];

        if ($facil > $normal) {
            $erroresExtra['puntos_facil'] = 'Fácil no puede ser mayor que Normal.';
        }

        if ($normal > $dificil) {
            $erroresExtra['puntos_normal'] = 'Normal no puede ser mayor que Difícil.';
        }

        if ($dificil < $normal) {
            $erroresExtra['puntos_dificil'] = 'Difícil no puede ser menor que Normal.';
        }

        $datos = $this->request->getPost(array_keys($rules));
        if (!$this->validateData($datos, $rules)) {
            return redirect()->back()->withInput()->with('erroresExtra', $erroresExtra);
        }
        
        $id = desencriptar($this->request->getvar('id'));
        $registro = $this->model->find($id);
        $logros = $this->model->where('nombre', $registro['nombre'])->findAll();
        $nombre = $this->request->getvar('nombre');

        foreach ($logros as $logro) {
            switch ($logro['nivel']) {
                case 1:
                    $this->model->update($logro['id'], [
                        'nombre' => $nombre,
                        'puntos' => $facil
                    ]);
                    break;
                case 2:
                    $this->model->update($logro['id'], [
                        'nombre' => $nombre,
                        'puntos' => $normal
                    ]);
                    break;
                case 3:
                    $this->model->update($logro['id'], [
                        'nombre' => $nombre,
                        'puntos' => $dificil
                    ]);
                    break;
            }
        }

        return redirect()->to('logros/listado');
    }

    public function eliminar()
    {
        $id = desencriptar($this->request->getvar('id'));
        $registro = $this->model->find($id);
        $logros = $this->model->where('nombre', $registro['nombre'])->findAll();
        
        foreach ($logros as $logro) {
            $this->modelDeportistaLogro->where('id_logro', $logro['id'])->delete();
        }

        return $this->model->where('nombre', $registro['nombre'])->delete()
            ? $this->response->setJSON(['success' => true])
            : $this->response->setJSON(['success' => false]);
    }
}