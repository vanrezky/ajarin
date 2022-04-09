<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\AdminModel;

class Auth extends BaseController
{

    public function index()
    {
        if (session()->has('_ci_admin_login')) {
            return redirect()->to('admin');
        }

        if ($this->request->getMethod() == 'post') {

            $valid = $this->validate([
                'username' => [
                    'label' => 'Username',
                    'rules' => 'required',

                ],
                'password' => [
                    'label' => 'Password',
                    'rules' => 'required',
                ]
            ]);

            if ($valid) {

                $username = $this->request->getPost('username');
                $password = $this->request->getPost('password');

                $admin = (new AdminModel())->where('admin_username', $username)->first();

                if ($admin) {
                    if (password_verify($password, $admin['admin_password'])) {

                        session()->set('_ci_admin_login', [
                            'id' => $admin['admin_id'],
                            'name' => $admin['admin_name'],
                            'level' => 'admin'
                        ]);

                        return redirect()->to(route_to('admin'));
                    }
                }


                return redirect()->back()->with('message', pesan('danger', 'Username atau password salah!'));
            } else {
                $validation = \Config\Services::validation();
                return redirect()->back()->with('message', pesan('danger', $validation->listErrors()));
            }
        }


        $data = [
            'title' => 'Login',
        ];
        return view($this::$pagesAdmin . 'v_auth_login', $data);
    }

    public function logout()
    {

        session()->remove('_ci_admin_login');
        return redirect()->to('admin/login');
    }
}
