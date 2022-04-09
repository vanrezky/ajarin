<?php


namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TeacherModel;
use App\Models\TransactionModel;

class Transaction extends BaseController
{

    public function index()
    {
        $veritrans = service('Veritrans');

        $trans = (new TransactionModel())
            ->join('teacher_table TT', 'TT.teacher_id = transaction_table.teacher_id', 'left')
            ->join('student_table ST', 'ST.student_id = transaction_table.student_id', 'left')
            ->whereNotIn('status_code', ['407', '404'])
            ->orderBy('transaction_time', 'DESC')->find();

        $trans = transaction($trans);


        $data = [
            'title' => 'Teacher',
            'trans' => $trans
        ];

        return view($this::$pagesAdmin . 'v_transaction_index', $data);
    }


    public function receipt()
    {

        $id = $this->request->getGet('id');

        $trans = (new TransactionModel())
            ->join('teacher_table TT', 'TT.teacher_id = transaction_table.teacher_id', 'left')
            ->join('student_table ST', 'ST.student_id = transaction_table.student_id', 'left')
            ->where('status_code', 200)
            ->find($id);

        if ($trans) {
            $data = [
                'title' => 'Payment',
                'trans' => $trans,
            ];

            return view($this::$pagesAdmin . 'v_transaction_receipt', $data);
        }

        show_404("Transaction has not been successful or is not available!");
    }
}
