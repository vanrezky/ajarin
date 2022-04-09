<?php

namespace App\Controllers;

use App\Models\StudentModel;
use App\Models\TeacherModel;

class Home extends BaseController
{
    protected static $pages = 'frontend/pages/';

    public function index()
    {
        $data = [
            'title' => 'Home'
        ];

        return view($this::$pages . 'v_index', $data);
    }

    public function appoinment()
    {
        if (session()->has('_ci_user_login') and in_array(session('_ci_user_login.level'), ['student', 'teacher'])) {
            return redirect()->to(session('_ci_user_login.level'));
        }

        $data = [
            'title' => 'Appoinment'
        ];

        return view($this::$pages . 'v_appointment', $data);
    }


    public function signin()
    {

        if (session()->has('_ci_user_login') and in_array(session('_ci_user_login.level'), ['student', 'teacher'])) {
            return redirect()->to(session('_ci_user_login.level'));
        }

        $actor = $this->request->getGet('act');

        if ($this->request->getMethod() == 'post') {

            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            $message = pesan('danger', 'Please fill username and password first!');

            if (!empty($username) && !empty($password)) {

                // checking
                if ($actor == 'student') {

                    // check to table student
                    $student = (new StudentModel())->where('student_username', $username)->first();

                    if ($student) {
                        if (password_verify($password, $student['student_password'])) {

                            $sess = [
                                'id' => $student['student_id'],
                                'name' => $student['student_name'],
                                'username' => $student['student_username'],
                                'level' => 'student'
                            ];

                            session()->set('_ci_user_login', $sess);
                            return redirect()->to($sess['level'])->with('message', 'Welcome ' . $sess['name']);
                        } else {
                            $message = pesan('danger', 'username or password not correct!');
                        }
                    } else {
                        $message = pesan('danger', 'account not found, want to create one ?');
                    }
                } else {
                    // check to table teacher

                    $teacher = (new TeacherModel())->where('teacher_username', $username)->first();

                    if ($teacher) {
                        if (password_verify($password, $teacher['teacher_password'])) {

                            $sess = [
                                'id' => $teacher['teacher_id'],
                                'name' => $teacher['teacher_name'],
                                'username' => $teacher['teacher_username'],
                                'level' => 'teacher'
                            ];

                            session()->set('_ci_user_login', $sess);
                            return redirect()->to($sess['level'])->with('message', 'Welcome ' . $sess['name']);
                        } else {
                            $message = pesan('danger', 'username or password not correct!');
                        }
                    } else {
                        $message = pesan('danger', 'account not found!');
                    }
                }
            }

            return redirect()->back()->with('message', $message);
        }

        $data = [
            'title' => 'Sign In'
        ];

        if ($actor == 'student') {
            return view($this::$pages . 'v_signin_student', $data);
        } else {
            return view($this::$pages . 'v_signin_teacher', $data);
        }
    }


    public function signup() // just for student
    {

        if ($this->request->getMethod() == 'post') {

            $rules = (new StudentModel())->getValidationRules(); // get rules
            $valid = $this->validate($rules); // validate

            if ($valid) {
                $student = [
                    'student_username' => $this->request->getPost('student_username'),
                    'student_password' => password_hash($this->request->getPost('student_password'), PASSWORD_DEFAULT),
                    'student_name' => $this->request->getPost('student_name'),
                    'student_birthdate' => $this->request->getPost('student_birthdate'),
                    'student_phonenumb' => $this->request->getPost('student_phonenumb'),
                    'student_email' => $this->request->getPost('student_email'),
                ];

                $insert = (new StudentModel())->insert($student);

                if ($insert) {
                    return redirect()->to('signin?act=student')->with('message', pesan('success', 'Account Created Successfully'));
                } else {
                    $message = pesan('danger', 'failed to save data, please try again!');
                }
            } else {

                $validation = \Config\Services::validation();
                $message = pesan('danger', $validation->listErrors());
            }

            return redirect()->to('signup')->withInput()->with('message', $message);
        }
        $data = [
            'title' => 'Sign Up'
        ];

        return view($this::$pages . 'v_signup_student', $data);
    }

    public function logout()
    {

        session()->remove('_ci_user_login');

        return redirect()->to('/');
    }
}
