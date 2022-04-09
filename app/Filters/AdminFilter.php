<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {

        // get the current URL path, like "auth/login"
        $currentURIPath = "/{$request->uri->getPath()}";

        // check if the current path is auth path, just return true
        // don't forget to use named routes to simplify the call
        if (in_array($currentURIPath, [route_to('admin/login'), route_to('admin/logout')])) {
            return;
        }

        if (!session()->has('_ci_admin_login')) {
            return redirect()->to(route_to('admin/logout'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
