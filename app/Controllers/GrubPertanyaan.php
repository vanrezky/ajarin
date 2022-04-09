<?php

namespace App\Controllers;

class GrubPertanyaan extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Grub Pertanyaan'
        ];

        return view('v_grub_pertanyaan_index', $data);
    }
}
