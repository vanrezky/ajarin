<?php

namespace App\Models;

use CodeIgniter\Model;

class TeacherModel extends Model
{
    protected $table = 'teacher_table';
    protected $primaryKey = 'teacher_id';
    protected $allowedFields = ['teacher_name', 'register_date', 'teacher_birthdate', 'subject', 'teacher_phonenumb', 'teacher_email', 'teacher_username', 'teacher_password', 'teacher_image', 'teacher_desc', 'teacher_homebase'];

    protected $validationRules = [
        'teacher_name' => [
            'label' => 'Fullname',
            'rules' => 'required'
        ],
        'teacher_birthdate' => [
            'label' => 'Birth Date',
            'rules' => 'required'
        ],
        'teacher_phonenumb' => [
            'label' => 'Phone Number',
            'rules' => 'required'
        ],
        'teacher_email' => [
            'label' => 'Email',
            'rules' => 'required'
        ],
        'teacher_username' => [
            'label' => 'Username',
            'rules' => 'required|is_unique[teacher_table.teacher_username]',
        ],
        'teacher_password' => [
            'label' => 'Password',
            'rules' => 'required|min_length[3]'
        ],
        'teacher_image' => [
            'label' => 'Image Profile',
            'rules' => 'uploaded[teacher_image]|is_image[teacher_image]'
        ]
    ];
}
