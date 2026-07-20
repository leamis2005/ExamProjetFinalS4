<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Auth implements FilterInterface {
    public function before(RequestInterface $request, $arguments = null) {
        $session = session();

        if (!$session->get('client_id') && !$session->get('admin_id')) {
            return redirect()->to('login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
    }
}

?>
