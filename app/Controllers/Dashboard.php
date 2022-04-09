<?php

namespace App\Controllers;

use App\Models\SemesterModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard'
        ];

        if (session('_ci_user_login.level') == 'operator') {
            $data['semester'] = (new SemesterModel())->select('id_smt, nm_smt, a_periode_aktif')->notLike('id_smt', '3', 'before')->orderBy('id_smt', 'DESC')->limit('9')->get()->getResultArray();
        }
        return view('v_dashboard_index', $data);
    }
}
