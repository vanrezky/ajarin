<?php


namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\StudentModel;

class Student extends BaseController
{

    public function index()
    {

        $student = (new StudentModel())->findAll();

        $data = [
            'title' => 'Data Student',
            'student' => $student
        ];

        return view($this::$pagesAdmin . 'v_student_index', $data);
    }


    // public function data($id = '')
    // {
    //     $admin = (new StudentModel())->find($id);

    //     if ($this->request->getMethod() == 'post') {
    //         $validasi = [
    //             'admin_name' => [
    //                 'label' => 'Fullname',
    //                 'rules' => 'required'
    //             ],
    //             'admin_username' => [
    //                 'label' => 'Username',
    //                 'rules' => 'required|is_unique[admin_table.admin_username]',
    //             ],
    //             'admin_password' => [
    //                 'label' => 'Password',
    //                 'rules' => 'required|min_length[3]'
    //             ]
    //         ];

    //         if ($admin) {
    //             $validasi['admin_username']['rules'] = "required|is_unique[admin_table.admin_username,admin_id,{$id}]";
    //             unset($validasi['admin_password']);
    //         }

    //         $valid = $this->validate($validasi);

    //         if ($valid) {
    //             $data = [
    //                 'admin_name' => $this->request->getVar('admin_name'),
    //                 'admin_username' => $this->request->getVar('admin_username'),
    //             ];

    //             if ($admin) {
    //                 if (!empty($this->request->getVar('admin_password')))
    //                     $data['admin_password'] = password_hash($this->request->getVar('admin_password'), PASSWORD_DEFAULT);

    //                 (new StudentModel())->update($id, $data);
    //                 $pesan = 'Data saved successfully';
    //             } else {

    //                 $data['admin_password'] = password_hash($this->request->getVar('admin_password'), PASSWORD_DEFAULT);
    //                 (new StudentModel())->insert($data);
    //                 $pesan = 'Data updated successfully';
    //             }

    //             return redirect()->to('admin/user')->with('message', pesan('success', $pesan));
    //         } else {
    //             $validation = \Config\Services::validation();
    //             return redirect()->back()->withInput()->with('message', pesan('danger', $validation->listErrors()));
    //         }
    //     }

    //     $data = [
    //         'title' => $id == '' ? 'Add Data' : 'Update Data',
    //         'admin' => $id == '' ?  [] : $admin
    //     ];

    //     return view($this::$pagesAdmin . 'v_user_data', $data);
    // }


    public function delete($id)
    {

        $data = (new StudentModel())->find($id);


        $message = pesan('danger', 'data not found!');

        if ($data) {

            (new StudentModel())->delete($id);
            $message = pesan('success', 'Data deleted successfully!');
        }

        return redirect()->back()->with('message', $message);
    }
}
