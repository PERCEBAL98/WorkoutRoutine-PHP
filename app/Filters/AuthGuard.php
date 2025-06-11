<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthGuard implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('usuario')) {
            return redirect()->to('/sigin')->with('error', 'Debes iniciar sesión.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {

    }
}
