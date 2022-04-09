<?php

namespace App\Models;

use CodeIgniter\Model;

class StudentModel extends Model
{
    protected $table = 'student_table';
    protected $primaryKey = 'student_id';
    protected $allowedFields = ['student_name', 'student_grade', 'student_birthdate', 'student_phonenumb', 'student_email', 'student_username', 'student_password', 'student_image'];

    protected $validationRules = [
        'student_username' => [
            'label' => 'Username',
            'rules' => 'required|is_unique[student_table.student_username]'
        ],
        'student_password' => [
            'label' => 'Password',
            'rules' => 'required|min_length[3]'
        ],
        'student_name' => [
            'label' => 'Full Name',
            'rules' => 'required',

        ],
        'student_birthdate' => [
            'label' => 'Birth Date',
            'rules' => 'required',
        ],
        'student_phonenumb' => [
            'label' => 'Phone Number',
            'rules' => 'required',
        ],
        'student_email' => [
            'label' => 'Email',
            'rules' => 'required|valid_email'
        ],
    ];
}
