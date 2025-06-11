<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthGuardIsAdmin implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $language = session()->get('language_preference') ?? 'es';
        service('language')->setLocale($language);

        if (!session()->get('usuario')) {
            return redirect()->to('/sigin');
        }

        if (!session()->has('id_rol') || session()->get('id_rol') != 1) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        
    }
}
