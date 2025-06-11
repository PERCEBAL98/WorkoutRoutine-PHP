<?php
namespace App\Controllers;

use App\Models\RoleModel;

class RolesController extends BaseController
{
    protected $helpers = ['form'];
    protected $model;

    public function __construct()
    {
        $this->model = new RoleModel();
    }

    public function dashboard()
    {
        $data['datos'] = $this->model->findAll();

        return view('rol/rolesListView', $data);
    }

    public function nuevo()
    {
        return view('rol/rolesNewView');
    }

    public function crear()
    {
        $rules = [
            'nombre' => [
                'rules' => 'required|is_unique[roles.nombre]',
                'errors' => [
                    'required' => 'Debes introducir un nombre para el rol.',
                    'is_unique' => 'El nombre del rol ya existe.'
                ]
            ]
        ];

        $datos = $this->request->getPost(array_keys($rules));
        if (!$this->validateData($datos, $rules)) {
            return redirect()->back()->withInput();
        }

        $nombre = $this->request->getvar('nombre');

        $newData = [
            'nombre'=>$nombre
        ];

        $this->model->save($newData);

        return redirect()->to('roles/listado');
    }

    public function editar()
    {
        $id = desencriptar($this->request->getvar('id'));

        $data['datos'] = $this->model->where('id', $id)->first();

        return view('rol/rolesEditView', $data);
    } 

    public function actualizar()
    {
        $rules = [
            'nombre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Debes introducir un nombre para el rol.'
                ]
            ]
        ];

        $datos = $this->request->getPost(array_keys($rules));
        if (!$this->validateData($datos, $rules)) {
            return redirect()->back()->withInput();
        }

        $id = desencriptar($this->request->getvar('id'));
        $nombre = $this->request->getvar('nombre');

        $this->model->where('id', $id)->set(['nombre'=>$nombre])->update();

        return redirect()->to('roles/listado');
    }

    public function eliminar()
    {
        return $this->model->delete(desencriptar($this->request->getvar('id')))
            ? $this->response->setJSON(['success' => true])
            : $this->response->setJSON(['success' => false]);
    }
}
