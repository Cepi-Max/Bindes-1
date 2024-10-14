<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Padi extends ResourceController
{
    protected $modelName = 'App\Models\PadiModel';
    protected $format = 'json';
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $data = [
            'message' => 'success',
            'data_padi' => $this->model->orderBy('id', 'DESC')->findAll()
        ];

        return $this->respond($data, 200);
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        $data = [
            'message' => 'success',
            'padi_byid' => $this->model->find($id)
        ];

        if ($data['padi_byid'] === null) {
            return $this->failNotFound('Data Padi Tidak Ditemukan');
        }

        return $this->respond($data, 200);
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        // Validasi input
        if (!$this->validate([
            'nama_petani' => 'required',
            'nama_pabrik' => 'required',
            'jumlah_padi' => 'required',
            'gambar' => 'max_size[gambar,2048]|uploaded[gambar]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]'
        ])) {
            $response = [
                'message' => $this->validator->getErrors()
            ];
            return $this->failValidationErrors($response);
        }

        $gambar = $this->request->getFile('gambar');
        if (!$gambar->isValid()) {
            return $this->respond([
                'message' => 'Gambar tidak valid'
            ], 400);
        }
        $namaGambar = $gambar->getRandomName();
        $gambar->move('gambar', $namaGambar);

        try {
            $this->model->insert([
                'nama_petani' => esc($this->request->getVar('nama_petani')),
                'nama_pabrik' => esc($this->request->getVar('nama_pabrik')),
                'jumlah_padi' => esc($this->request->getVar('jumlah_padi')),
                'gambar' => $namaGambar
            ]);
            $response = [
                'message' => 'Data Berhasil Ditambahkan'
            ];
            return $this->respondCreated($response);
        } catch (\Exception $e) {
            return $this->respond([
                'message' => 'Gagal menambahkan data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        $rules = $this->validate([
            'nama_petani' => 'required',
            'nama_pabrik' => 'required',
            'jumlah_padi' => 'required',
            // 'gambar' => 'max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]'
    ]);
        if (!$rules) {
            $response = [
                'message' => $this->validator->getErrors()
            ];
            return $this->failValidationErrors($response);
        }

        // $gambar = $this->request->getFile('gambar');
        // $gambarLama = $this->request->getPost('gambarLama');

        // if ($gambar) {
        //     if (!$gambar->isValid()) {
        //         return $this->respond([
        //             'message' => 'Gambar tidak valid'
        //         ], 400);
        //     }
        //     $namaGambar = $gambar->getRandomName();
        //     $gambar->move('gambar', $namaGambar);
        //     unlink('gambar/' . $gambarLama);
        // } else {
        //     $namaGambar = $this->request->getPost('gambarLama');
        // }
        try {
            $this->model->update($id, [
                'nama_petani' => esc($this->request->getVar('nama_petani')),
                'nama_pabrik' => esc($this->request->getVar('nama_pabrik')),
                'jumlah_padi' => esc($this->request->getVar('jumlah_padi')),
                // 'gambar' => $namaGambar,
            ]);
            $response = [
                'message' => 'Data Berhasil Diubah'
            ];
            return $this->respond($response, 200);
        } catch (\Exception $e) {
            return $this->respond([
                'message' => 'Gagal menambahkan data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        $this->model->delete($id);
        $response = [
         'message' => 'Data Berhasil Dihapus'
    ];
        return $this->respondDeleted($response);
    }
}
