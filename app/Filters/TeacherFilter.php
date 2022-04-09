<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class TeacherFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (session('_ci_user_login.level') !== 'teacher') {
            return redirect()->to(route_to('logout'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
