<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PostModel;

class AdminPostsController extends BaseController
{
    public function __construct()
    {
        $this->PostModel = new PostModel();
    }

    public function index()
    {
        $PostModel = model("PostModel");
        $data = [
            'posts' => $PostModel->findAll()
        ];
        return view("posts/index", $data);
    }
    public function create()
    {
        session();
        $data = [
            'validation' => \Config\Services::validation(),
        ];
        return view("posts/create", $data);
    }
    public function store()
    {
        $valid = $this->validate([
            "judul" => [
                "label" => "Judul",
                "rules" => "required",
                "errors" => [
                    "required" => "{field} Harus Diisi!"
                ]
            ],
            "slug" => [
                "label" => "Slug",
                "rules" => "required|is_unique[posts.slug]",
                "errors" => [
                    "required" => "{field} Harus Diisi!",
                    "is_unique" => "{field} Sudah ada!"
                ]
            ],
            "kategori" => [
                "label" => "Kategori",
                "rules" => "required",
                "errors" => [
                    "required" => "{field} Harus Diisi!"
                ]
            ],
            "author" => [
                "label" => "Author",
                "rules" => "required",
                "errors" => [
                    "required" => "{field} Harus Diisi!"
                ]
            ],
            "deskripsi" => [
                "label" => "Deskripsi",
                "rules" => "required",
                "errors" => [
                    "required" => "{field} Harus Diisi!"
                ]
            ],
        ]);

        if ($valid) {
            $data = [
                'judul' => $this->request->getVar('judul'),
                'slug' => $this->request->getVar('slug'),
                'kategori' => $this->request->getVar('kategori'),
                'author' => $this->request->getVar('author'),
                'deskripsi' => $this->request->getVar('deskripsi')
            ];

            $PostModel = model("PostModel");
            $PostModel->insert($data);
            return redirect()->to(base_url('admin/posts'));
        } else {
            return redirect()->to(base_url('admin/posts/create'))->withInput()->with('validation', $this->validator);
        };
    }
    public function delete($post_id)
    {
        $this->PostModel->delete($post_id);
        return redirect()->to(base_url('admin/posts'));
    }

    public function edit($slug)
    {
        session();
        $data = [
            'validation' => \Config\Services::validation(),
            'posts' => $this->PostModel->where(['slug' => $slug])->first()
        ];
        return view('posts/edit', $data);
    }
    public function saveEdit($post_id)
    {
        $request = service('request');
        $this->PostModel->save([
            'post_id' => $post_id,
            'judul' => $request->getVar('judul'),
            'slug' => $request->getVar('slug'),
            'kategori' => $request->getVar('kategori'),
            'author' => $request->getVar('author'),
            'deskripsi' => $request->getVar('deskripsi')
        ]);

        return redirect()->to(base_url('admin/posts'));
    }
}
