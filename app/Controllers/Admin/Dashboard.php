<?php


namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\StudentModel;
use App\Models\TransactionModel;

class Dashboard extends BaseController
{

    protected $pages = 'backend/pages/';

    public function index()
    {

        // $teacher = (new TeacherModel())->findAll();
        $transaction =  (new TransactionModel());
        $data = [
            'title' => 'Dashboard',
            'monthlyEarning' => $transaction->select('SUM(gross_amount) as total')->where('status_code', 200)->where("MONTH(transaction_time) =" . date('m'))->get()->getRow()->total,
            'annualEarning' => $transaction->select('SUM(gross_amount) as total')->where('status_code', 200)->get()->getRow()->total,
            'student' => (new StudentModel())->countAllResults(),
            'pending' => $transaction->where('status_code', 201)->countAllResults(),
        ];

        return view($this->pages . 'v_dashboard_index', $data);
    }
}
