<?php

namespace App\Controllers;

use App\Models\ChatModel;
use App\Models\StudentModel;
use App\Models\TeacherModel;
use App\Models\TransactionModel;

class Student extends BaseController
{
    protected static $pages = 'frontend/pages/';

    protected static $default_minutes = 30; //30 minute
    protected static $default_amount = 15000; //15k

    public function __construct()
    {

        $this->student = new StudentModel();
        $this->teacher = new TeacherModel();
        $this->transaction = new TransactionModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'teachers' => $this->teacher->findAll()
        ];

        return view($this::$pages . 'v_student_index', $data);
    }

    public function teacherDetail()
    {

        $id = $this->request->getGet('id');
        $teacher = $this->teacher->find($id);

        if ($teacher) {

            $data = [
                'title' => 'Techer Detail',
                'teacher' => $teacher
            ];

            return view($this::$pages . 'v_student_teacher_detail', $data);
        } else {

            // not found
        }
    }


    public function discuss()
    {

        // check transaction
        $teacher_id = $this->request->getVar('id');
        $student_id = session('_ci_user_login.id');
        $trans_id = $this->request->getVar('trans_id');
        $today = current_timestamp();

        if ($trans_id != "") {
            $transaction = $this->transaction
                ->join('teacher_table TT', 'TT.teacher_id = transaction_table.teacher_id', 'left')
                ->join('student_table ST', 'ST.student_id = transaction_table.student_id', 'left')
                ->where(['transaction_table.student_id' => $student_id, 'status_code' => 200, 'discuss_status' => 1])->orderBy('discuss_date', 'DESC')->find();
        } else {
            $transaction = $this->transaction->where(['transaction_table.teacher_id' => $teacher_id, 'transaction_table.student_id' => $student_id, 'discuss_status' => 1])
                ->join('teacher_table TT', 'TT.teacher_id = transaction_table.teacher_id', 'left')
                ->join('student_table ST', 'ST.student_id = transaction_table.student_id', 'left')
                ->where("discuss_date >= '$today' and discuss_date <= '$today'")->first();
        }

        if ($transaction) {

            foreach ($transaction as $key => $value) {
                if ($key == 0) {
                    $first_trans_id = $value['transaction_id'];
                }
                // $last_chat = (new ChatModel())->where(['transaction_id' => $value['transaction_id'], 'teacher_id' => $value['teacher_id']])->orderBy('chat_id', 'DESC')->first();
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

            return view($this::$pages . 'v_student_discuss', $data);
            // return to disccusion
        }

        return redirect()->to('student/payment?id=' . $teacher_id);
    }


    public function payment()
    {
        // $midtrans = service('Midtrans');
        $config = config('Midtrans');
        $teacher_id = $this->request->getGet('id');

        if ($this->request->getMethod() == 'post') {

            $result_type = $this->request->getVar('result_type');
            $result_data = $this->request->getVar('result_data');

            $data = json_decode($result_data, true);

            $insert  = [
                'transaction_id' => $data['order_id'],
                'transaction_time' => $data['transaction_time'],
                'gross_amount' => session('teacher_ordered.gross_amount'),
                'status_code' => $data['status_code'],
                'transaction_status' => $data['transaction_status'],
                'payment_type' => $data['payment_type'],
                'transaction_json' => $result_data,
                'student_id' => session('_ci_user_login.id'),
                'teacher_id' => session('teacher_ordered.teacher_id'),
                'quantity' => session('teacher_ordered.quantity'),
                'discuss_homebase' => session('teacher_ordered.homebase'),
            ];

            $this->transaction->insert($insert);
            session()->remove('teacher_id_ordered');

            $midtrans = \Codenom\Midtrans\Parse\JSONParse::decodeToObject($result_data);
            return redirect()->to('student/payment/history');
        }

        $encrypter = \Config\Services::encrypter();
        $teacher = $this->teacher->find($teacher_id);

        if ($teacher) {
            $data = [
                'title' => 'Payment',
                'idMerchant' => $config->idMerchant,
                'teacher' => $teacher,
                'teacherEncryptID' => base64_encode($encrypter->encrypt($teacher_id)),
            ];

            return view($this::$pages . 'v_student_payment', $data);
        }

        show_404();
    }



    public function token()
    {

        if ($this->request->isAJAX()) {

            $midtrans = service('Midtrans');
            $encrypter = \Config\Services::encrypter();



            $quantity = $this->request->getPost('quantity');
            $homebase = $this->request->getPost('discuss_homebase');

            $teacher_id = $this->request->getVar('id');

            $message = ['success' => false, 'message' => 'The process cannot be carried out, please try again!'];

            try {
                $teacherEncryptID = $encrypter->decrypt(base64_decode($this->request->getVar('encrypt_id')));
            } catch (\Throwable $th) {

                $teacherEncryptID = false;
            }

            if ($teacherEncryptID) {
                if ($teacher_id == $teacherEncryptID) {
                    $student = $this->student->find(session('_ci_user_login.id'));
                    $teacher = $this->teacher->find($teacher_id);


                    // Required
                    $transaction_details = array(
                        'order_id' => rand(),
                        // 'gross_amount' => $default_amount * $quantity, // no decimal allowed for creditcard
                        'gross_amount' => 1000, // no decimal allowed for creditcard
                    );

                    // Optional
                    $teacher_name = explode(" ", $teacher['teacher_name']);
                    $item1_details = array(
                        'id' => rand(1, 99999),
                        // 'price' => $default_amount,
                        // 'quantity' => $quantity,
                        'price' => 1000,
                        'quantity' => 1,
                        'name' => "Subject: " . teacher_homebase($homebase) . ", Teacher: " . $teacher_name[0] . ".."
                    );

                    // Optional
                    // $item2_details = array(
                    //     'id' => 'a2',
                    //     'price' => 20000,
                    //     'quantity' => 2,
                    //     'name' => "Orange"
                    // );

                    // Optional
                    // $item_details = array($item1_details, $item2_details);

                    // Optional
                    // $billing_address = array(
                    //     'first_name'    => $teacher['teacher_name'],
                    //     'last_name'     => "",
                    //     'address'       => "Mangga 20",
                    //     'city'          => "Jakarta",
                    //     'postal_code'   => "16602",
                    //     'phone'         => "085161612323",
                    //     'country_code'  => 'IDN'
                    // );

                    // Optional
                    // $shipping_address = array(
                    //     'first_name'    => "Obet",
                    //     'last_name'     => "Supriadi",
                    //     'address'       => "Manggis 90",
                    //     'city'          => "Jakarta",
                    //     'postal_code'   => "16601",
                    //     'phone'         => "085161612323",
                    //     'country_code'  => 'IDN'
                    // );

                    // Optional
                    $customer_details = array(
                        'first_name'    => $student['student_name'],
                        'last_name'     => "",
                        'email'         => $student['student_email'],
                        'phone'         => $student['student_phonenumb'],
                        // 'billing_address'  => $billing_address,
                        // 'shipping_address' => $shipping_address
                    );

                    // Data yang akan dikirim untuk request redirect_url.
                    $credit_card['secure'] = true;
                    //ser save_card true to enable oneclick or 2click
                    //$credit_card['save_card'] = true;

                    $time = time();
                    $custom_expiry = array(
                        'start_time' => date("Y-m-d H:i:s O", $time),
                        'unit' => 'minute',
                        'duration'  => 10
                    );

                    $transaction_data = array(
                        'transaction_details' => $transaction_details,
                        'item_details'       => $item1_details,
                        'customer_details'   => $customer_details,
                        'credit_card'        => $credit_card,
                        'expiry'             => $custom_expiry
                    );

                    error_log(json_encode($transaction_data));

                    $snapToken = $midtrans->getSnapToken($transaction_data);

                    //response token
                    $token =  $snapToken->token;


                    // set session teacher order
                    session()->set('teacher_ordered', [
                        'teacher_id' => $teacher_id,
                        'quantity' => $quantity,
                        'homebase' => $homebase,
                        'gross_amount' => $quantity * $this::$default_amount,
                    ]);

                    $message = ['success' => true, 'message' => 'Generate Token Successfully!', 'token' => $token];
                }
            }

            echo json_encode($message);
        }
    }


    public function finish()
    {

        $id = $this->request->getGet('id');

        $trans = $this->transaction
            ->join('teacher_table TT', 'TT.teacher_id = transaction_table.teacher_id', 'left')
            ->join('student_table ST', 'ST.student_id = transaction_table.student_id', 'left')
            ->where('status_code', 200)
            ->find($id);

        if ($trans) {
            $data = [
                'title' => 'Payment',
                'trans' => $trans,
            ];

            return view($this::$pages . 'v_student_payment_finish', $data);
        }

        show_404("Transaction has not been successful or is not available!");
    }


    public function history()
    {

        $trans = $this->status();

        $data = [
            'title' => 'History Payment',
            'trans' => $trans
        ];

        return view($this::$pages . 'v_student_payment_history', $data);
    }


    public function status()
    {

        $trans = $this->transaction
            ->join('teacher_table TT', 'TT.teacher_id = transaction_table.teacher_id', 'left')
            ->whereNotIn('status_code', ['407', '404'])
            ->where(['student_id' => session('_ci_user_login.id')])
            ->orderBy('transaction_time', 'DESC')->find();

        $trans = transaction($trans);

        if ($this->request->isAJAX()) {
            echo json_encode($trans);
            die;
        }

        return $trans;
    }


    public function chat()
    {
        if ($this->request->isAJAX()) {

            $data = $this->request->getPost();
            $sess = session('_ci_user_login');
            $transaction = $this->transaction->find($data['transaction_id']);

            $D = [
                'success' => FALSE,
                'message' => 'Failed',
            ];

            if ($transaction) {

                $today = current_timestamp();

                if ($today <= expired($transaction['discuss_date'], $transaction['quantity'])) {

                    $image = $this->request->getFile('image');

                    $ins = [
                        'transaction_id' => $data['transaction_id'],
                        'chat_text' => $data['chat_text'],
                        $sess['level'] . '_id' => $sess['id'],
                        'chat_date' => current_timestamp()
                    ];

                    $namaGambar = false;

                    if ($image->getError() != 4) {
                        $namaGambar = $image->getRandomName();
                        $image->move('uploads/images', $namaGambar);

                        $ins['chat_text'] = "";
                        $ins['chat_type'] = 'image';
                        $ins['chat_image'] = $namaGambar;
                    }

                    if ($sess['level'] == 'student') {
                        $member = $this->student->select('student_name name, student_image image')->find($sess['id']);
                    } else {
                        $member = $this->teacher->select('teacher_name name, teacher_image image')->find($sess['id']);
                    }

                    if ((new ChatModel())->insert($ins)) {
                        $D = [
                            'success' => TRUE,
                            'message' => 'Success',
                            'transaction_id' => $data['transaction_id'],
                            'level' => $sess['level'],
                            'image' => $member['image'],
                            'name' => $member['name'],
                            'chat_text' => $data['chat_text'],
                            'chat_image' => $namaGambar,
                            'time' => igDate($ins['chat_date']),
                            'type' => 'text',
                        ];

                        if ($namaGambar) {
                            $D['type'] = 'image';
                        }
                    }
                } else {
                    $D = [
                        'transaction_id' => $data['transaction_id'],
                        'success' => true,
                        'expired' => true,
                        'message' => 'Discussion is expired',
                        'level' => $sess['level'],
                    ];
                }
            }

            echo json_encode($D);
        }
    }


    public function profile()
    {

        $ses = session('_ci_user_login');
        $profile = $this->student->find($ses['id']);


        if ($this->request->getMethod() == 'post') {

            $rules = $this->student->getValidationRules(); // get rules
            $password = $this->request->getPost('student_password');
            unset($rules['student_username']);

            if ($password == "") {
                unset($rules['student_password']);
            }

            $this->student->setValidationRules($rules);
            $valid = $this->validate($rules); // validate

            if ($valid) {

                $image = $this->request->getFile('student_image');
                $namaGambar = $profile['student_image'];
                if ($image->getError() != 4) {
                    $namaGambar = $image->getRandomName();
                    $image->move('uploads/images', $namaGambar);

                    if ($profile['student_image'] != 'default_student.png') { // hapus gambar lama
                        try {
                            unlink('uploads/images/' . $profile['student_image']);
                        } catch (\Throwable $th) {
                            //throw $th;
                        }
                    }
                }

                $student = [
                    'student_name' => $this->request->getPost('student_name'),
                    'student_birthdate' => $this->request->getPost('student_birthdate'),
                    'student_phonenumb' => $this->request->getPost('student_phonenumb'),
                    'student_email' => $this->request->getPost('student_email'),
                    'student_image' => $namaGambar,
                ];

                if ($password != "") {
                    $student['student_password'] = password_hash($password, PASSWORD_DEFAULT);
                }

                $upd = $this->student->update($profile['student_id'], $student);

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
        return view($this::$pages . 'v_student_profile', $data);
    }
}
