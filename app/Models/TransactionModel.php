<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table = 'transaction_table';
    protected $primaryKey = 'transaction_id';
    protected $allowedFields = ['transaction_id', 'gross_amount', 'status_code', 'transaction_status', 'payment_type', 'transaction_json', 'transaction_time', 'student_id', 'teacher_id', 'transaction_status', 'discuss_date', 'discuss_status', 'quantity', 'duration', 'amount', 'discuss_homebase'];
}
