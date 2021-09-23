<?php

namespace App\Controllers;

class Templating extends BaseController
{
    public function index()
    {
        $data = [
            'title' => "Blog - Post"
        ];
        // echo view('layout/header', $data);
        // echo view('layout/navbar');
        // echo view('v_post');
        // echo view('layout/footer');
        return view('v_admin');
    }
}
