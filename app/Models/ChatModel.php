<?php

namespace App\Models;

use CodeIgniter\Model;

class ChatModel extends Model
{
    protected $table = 'chat_table';
    protected $primaryKey = 'chat_id';
    protected $allowedFields = ['student_id', 'teacher_id', 'chat_text', 'chat_date', 'transaction_id', 'chat_type', 'chat_image'];
}
