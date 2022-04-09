<?php


namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TeacherModel;

class Teacher extends BaseController
{

    public function index()
    {

        $teacher = (new TeacherModel())->orderBy('teacher_id', 'DESC')->findAll();

        $data = [
            'title' => 'Teacher',
            'teacher' => $teacher
        ];

        return view($this::$pagesAdmin . 'v_teacher_index', $data);
    }

    public function data($id = '')
    {
        $teacher = (new TeacherModel())->find($id);

        if ($this->request->getMethod() == 'post') {
            $rules = (new TeacherModel())->getValidationRules();
            if ($teacher) {
                $rules['teacher_username']['rules'] = "required|is_unique[teacher_table.teacher_username,teacher_id,{$id}]";
                unset($rules['teacher_password'], $rules['teacher_image']);
            }

            (new TeacherModel())->setValidationRules($rules);

            $valid = $this->validate($rules);

            if ($valid) {

                $image = $this->request->getFile('teacher_image');
                $namaGambar = isset($teacher['teacher_image']) ? $teacher['teacher_image'] : '';
                if ($image->getError() != 4) {
                    $namaGambar = $image->getRandomName();
                    $image->move('uploads/images', $namaGambar);

                    if ($teacher) { // hapus gambar lama
                        try {
                            unlink('uploads/images/' . $teacher['teacher_image']);
                        } catch (\Throwable $th) {
                            //throw $th;
                        }
                    }
                }

                $data = [
                    'teacher_name' => $this->request->getVar('teacher_name'),
                    'teacher_birthdate' => $this->request->getVar('teacher_birthdate'),
                    'teacher_phonenumb' => $this->request->getVar('teacher_phonenumb'),
                    'teacher_email' => $this->request->getVar('teacher_email'),
                    'teacher_username' => $this->request->getVar('teacher_username'),
                    'teacher_desc' => $this->request->getVar('teacher_desc'),
                    'teacher_image' => $namaGambar,
                    'teacher_homebase' => json_encode($this->request->getVar('teacher_homebase'))

                ];

                if ($teacher) {
                    if (!empty($this->request->getVar('teacher_password')))
                        $data['teacher_password'] = password_hash($this->request->getVar('teacher_password'), PASSWORD_DEFAULT);

                    (new TeacherModel())->update($id, $data);
                    $pesan = 'Data saved successfully';
                } else {
                    $data['register_date'] = date('Y-m-d');
                    $data['teacher_password'] = password_hash($this->request->getVar('teacher_password'), PASSWORD_DEFAULT);
                    (new TeacherModel())->insert($data);
                    $pesan = 'Data updated successfully';
                }

                return redirect()->to('admin/teacher')->with('message', pesan('success', $pesan));
            } else {
                $validation = \Config\Services::validation();
                return redirect()->back()->withInput()->with('message', pesan('danger', $validation->listErrors()));
            }
        }

        $data = [
            'title' => $id == '' ? 'Add Data' : 'Update Data',
            'teacher' => $id == '' ?  [] : $teacher
        ];

        return view($this::$pagesAdmin . 'v_teacher_data', $data);
    }


    public function delete($id)
    {

        $data = (new TeacherModel())->find($id);


        $message = pesan('danger', 'data not found!');

        if ($data) {
            try {
                unlink('uploads/images/' . $data['teacher_image']);
            } catch (\Throwable $th) {
                //throw $th;
            }

            (new TeacherModel())->delete($id);
            $message = pesan('success', 'Data deleted successfully!');
        }

        return redirect()->back()->with('message', $message);
    }
}
