<?php

namespace App\Controllers;

use App\Models\ChatModel;
use App\Models\TeacherModel;
use App\Models\TransactionModel;

class Teacher extends BaseController
{
    protected static $pages = 'frontend/pages/';

    public function __construct()
    {
        $this->teacher = new TeacherModel();
    }

    public function index()
    {

        $trans = (new TransactionModel())
            ->join('student_table ST', 'ST.student_id = transaction_table.student_id', 'left')
            ->where('discuss_status', 1)
            ->where(['transaction_table.teacher_id' => session('_ci_user_login.id')])
            ->orderBy('transaction_time', 'DESC')->find();

        $trans = transaction($trans);

        $data = [
            'title' => 'Teacher Dashboard',
            'trans' => $trans
        ];

        return view($this::$pages . 'v_teacher_index', $data);
    }

    public function discuss()
    {

        $teacher_id = session('_ci_user_login.id');
        $trans_id = $this->request->getGet('trans_id');

        $transaction = (new TransactionModel())
            ->join('teacher_table TT', 'TT.teacher_id = transaction_table.teacher_id', 'left')
            ->join('student_table ST', 'ST.student_id = transaction_table.student_id', 'left')
            ->where(['transaction_table.teacher_id' => $teacher_id, 'discuss_status' => 1])->orderBy('discuss_date', 'DESC')->find();

        if ($transaction) {

            foreach ($transaction as $key => $value) {
                if ($key == 0) {
                    $first_trans_id = $value['transaction_id'];
                }
                // $last_chat = (new ChatModel())->where(['transaction_id' => $value['transaction_id'], 'student_id' => $value['student_id']])->orderBy('chat_id', 'DESC')->first();
                $chat = (new ChatModel())->where(['transaction_id' => $value['transaction_id']])->orderBy('chat_id', 'ASC')->find();
                $transaction[$key]['chat'] = $chat;
                $transaction[$key]['last_chat'] = [];
            }

            $data = [
                'title' => 'Discuss',
                'transaction_id' => $trans_id,
                'transaction' => $transaction,
                'first_trans_id' => $first_trans_id

            ];

            return view($this::$pages . 'v_teacher_discuss', $data);
            // return to disccusion
        }


        show_404("Discussion not found or empty!");
    }


    public function profile()
    {

        $ses = session('_ci_user_login');
        $profile = $this->teacher->find($ses['id']);


        if ($this->request->getMethod() == 'post') {

            $rules = $this->teacher->getValidationRules(); // get rules
            $password = $this->request->getPost('teacher_password');
            unset($rules['teacher_username'], $rules['teacher_image']);

            if ($password == "") {
                unset($rules['teacher_password']);
            }

            $this->teacher->setValidationRules($rules);
            $valid = $this->validate($rules); // validate

            if ($valid) {

                $image = $this->request->getFile('teacher_image');
                $namaGambar = $profile['teacher_image'];
                if ($image->getError() != 4) {
                    $namaGambar = $image->getRandomName();
                    $image->move('uploads/images', $namaGambar);

                    if ($profile['teacher_image'] != 'default_teacher.png') { // hapus gambar lama
                        try {
                            unlink('uploads/images/' . $profile['teacher_image']);
                        } catch (\Throwable $th) {
                            //throw $th;
                        }
                    }
                }

                $teacher = [
                    'teacher_name' => $this->request->getPost('teacher_name'),
                    'teacher_birthdate' => $this->request->getPost('teacher_birthdate'),
                    'teacher_phonenumb' => $this->request->getPost('teacher_phonenumb'),
                    'teacher_email' => $this->request->getPost('teacher_email'),
                    'teacher_image' => $namaGambar,
                ];

                if ($password != "") {
                    $teacher['teacher_password'] = password_hash($password, PASSWORD_DEFAULT);
                }

                $upd = $this->teacher->update($profile['teacher_id'], $teacher);

                if ($upd) {
                    return redirect()->back()->with('message', pesan('success', 'Account Updated Successfully'));
                } else {
                    $message = pesan('danger', 'failed to save data, please try again!');
                }
            } else {

                $validation = \Config\Services::validation();
                $message = pesan('danger', $validation->listErrors());
            }

            return redirect()->back()->with('message', $message);
        }

        $data = [
            'title' => 'Profile',
            'profile' => $profile,
        ];
        return view($this::$pages . 'v_teacher_profile', $data);
    }
}
