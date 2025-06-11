<?php
namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
use App\Models\LogroModel;
use App\Models\NotificacionModel;

class DeportistaLogroModel extends Model {
    protected $table = 'deportistas_logros';
    protected $allowedFields = ['id', 'id_deportista', 'id_logro', 'puntos', 'completado', 'created_at', 'updated_at'];

    public function insertBatchDeportistasLogros($logros, $usuarios)
    {
        $dataBatch = [];

        foreach ($usuarios as $usuario) {
            foreach ($logros as $idLogro) {
                $dataBatch[] = [
                    'id_deportista' => $usuario['id'],
                    'id_logro' => $idLogro,
                ];
            }
        }

        $this->insertBatch($dataBatch);

    }

    public function cargarLogrosDeportistas($id_usuario, $logros) 
    {
        foreach ($logros as $logro) {
            $diasConectado = ($logro['id'] == 4 || $logro['id'] == 5 || $logro['id'] == 6) ? 1 : 0;

            $this->insert([
                'id_deportista' => $id_usuario,
                'id_logro' => $logro['id'],
                'puntos' => $diasConectado,
                'completado' => 0,
            ]);
        }
    }

    public function actualizarLogrosDiasConectado() {
        $registros = $this->where('id_deportista', session()->get('id'))
            ->whereIn('id_logro', [4, 5, 6])
            ->where('completado', 0)
            ->where('DATE(updated_at) !=', date('Y-m-d'))
            ->findAll();

        foreach ($registros as $registro) {
            $logro = $this->select('logros.puntos')
                ->join('logros', 'deportistas_logros.id_logro = logros.id')
                ->where('logros.id', $registro['id_logro'])
                ->first();

            if ($logro['puntos'] > $registro['puntos'] + 1) {
                $this->update($registro['id'], [
                    'puntos' => $registro['puntos'] + 1,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            } else {
                $this->update($registro['id'], [
                    'puntos' => $registro['puntos'] + 1,
                    'completado' => 1,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
                                
                $logroModelo = new LogroModel();
                $logro = $logroModelo->select('nombre, nivel')->where('id', $registro['id_logro'])->first();
                $nombre = $logro['nombre'] ?? 'desconocido';
                if ($logro['nivel'] == 1) {
                    $nivel = "fácil";
                }
                elseif ($logro['nivel'] == 2) {
                    $nivel = "normal";
                }
                elseif ($logro['nivel'] == 3) {
                    $nivel = "difícil";
                }

                $notificacionModelo = new NotificacionModel();
                $notificacionModelo->insert([
                    'id_deportista' => session()->get('id'),
                    'tipo' => 'logro',
                    'titulo' => '¡Logro completado!',
                    'mensaje' => 'Has completado el logro: ' . $nombre . ' (nivel ' . $nivel . ')',
                    'imagen' => 'logro.svg'
                ]);
            }
        }
    }

    public function actualizarRutinasRealizadas() {
        $registros = $this->where('id_deportista', session()->get('id'))
            ->whereIn('id_logro', [1, 2, 3])
            ->where('completado', 0)
            ->findAll();

        foreach ($registros as $registro) {
            $logro = $this->select('logros.puntos')
                ->join('logros', 'deportistas_logros.id_logro = logros.id')
                ->where('logros.id', $registro['id_logro'])
                ->first();

            if ($logro['puntos'] > $registro['puntos'] + 1) {
                $this->update($registro['id'], [
                    'puntos' => $registro['puntos'] + 1,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            } else {
                $this->update($registro['id'], [
                    'puntos' => $registro['puntos'] + 1,
                    'completado' => 1,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                $logroModelo = new LogroModel();
                $logro = $logroModelo->select('nombre, nivel')->where('id', $registro['id_logro'])->first();
                $nombre = $logro['nombre'] ?? 'desconocido';
                if ($logro['nivel'] == 1) {
                    $nivel = "fácil";
                }
                elseif ($logro['nivel'] == 2) {
                    $nivel = "normal";
                }
                elseif ($logro['nivel'] == 3) {
                    $nivel = "difícil";
                }

                $notificacionModelo = new NotificacionModel();
                $notificacionModelo->insert([
                    'id_deportista' => session()->get('id'),
                    'tipo' => 'logro',
                    'titulo' => '¡Logro completado!',
                    'mensaje' => 'Has completado el logro: ' . $nombre . ' (nivel ' . $nivel . ')',
                    'imagen' => 'logro.svg'
                ]);
            }
        }
    }
}
?>